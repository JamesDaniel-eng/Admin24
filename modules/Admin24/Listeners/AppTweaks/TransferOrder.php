<?php

namespace Modules\Admin24\Listeners\AppTweaks;

use Modules\Inventory\Events\TransferOrderCreated as Event;
use Modules\Inventory\Models\TransferOrderHistory as ModelHistory;
use Modules\Inventory\Models\History;
use Modules\Inventory\Models\Item as InventoryItem;

class TransferOrder {

    /**
     * Handle the event.No
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event) {
        // Get the transfer order from the event
        $transfer_order = $event->transfer_order;

        \DB::transaction(function () use ($transfer_order) {
            // Process the transfer for all items
            foreach ($transfer_order->transfer_order_items as $transfer_order_item) {
                $source_inventory_item = InventoryItem::where('warehouse_id', $transfer_order->source_warehouse_id)
                                                      ->where('item_id', $transfer_order_item->item_id)
                                                      ->first();

                $destination_inventory_item = InventoryItem::where('warehouse_id', $transfer_order->destination_warehouse_id)
                                                            ->where('item_id', $transfer_order_item->item_id)
                                                            ->first();

                // Update source stock
                $source_quantity = $source_inventory_item->opening_stock - $transfer_order_item->transfer_quantity;
                $source_inventory_item->update(['opening_stock' => $source_quantity]);

                // Create or update destination inventory item
                if (empty($destination_inventory_item)) {
                    $inventory_item_request = [
                        'company_id'          => $source_inventory_item->company_id,
                        'item_id'             => $transfer_order_item->item_id,
                        'opening_stock'       => $transfer_order_item->transfer_quantity,
                        'opening_stock_value' => $transfer_order_item->transfer_quantity,
                        'warehouse_id'        => $transfer_order->destination_warehouse_id,
                        'sku'                 => $source_inventory_item->sku,
                        'created_from'        => $transfer_order->created_from,
                        'created_by'          => $transfer_order->created_by
                    ];

                    $destination_inventory_item = InventoryItem::create($inventory_item_request);
                } else {
                    $destination_quantity = $destination_inventory_item->opening_stock + $transfer_order_item->transfer_quantity;
                    $destination_inventory_item->update(['opening_stock' => $destination_quantity]);
                }

                // Log transfer history for each item
                $source_warehouse_history_request = [
                    'company_id'    => $transfer_order->company_id,
                    'user_id'       => user()->id,
                    'item_id'       => $transfer_order_item->item_id,
                    'type_id'       => $transfer_order->id,
                    'type_type'     => get_class($transfer_order),
                    'warehouse_id'  => $transfer_order->source_warehouse_id,
                    'quantity'      => $transfer_order_item->transfer_quantity,
                ];
                History::create($source_warehouse_history_request);

                $destination_warehouse_history_request = [
                    'company_id'    => $transfer_order->company_id,
                    'user_id'       => user()->id,
                    'item_id'       => $transfer_order_item->item_id,
                    'type_id'       => $transfer_order->id,
                    'type_type'     => get_class($transfer_order),
                    'warehouse_id'  => $transfer_order->destination_warehouse_id,
                    'quantity'      => $transfer_order_item->transfer_quantity,
                ];
                History::create($destination_warehouse_history_request);
            }

            // Mark transfer order as transferred
            $transfer_order->update(['status' => 'transferred']);

            // Create transfer order history
            $transfer_history = [
                'company_id'         => company_id(),
                'created_by'         => user()->id,
                'transfer_order_id'  => $transfer_order->id,
                'status'             => 'transferred',
                'created_from'       => $transfer_order->created_from,
            ];
            ModelHistory::create($transfer_history);
        });
    }
}