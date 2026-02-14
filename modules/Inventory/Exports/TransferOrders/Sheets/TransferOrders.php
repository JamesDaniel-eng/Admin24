<?php

namespace Modules\Inventory\Exports\TransferOrders\Sheets;

use App\Abstracts\Export;
use Modules\Inventory\Models\TransferOrder as Model;

class TransferOrders extends Export
{
    public function collection()
    {
        $model = Model::usingSearchString(request('search'));

        if (! empty($this->ids)) {
            $model->whereIn('id', (array) $this->ids);
        }

        return $model->cursor();
    }

    public function map($model): array
    {
        $model->source_warehouse_name = $model->source_warehouse->name;
        $model->destination_warehouse_name = $model->destination_warehouse->name;
        $model->transfer_order_date = $model->date;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'transfer_order_number',
            'transfer_order_date',
            'transfer_order',
            'status',
            'source_warehouse_name',
            'destination_warehouse_name',
            'reason',
        ];
    }
}
