<?php

namespace Modules\DoubleEntry\Exports\JournalEntry\Sheets;

use App\Abstracts\Export;
use Modules\DoubleEntry\Models\Ledger;
use App\Models\Banking\Account as Model;
use Modules\DoubleEntry\Models\AccountBank;

class Accounts extends Export
{
    public function collection()
    {
        $account_ids = Ledger::where('ledgerable_type', 'Modules\DoubleEntry\Models\Journal');

        if ($this->ids) {
            $account_ids = $account_ids->whereIn('ledgerable_id', $this->ids);
        }

        $account_ids = $account_ids->pluck('account_id')->toArray();

        $bank_ids = AccountBank::whereIn('account_id', $account_ids)->pluck('bank_id')->toArray();

        return Model::whereIn('id', $bank_ids)->with('de_bank_account', 'de_bank_account.account')->cursor();
    }

    public function map($model): array
    {
        $model->coa_code = $model->de_bank_account->account->code;
        $model->number = $model->number ?? rand(100000000, 999999999);

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'type',
            'name',
            'number',
            'currency_code',
            'opening_balance',
            'bank_name',
            'bank_phone',
            'bank_address',
            'coa_code',
            'enabled',
            'created_from',
            'created_by',
        ];
    }
}
