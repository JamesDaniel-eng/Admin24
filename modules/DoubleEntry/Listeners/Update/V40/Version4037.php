<?php

namespace Modules\DoubleEntry\Listeners\Update\V40;

use App\Traits\Jobs;
use App\Models\Common\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\Artisan;
use Modules\DoubleEntry\Models\Journal;
use Modules\DoubleEntry\Traits\Journal as TraitJournal;
use App\Abstracts\Listeners\Update as Listener;

class Version4037 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.0.37';

    use Jobs, TraitJournal;

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

        $this->updateDatabase();

        $company_ids = DB::table('double_entry_journals')
            ->groupBy('company_id')
            ->pluck('company_id');

        foreach ($company_ids as $company_id) {
            Log::channel('stderr')->info('Updating company: ' . $company_id);

            $company = Company::find($company_id);

            if (! $company instanceof Company) {
                continue;
            }

            $company->makeCurrent();

            $this->updateJournals();

            Log::channel('stderr')->info('Company updated: ' . $company_id);
        }
    }

    protected function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }

    protected function updateJournals()
    {
        $journals = Journal::cursor();

        foreach ($journals as $journal) {
            if (empty($journal->currency_code) || empty($journal->currency_rate)) {
                continue;
            }

            foreach ($journal->ledgers as $ledger) {
                if (! $this->getBank($ledger)) {
                    continue;
                }

                if ($transaction = $this->getTransaction($ledger)) {
                    $transaction->update([
                        'currency_code' => $journal->currency_code,
                        'currency_rate' => $journal->currency_rate,
                    ]);
                }
            }
        }
    }
}
