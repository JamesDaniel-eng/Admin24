<?php

namespace Modules\DoubleEntry\Listeners\Update\V40;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Common\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\DoubleEntry\Models\Ledger;

class Version4055 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.0.55';

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
            ->where('ledgerable_type', 'App\Models\Document\DocumentItem')
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

        $ledgers = Ledger::where('ledgerable_type', 'App\Models\Document\DocumentItem')
            ->get();

        foreach ($ledgers as $ledger) {
            $document_item = $ledger->ledgerable;

            if (! $document_item) {
                continue;
            }

            if (! isset($document_item->discount_rate) && empty($document_item->discount_rate)) {
                continue;
            }

            $label = 'debit';

            if (! is_null($ledger->credit)) {
                $label = 'credit';
            }

            if (! empty($document_item->discount_rate)) {
                $total = $ledger->$label;

                if ($document_item->discount_type === 'percentage') {
                    $total -= ($total * ($document_item->discount / 100));
                } else {
                    $total -= $document_item->discount;
                }

                $ledger->update([
                    $label => $total,
                ]);
            }
        }

        Log::channel('stderr')->info('Ledgers updated...');
    }
}
