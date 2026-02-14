<?php

namespace Modules\Inventory\Exports\TransferOrders\Sheets;

use App\Abstracts\Export;
use App\Models\Common\Item as Model;
use Modules\Inventory\Models\TransferOrderItem;

class Items extends Export
{
    public function collection()
    {
        $item_ids = TransferOrderItem::pluck('item_id')->unique()->toArray();

        $model = Model::whereIn('id', $item_ids)->with('category')->usingSearchString(request('search'));

        // if (!empty($this->ids)) {
        //     $model->whereIn('id', (array) $this->ids);
        // }

        return $model->cursor();
    }

    public function map($model): array
    {
        $model->category_name = $model->category->name;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'name',
            'type',
            'description',
            'sale_price',
            'purchase_price',
            'category_name',
            'enabled',
        ];
    }
}
