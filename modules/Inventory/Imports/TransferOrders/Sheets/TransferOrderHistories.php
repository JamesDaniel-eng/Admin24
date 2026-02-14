<?php

namespace Modules\Inventory\Imports\TransferOrders\Sheets;

use App\Abstracts\Import;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\TransferOrder;
use Modules\Inventory\Jobs\Warehouses\CreateWarehouse;
use Modules\Inventory\Models\TransferOrderHistory as Model;

class TransferOrderHistories extends Import
{
    public function model(array $row)
    {
        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        $row['transfer_order_id'] = TransferOrder::where('transfer_order_number', $row['transfer_order_number'])->first()?->id;

        return $row;
    }
}
