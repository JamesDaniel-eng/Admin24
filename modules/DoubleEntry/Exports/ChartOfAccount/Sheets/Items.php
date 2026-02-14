<?php

namespace Modules\DoubleEntry\Exports\ChartOfAccount\Sheets;

use App\Abstracts\Export;
use App\Models\Common\Item as Model;
use Modules\DoubleEntry\Models\AccountItem;
use App\Http\Requests\Common\Item as Request;

class Items extends Export
{
    public $request_class = Request::class;

    public function collection()
    {
        $item_ids = new AccountItem();

        if ($this->ids) {
            $item_ids = $item_ids->whereIn('account_id', $this->ids);
        }

        $item_ids = $item_ids->pluck('item_id')->toArray();

        return Model::whereIn('id', $item_ids)
            ->with('category', 'de_income_account', 'de_income_account.account','de_expense_account', 'de_expense_account.account')
            ->cursor();
    }

    public function map($model): array
    {
        $model->income_account_code = $model->de_income_account->account->code ?? null;      
        $model->expense_account_code = $model->de_expense_account->account->code ?? null;
        $model->category_name = $model->category->name ?? null;

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
            'income_account_code',
            'expense_account_code',
            'enabled',
            'created_from',
            'created_by',
        ];
    }
}
