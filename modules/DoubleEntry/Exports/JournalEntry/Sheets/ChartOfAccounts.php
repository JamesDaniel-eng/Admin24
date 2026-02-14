<?php

namespace Modules\DoubleEntry\Exports\JournalEntry\Sheets;

use App\Abstracts\Export;
use Modules\DoubleEntry\Models\Account as Model;
use Modules\DoubleEntry\Models\Ledger;

class ChartOfAccounts extends Export
{
    public function collection()
    {
        $account_ids = Ledger::where('ledgerable_type', 'Modules\DoubleEntry\Models\Journal');

        if ($this->ids) {
            $account_ids = $account_ids->whereIn('ledgerable_id', $this->ids);
        }

        $account_ids = $account_ids->pluck('account_id')->toArray();

        return Model::whereIn('id', $account_ids)
            ->with('type', 'declass')
            ->cursor();
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
