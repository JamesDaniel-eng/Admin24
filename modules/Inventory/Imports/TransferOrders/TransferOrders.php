<?php

namespace Modules\Inventory\Imports\TransferOrders;

use App\Abstracts\ImportMultipleSheets;
use Modules\Inventory\Imports\Items\Sheets\Items;
use Modules\Inventory\Imports\Warehouses\Warehouses;
use Modules\Inventory\Imports\Items\Sheets\Warehouses as ItemWarehouses;
use Modules\Inventory\Imports\TransferOrders\Sheets\TransferOrderItems;
use Modules\Inventory\Imports\TransferOrders\Sheets\TransferOrderHistories;
use Modules\Inventory\Imports\TransferOrders\Sheets\TransferOrders as Base;

class TransferOrders extends ImportMultipleSheets
{
    public function sheets(): array
    {
        return [
            'warehouses'                => new Warehouses(),
            'items'                     => new Items(),
            'item_warehouses'           => new ItemWarehouses(),
            'transfer_orders'           => new Base(),
            'transfer_order_items'      => new TransferOrderItems(),
            'transfer_order_histories'  => new TransferOrderHistories(),
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
