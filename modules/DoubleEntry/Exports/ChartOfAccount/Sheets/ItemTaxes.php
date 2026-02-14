<?php

namespace Modules\DoubleEntry\Exports\ChartOfAccount\Sheets;

use App\Abstracts\Export;
use Modules\DoubleEntry\Models\AccountItem;
use App\Models\Common\ItemTax as Model;

class ItemTaxes extends Export
{
    public function collection()
    {
        $item_ids = new AccountItem();

        if ($this->ids) {
            $item_ids = $item_ids->whereIn('account_id', $this->ids);
        }

        $item_ids = $item_ids->pluck('item_id')->toArray();
        
        return Model::whereIn('item_id', $item_ids)->with('item', 'tax')->cursor();
    }

    public function map($model): array
    {
        $item = $model->item;

        if (empty($item)) {
            return [];
        }

        $model->item_name = $model->item->name;
        $model->tax_name = $model->tax->name;
        $model->tax_rate = $model->tax->rate;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'item_name',
            'tax_name',
            'tax_rate',
            'created_from',
            'created_by',
        ];
    }
}
