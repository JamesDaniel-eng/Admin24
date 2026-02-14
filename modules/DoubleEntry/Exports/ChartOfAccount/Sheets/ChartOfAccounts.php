<?php

namespace Modules\DoubleEntry\Exports\ChartOfAccount\Sheets;

use App\Abstracts\Export;
use Modules\DoubleEntry\Models\Account as Model;

class ChartOfAccounts extends Export
{
    public function collection()
    {
        return Model::with('type', 'declass')->collectForExport($this->ids, ['code' => 'desc']);
    }

    public function map($model): array
    {
        $model->type = trans($model->type->name);
        $model->class = trans($model->declass->name);
        $model->name = $model->trans_name;
        $model->balance = (string) $model->balance;

        if (!is_null($model->account_id)) {
            $parent_account = Model::find($model->account_id, ['name']);

            $model->parent = $parent_account->trans_name;
        }

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'type',
            'class',
            'code',
            'name',
            'description',
            'enabled',
            'parent',
            'balance',
            'created_from',
            'created_by',
        ];
    }
}
