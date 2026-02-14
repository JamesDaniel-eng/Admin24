<?php

namespace Modules\Inventory\Observers\Document;

use App\Abstracts\Observer;
use App\Models\Document\DocumentItem as DocumentItemModel;
use App\Models\Common\Company;
use App\Models\Document\Document;
use App\Traits\Modules;
use App\Traits\Jobs;
use Modules\Inventory\Models\DocumentItem as InventoryDocumentItem;
use Modules\Inventory\Models\History;
use Modules\Inventory\Jobs\Items\CreateInventoryItem;
use Modules\Inventory\Jobs\Histories\CreateHistory;
use Illuminate\Support\Str;

class DocumentItem extends Observer
{
    use Modules, Jobs;

     /**
     * Listen to the created event.
     *
     * @param  DocumentItemModel $document_item
     *
     * @return void
     */
    public function created(DocumentItemModel $document_item)
    {
        if (! $this->moduleIsEnabled('inventory')) {
            return;
        }

        $user = user();

        if (! $user) {
            $company = Company::find($document_item->company_id);

            $user = $company->users()->first();
        }

        $item = $document_item->item;

        if (! $item) {
            return;
        }

        $stock_action = config('type.document.' . $document_item->type . '.inventory_stock_action');

        if (! $stock_action) {
            return;
        }

        $request = request();

        $clone = $request->is('*/duplicate');

        if (! $request->items && $clone == false) {
            if ((request()->is('*/import') || Str::contains($document_item->created_from, 'import')) && setting('inventory.track_inventory') == true) {
                $this->importTrackInventory($document_item, $user, $item, $stock_action);
            }
            return;
        }

        $segments = $request->segments();

        if (isset($segments[3]) && !isset($segments[4])) {
            return;
        }

        if ($clone) {
            $request = Document::find($segments[3]);

            if ($request->type == 'invoice' || !$request->type == 'bill') {
                foreach ($request->items as $request_item) {
                    $warehouse_id = InventoryDocumentItem::where('document_id', $request_item->document_id)->where('item_id', $request_item->item_id)->value('warehouse_id');
                    if ($warehouse_id) {
                        $request_item->warehouse_id = $warehouse_id;
                    }
                }
            }
        }

        foreach ($request->items as $inventory_item) {
            $inv_document_item = InventoryDocumentItem::where('document_item_id', $document_item->id)->first();

            if ($inv_document_item || ! isset($inventory_item['name'])) {
                continue;
            }

            if ($inventory_item['name'] !== $item->name || (int) $inventory_item['quantity'] !== (int) $document_item->quantity) {
                continue;
            }

            if (isset($inventory_item['unit'])) {
                $this->createInventoryItem($document_item, $item, $inventory_item, $user);
            }

            if (isset($inventory_item['warehouse_id'])) {
                $this->createInventoryDocumentItem($document_item, $inventory_item, $user);
            }
        }
    }

    /**
     * Listen to the deleted event.
     *
     * @param  DocumentItemModel $document_item
     *
     * @return void
     */
    public function deleted(DocumentItemModel $document_item)
    {
        if (!$this->moduleIsEnabled('inventory')) {
            return;
        }

        $item = $document_item->item;

        if (!$item) {
            return;
        }

        $inventory_document_item = InventoryDocumentItem::where('document_item_id', $document_item->id)->first();

        if (!$inventory_document_item) {
            return;
        }

        $inventory_item = $item->inventory()
            ->where('item_id', $inventory_document_item->item_id)
            ->where('warehouse_id', $inventory_document_item->warehouse_id)
            ->first();

        $stock_action = config('type.document.' . $document_item->type . '.inventory_stock_action');

        if (! $inventory_item ||! $stock_action || in_array($document_item->document->status, ['draft', 'cancelled']) ) {
            return;
        }

        if ($stock_action == 'decrease') {
            $inventory_item->opening_stock += (float) $document_item->quantity;
        } else {
            $inventory_item->opening_stock -= (float) $document_item->quantity;
        }

        $inventory_item->save();

        History::where('type_type', get_class($document_item))
                ->where('type_id', $document_item->id)
                ->delete();
    }

    public function createInventoryItem($document_item, $item, $inventory_item, $user)
    {
        $item_data = [
            'company_id'            => $document_item->company_id,
            'item_id'               => $document_item->item_id,
            'opening_stock'         => $inventory_item['quantity'],
            'opening_stock_value'   => $inventory_item['quantity'],
            'reorder_level'         => 0,
            'warehouse_id'          => $inventory_item['warehouse_id'],
            'default_warehouse'     => true,
            'sku'                   => rand(1000, 10000),
            'unit'                  => $inventory_item['unit'],
            'returnable'            => false,
            'created_from'          => source_name('inventory'),
            'created_by'            => $user->id,
        ];

        $this->dispatch(new CreateInventoryItem($item_data));

        $history_data = [
            'company_id'    => $document_item->company_id,
            'user_id'       => $user->id,
            'item_id'       => $document_item->item_id,
            'type_id'       => $document_item->item_id,
            'type_type'     => get_class($item),
            'warehouse_id'  => $inventory_item['warehouse_id'],
            'quantity'      => $inventory_item['quantity'],
            'created_from'  => source_name('inventory'),
            'created_by'    => $user->id,
        ];

        $this->dispatch(new CreateHistory($history_data));
    }

    public function createInventoryDocumentItem($document_item, $inventory_item, $user)
    {
        InventoryDocumentItem::where('document_item_id', $document_item->id)->delete();

        InventoryDocumentItem::create([
            'company_id'        => $document_item->company_id,
            'type'              => $document_item->type,
            'document_id'       => $document_item->document_id,
            'document_item_id'  => $document_item->id,
            'item_id'           => $document_item->item_id,
            'warehouse_id'      => $inventory_item['warehouse_id'],
            'quantity'          => $inventory_item['quantity'],
            'created_from'      => source_name('inventory'),
            'created_by'        => $user->id,
        ]);
    }

    public function importTrackInventory($document_item, $user, $item, $stock_action)
    {
        $inv_document_item = InventoryDocumentItem::where('document_item_id', $document_item->id)->first();
    
        if ($inv_document_item ) {
            return;
        }
        
        $inventory_item = $item->inventory()->where('item_id', $document_item->item_id)->first();

        if (! $inventory_item) { 
            $item_data = [
                'company_id'            => $document_item->company_id,
                'item_id'               => $document_item->item_id,
                'opening_stock'         => 0,
                'opening_stock_value'   => 0,
                'reorder_level'         => 0,
                'warehouse_id'          => setting('inventory.default_warehouse'),
                'default_warehouse'     => true,
                'sku'                   => rand(1000, 10000),
                'unit'                  => setting('inventory.default_unit'),
                'returnable'            => false,
                'created_from'          => source_name('inventory'),
                'created_by'            => $user->id,
            ];

            $this->dispatch(new CreateInventoryItem($item_data));

            $history_data = [
                'company_id'    => $document_item->company_id,
                'user_id'       => $user->id,
                'item_id'       => $document_item->item_id,
                'type_id'       => $document_item->item_id,
                'type_type'     => get_class($item),
                'warehouse_id'  => setting('inventory.default_warehouse'),
                'quantity'      => 0,
                'created_from'  => source_name('inventory'),
                'created_by'    => $user->id,
            ];

            $this->dispatch(new CreateHistory($history_data));
        }

        InventoryDocumentItem::where('document_item_id', $document_item->id)->delete();

        InventoryDocumentItem::create([
            'company_id'        => $document_item->company_id,
            'type'              => $document_item->type,
            'document_id'       => $document_item->document_id,
            'document_item_id'  => $document_item->id,
            'item_id'           => $document_item->item_id,
            'warehouse_id'      => setting('inventory.default_warehouse'),
            'quantity'          => $document_item->quantity,
            'created_from'      => source_name('inventory'),
            'created_by'        => $user->id,
        ]);

        if (! in_array($document_item->document->status, ['paid', 'partial', 'sent', 'received', 'viewed', 'processed'])) {
            return;
        }

        $inventory_item = $item->inventory()->where('item_id', $document_item->item_id)->first();

        if (empty($inventory_item)) {
            return;
        }

        if ($stock_action == 'decrease') {
            $inventory_item->opening_stock -= (float) $document_item->quantity;
        } else {
            $inventory_item->opening_stock += (float) $document_item->quantity;
        }

        $inventory_item->save();

        History::where('type_type', get_class($document_item))
            ->where('type_id', $document_item->id)
            ->where('warehouse_id', $inventory_item->warehouse_id)
            ->delete();

        $history_data =[
            'company_id'    => $document_item->company_id,
            'user_id'       => $user->id,
            'item_id'       => $document_item->item->id,
            'type_id'       => $document_item->id,
            'type_type'     => get_class($document_item),
            'warehouse_id'  => $inventory_item->warehouse_id,
            'quantity'      => $document_item->quantity,
            'created_from'  => source_name('inventory'),
            'created_by'    => $user->id,
        ];

        $this->dispatch(new CreateHistory($history_data));
    }
}
