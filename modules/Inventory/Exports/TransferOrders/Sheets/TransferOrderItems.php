<?php

namespace Modules\Inventory\Exports\TransferOrders\Sheets;

use App\Abstracts\Export;
use Modules\Inventory\Models\TransferOrderItem as Model;

class TransferOrderItems extends Export
{
    public function collection()
    {
        $model = Model::usingSearchString(request('search'));

        if (! empty($this->ids)) {
            $model->whereIn('transfer_order_id', (array) $this->ids);
        }

        return $model->cursor();
    }

    public function map($model): array
    {
        $model->item_name = $model->item->name;
        $model->transfer_order_number = $model->transfer_order->transfer_order_number;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'item_name',
            'transfer_order_number',
            'item_quantity',
            'transfer_quantity',
        ];
    }
}
