<?php

namespace Modules\Inventory\Imports\TransferOrders\Sheets;

use App\Abstracts\Import;
use App\Models\Common\Item;
use Modules\Inventory\Models\TransferOrder;
use Modules\Inventory\Models\TransferOrderItem as Model;

class TransferOrderItems extends Import
{
    public function model(array $row)
    {
        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        $row['transfer_order_id'] = TransferOrder::where('transfer_order_number', $row['transfer_order_number'])->first()?->id;
        $row['item_id'] = Item::where('name', $row['item_name'])->first()?->id;
    
        return $row;
    }
}
