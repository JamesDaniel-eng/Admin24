<?php

namespace Modules\Inventory\Exports\TransferOrders;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Inventory\Exports\TransferOrders\Sheets\Items;
use Modules\Inventory\Exports\TransferOrders\Sheets\Warehouses;
use Modules\Inventory\Exports\TransferOrders\Sheets\ItemWarehouses;
use Modules\Inventory\Exports\TransferOrders\Sheets\TransferOrderItems;
use Modules\Inventory\Exports\TransferOrders\Sheets\TransferOrderHistories;
use Modules\Inventory\Exports\TransferOrders\Sheets\TransferOrders as Base;

class TransferOrders implements WithMultipleSheets
{
    use Exportable;

    public $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function sheets(): array
    {
        return [
            new Base($this->ids),
            new TransferOrderItems($this->ids),
            new TransferOrderHistories($this->ids),
            new Warehouses($this->ids),
            new Items($this->ids),
            new ItemWarehouses($this->ids),
        ];
    }
}
