<?php

namespace Modules\Inventory\Listeners\Document;

use App\Events\Document\DocumentMarkedSent as Event;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\Inventory\Models\DocumentItem as InventoryDocumentItem;
use Modules\Inventory\Models\Item as InventoryItem;
use Modules\Inventory\Models\History as InventoryHistory;
use Modules\Inventory\Jobs\Histories\CreateHistory;
use Modules\Inventory\Traits\Inventory;

class DocumentMarkedSent
{
    use Modules, Jobs, Inventory;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! $this->moduleIsEnabled('inventory')) {
            return;
        }

        $document = $event->document;

        // To do: The document senting event should be listened to.
        if ($this->hasMultipleHistoriesWithStatus($document->histories, 'sent')) {
            return;
        }

        if ($document->status === 'paid'
            && $document->amount !== 0
            && $this->hasMultipleHistoriesWithStatus($document->histories, 'paid')
        ) {
            return;
        }

        $inventory_stock_action = config('type.document.' . $document->type . '.inventory_stock_action');

        if (in_array($document->status, ['cancelled', 'partial', 'viewed']) || empty($inventory_stock_action)) {
            return;
        }

        $user = user();
        $user_id = !empty($user) ? $user->id : 0;

        foreach ($document->items as $item) {
            $warehouse_id = InventoryDocumentItem::where('document_id', $document->id)->where('document_item_id', $item->id)->value('warehouse_id');

            $inventory_item = InventoryItem::where('warehouse_id', $warehouse_id)->where('item_id', $item->item_id)->first();

            if (empty($inventory_item)) {
                continue;
            }

            if ($inventory_stock_action == 'decrease') {
                $inventory_item->opening_stock -= (float) $item->quantity;
            } else {
                $inventory_item->opening_stock += (float) $item->quantity;
            }

            $inventory_item->save();

            InventoryHistory::where('type_type', get_class($item))
                ->where('type_id', $item->id)
                ->where('warehouse_id', $warehouse_id)
                ->where('item_id', $inventory_item->item->id)
                ->delete();

            $history_data = [
                'company_id'    => $item->company_id,
                'user_id'       => $user_id,
                'item_id'       => $item->item->id,
                'type_id'       => $item->id,
                'type_type'     => get_class($item),
                'warehouse_id'  => !empty($warehouse_id) ? $warehouse_id : setting('inventory.default.warehouse'),
                'quantity'      => $item->quantity,
            ];

            $this->ajaxDispatch(new CreateHistory($history_data));
        }
    }
}
