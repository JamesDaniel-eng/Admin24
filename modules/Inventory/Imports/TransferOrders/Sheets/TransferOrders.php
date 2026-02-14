<?php

namespace Modules\Inventory\Imports\TransferOrders\Sheets;

use App\Abstracts\Import;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\TransferOrder as Model;
use Modules\Inventory\Jobs\Warehouses\CreateWarehouse;
use Modules\Inventory\Http\Requests\TransferOrder as Request;

class TransferOrders extends Import
{
    public function model(array $row)
    {
        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        $row['source_warehouse_id'] = $this->getWarehouseId($row, 'source_warehouse_name');
        $row['destination_warehouse_id'] = $this->getWarehouseId($row, 'destination_warehouse_name');
        $row['date'] = $row['transfer_order_date'];

        return $row;
    }

    public function rules(): array
    {
        return (new Request())->rules();
    }

    public function getWarehouseId($row, $key)
    {
        $warehouse = Warehouse::where('name', $row[$key])->first();

        if (! $warehouse) {
            $data = [
                'company_id'    => company_id(),
                'name'          => $row[$key],
                'enabled'       => 1,
                'created_from'  => 'inventory::import',
                'created_by'    => user()->id,
            ];
            
            $warehouse = $this->dispatch(new CreateWarehouse($data));
        }

        return $warehouse ? $warehouse->id : null;
    }
}
