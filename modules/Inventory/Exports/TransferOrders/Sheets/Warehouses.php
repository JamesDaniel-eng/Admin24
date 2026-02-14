<?php

namespace Modules\Inventory\Exports\TransferOrders\Sheets;

use App\Abstracts\Export;
use Modules\Inventory\Models\TransferOrder;
use Modules\Inventory\Models\Warehouse as Model;

class Warehouses extends Export
{
    public function collection()
    {
        $source_warehouse = TransferOrder::pluck('source_warehouse_id')->unique()->toArray();
        $destination_warehouse = TransferOrder::pluck('destination_warehouse_id')->unique()->toArray();

        $warehouse_ids = array_unique(array_merge($source_warehouse, $destination_warehouse));

        $model = Model::whereIn('id', $warehouse_ids)->usingSearchString(request('search'));

        // if (!empty($this->ids)) {
        //     $model->whereIn('id', (array) $this->ids);
        // }

        return $model->cursor();
    }

    public function map($model): array
    {
        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'name',
            'email',
            'phone',
            'address',
            'enabled',
        ];
    }
}
