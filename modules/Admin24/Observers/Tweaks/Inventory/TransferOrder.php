<?php

namespace Modules\Admin24\Observers\Tweaks\Inventory;

use App\Abstracts\Observer;
use Modules\Inventory\Models\TransferOrder as TOrder;
use Modules\Admin24\Jobs\TransferOrders\TransferOrderTransferred as Transferred;

class TransferOrder extends Observer
{
    public function created(TOrder $transfer_order): void
    {
        if($transfer_order->created_from === 'inventory::ui'){
            $transferred = new Transferred($transfer_order);
            $transferred->handle();
        }
    }

    public function retrieved(TOrder $transfer_order): void
    {
        // Ensure relationships are loaded to prevent lazy loading
        if(!$transfer_order->relationLoaded('transfer_order_items')){
            $transfer_order->load('transfer_order_items.item');
        }
        
        // Calculate the total transfer amount using the calculated attributes from items
        $transfer_total = 0;
        foreach($transfer_order->transfer_order_items as $item){
            $transfer_total += ($item->calculated_total_amt ?? 0);
        }
        
        $transfer_order['total_transfer'] = $transfer_total;
    }

    public function updating(TOrder $transfer_order): void
    {
        if(!empty($transfer_order['total_transfer'])){
            unset($transfer_order['total_transfer']);
        }
    }
}