<?php

namespace Modules\CompositeItems\Listeners\Document;

use App\Events\Banking\TransactionCreated as Event;
use App\Traits\Modules;
use App\Traits\Jobs;
use Modules\Inventory\Jobs\Histories\CreateHistory;
use Modules\Inventory\Models\History as InventoryHistory;
use Modules\CompositeItems\Models\DocumentItem as CompDocumentItem;
use Modules\Inventory\Models\Item as InventoryItem;

class Transaction
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

        if (! $event->transaction->document_id) {
            return;
        }

        $inventory_stock_action = config('type.document.' . $event->transaction->document->type . '.inventory_stock_action');

        $return_statuses = ['sent', 'received', 'partial', 'viewed', 'processed'];

        if (empty($inventory_stock_action) || in_array($event->transaction->document->status, $return_statuses)) {
            return;
        }

        $user = user();

        foreach ($event->transaction->document->items as $document_item) {
            $comp_doc_items = CompDocumentItem::where('document_item_id', $document_item->id)->whereNotNull('warehouse_id')->get();

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
                    $inventory_item->opening_stock -= (float) $document_item->quantity;
                } else {
                    $inventory_item->opening_stock += (float) $document_item->quantity;
                }

                $inventory_item->save();

                InventoryHistory::where('type_type', get_class($document_item))
                ->where('type_id', $document_item->id)
                ->delete();

                $history_data = [
                    'company_id' => $document_item->company_id,
                    'user_id' => $user->id,
                    'item_id' => $document_item->item->id,
                    'type_id' => $document_item->id,
                    'type_type' => get_class($document_item),
                    'warehouse_id'  => $comp_doc_item->warehouse_id ?? setting('inventory.default.warehouse'),
                    'quantity' => $document_item->quantity,
                ];

                $this->ajaxDispatch(new CreateHistory($history_data));
            }
        }

    }
}
