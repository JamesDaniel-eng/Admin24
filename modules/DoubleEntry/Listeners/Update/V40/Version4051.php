<?php

namespace Modules\DoubleEntry\Listeners\Update\V40;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Common\Company;
use Modules\DoubleEntry\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Version4051 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.0.51';

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
            ->groupBy('ledgerable_id')
            ->havingRaw('COUNT(*) > 1')
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

        $ledgers = Ledger::where('ledgerable_type', 'App\Models\Banking\Transaction')
            ->groupBy('ledgerable_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($ledgers as $ledger) {
            $transaction = $ledger->ledgerable;

            if (! $transaction) {
                continue;
            }

            if (! in_array($transaction->type, ['income-transfer', 'expense-transfer'])) {
                continue;
            }

            $this->updateLedger($ledger);
        }

        Log::channel('stderr')->info('Ledgers updated...');
    }

    public function updateLedger($ledger)
    {
        Log::channel('stderr')->info('Updating ledger: ' . $ledger->id);

        Ledger::where('ledgerable_type', 'App\Models\Banking\Transaction')
            ->where('ledgerable_id', $ledger->ledgerable_id)
            ->whereNotIn('id', function ($query) use ($ledger) {
                $query->selectRaw('MAX(id)')
                    ->from('double_entry_ledger')
                    ->where('ledgerable_type', 'App\Models\Banking\Transaction')
                    ->where('ledgerable_id', $ledger->ledgerable_id);
            })
            ->delete();

        Log::channel('stderr')->info('Ledger updated: ' . $ledger->id);
    }
}
