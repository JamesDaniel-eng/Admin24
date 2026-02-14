<?php

namespace Modules\DoubleEntry\Listeners\Update\V40;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Common\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\DoubleEntry\Models\Ledger;

class Version4053 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.0.53';

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
            ->where('ledgerable_type', 'App\Models\Document\DocumentItemTax')
            ->where('updated_at', '>=', '2024-12-22 00:00:00')
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

        $ledgers = Ledger::where('ledgerable_type', 'App\Models\Document\DocumentItemTax')
            ->where('updated_at', '>=', '2024-12-22 00:00:00')
            ->get();

        foreach ($ledgers as $ledger) {
            $document_item_tax = $ledger->ledgerable;

            if (! $document_item_tax) {
                continue;
            }

            $tax = $document_item_tax->tax;

            if (! $tax) {
                continue;
            }

            if ($tax->type !== 'inclusive') {
                continue;
            }

            $this->updateLedger($document_item_tax);
        }

        Log::channel('stderr')->info('Ledgers updated...');
    }

    public function updateLedger($document_item_tax)
    {
        $document_item_ledger = Ledger::where('ledgerable_type', 'App\Models\Document\DocumentItem')
            ->where('ledgerable_id', $document_item_tax->document_item_id)
            ->first();

        if (is_null($document_item_ledger)) {
            return;
        }

        Log::channel('stderr')->info('Updating ledger: ' . $document_item_ledger->id);

        $label = 'debit';

        if (! is_null($document_item_ledger->credit)) {
            $label = 'credit';
        }

        $document_item_ledger->update([
            $label => $document_item_ledger->$label - $document_item_tax->amount,
        ]);

        Log::channel('stderr')->info('Ledger updated: ' . $document_item_ledger->id);
    }
}
