<?php

namespace Modules\CompositeItems\Listeners\Document;

use App\Traits\Jobs;
use App\Traits\Modules;
use App\Events\Document\DocumentReceived as Event;
use Modules\CompositeItems\Models\DocumentItem as CompDocumentItem;
use Modules\Inventory\Jobs\Histories\CreateHistory;
use Modules\Inventory\Models\Item as InventoryItem;
use Modules\Inventory\Models\History as InventoryHistory;

class DocumentReceived
{
    use Modules, Jobs;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! $this->moduleIsEnabled('composite-items') && ! $this->moduleIsEnabled('inventory')) {
            return;
        }

        $document = $event->document;

        // To do: The document senting event should be listened to.
        if ($document->histories->where('status', 'received')->count() > 1) {
            return;
        }

        if ($document->status === 'paid'
            && $document->amount !== 0
            && $document->histories->where('status', 'paid')->count() > 1
        ) {
            return;
        }

        $inventory_stock_action = config('type.document.' . $document->type . '.inventory_stock_action');

        if (in_array($document->status, ['cancelled', 'partial', 'viewed']) || empty($inventory_stock_action)) {
            return;
        }

        $user = user();
        $user_id = !empty($user) ? $user->id : 0;

        foreach ($event->document->items as $item) {
            $comp_doc_items = CompDocumentItem::where('document_item_id', $item->id)->whereNotNull('warehouse_id')->get();

            if (! $comp_doc_items->count()) {
                continue;
            }

            foreach ($comp_doc_items as $comp_doc_item) {
                $inventory_item = InventoryItem::where('item_id', $comp_doc_item->item_id)
                    ->where('warehouse_id', $comp_doc_item->warehouse_id)
                    ->first();

                if (! $inventory_item) {
                    continue;
                }

                if ($inventory_stock_action == 'decrease') {
                    $inventory_item->opening_stock -= (float) $comp_doc_item->quantity;
                } else {
                    $inventory_item->opening_stock += (float) $comp_doc_item->quantity;
                }

                $inventory_item->save();

                InventoryHistory::where('type_type', get_class($item))
                    ->where('type_id', $item->id)
                    ->where('item_id', $inventory_item->item->id)
                    ->where('warehouse_id', $comp_doc_item->warehouse_id)
                    ->delete();

                $history_data = [
                    'company_id'    => $item->company_id,
                    'user_id'       => $user_id,
                    'item_id'       => $inventory_item->item->id,
                    'type_id'       => $item->id,
                    'type_type'     => get_class($item),
                    'warehouse_id'  => $comp_doc_item->warehouse_id ?? setting('inventory.default.warehouse'),
                    'quantity'      => $comp_doc_item->quantity,
                ];

                $this->ajaxDispatch(new CreateHistory($history_data));
            }
        }
    }
}
