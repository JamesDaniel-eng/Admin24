<?php

namespace Modules\Inventory\Exports\TransferOrders\Sheets;

use App\Abstracts\Export;
use Modules\Inventory\Models\TransferOrderHistory as Model;

class TransferOrderHistories extends Export
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
        $model->transfer_order_number = $model->transfer_order->transfer_order_number;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'transfer_order_number',
            'status',
            'created_at',
        ];
    }
}
