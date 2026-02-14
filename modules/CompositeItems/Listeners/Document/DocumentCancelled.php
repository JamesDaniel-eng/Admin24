<?php

namespace Modules\CompositeItems\Listeners\Document;

use App\Traits\Modules;
use App\Events\Document\DocumentCancelled as Event;
use Modules\CompositeItems\Models\DocumentItem as CompDocumentItem;
use Modules\Inventory\Models\Item as InventoryItem;
use Modules\Inventory\Models\History as InventoryHistory;

class DocumentCancelled
{
    use Modules;

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

        $document_status = $event->document->histories()->orderByDesc('created_at')->pluck('status');

        $inventory_stock_action = config('type.document.' . $event->document->type . '.inventory_stock_action');

        if (! $inventory_stock_action || $document_status[1] == 'draft') {
            return;
        }

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
                    $inventory_item->opening_stock += (float) $comp_doc_item->quantity;
                } else {
                    $inventory_item->opening_stock -= (float) $$comp_doc_item->quantity;
                }

                $inventory_item->save();

                InventoryHistory::where('type_type', get_class($item))
                                ->where('type_id', $item->id)
                                ->where('item_id', $inventory_item->item->id)
                                ->where('warehouse_id', $comp_doc_item->warehouse_id)
                                ->delete();
            }
        }
    }
}
