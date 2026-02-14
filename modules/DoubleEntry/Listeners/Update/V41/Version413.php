<?php

namespace Modules\DoubleEntry\Listeners\Update\V41;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Banking\Transaction;
use App\Models\Common\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\DoubleEntry\Models\Ledger;

class Version413 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.1.3';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $company_ids = DB::table('double_entry_ledger')
            ->where('ledgerable_type', 'App\Models\Banking\Transaction')
            ->groupBy('company_id')
            ->pluck('company_id');

        foreach ($company_ids as $company_id) {
            Log::channel('stderr')->info('Updating company: ' . $company_id);

            $company = Company::find($company_id);

            if (! $company instanceof Company) {
                continue;
            }

            $company->makeCurrent();

            $this->updateLedgers();

            Log::channel('stderr')->info('Company updated: ' . $company_id);
        }
    }

    public function updateLedgers()
    {
        Log::channel('stderr')->info('Updating ledgers...');

        $transactions = Transaction::onlyTrashed()->whereIn('type', ['expense-transfer', 'income-transfer'])->get();

        foreach ($transactions as $transaction) {
            Ledger::record($transaction->id, get_class($transaction))->delete();
        }

        Log::channel('stderr')->info('Ledgers updated...');
    }
}
