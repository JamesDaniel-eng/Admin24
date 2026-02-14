<?php

namespace Modules\DoubleEntry\Listeners\Update\V40;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Common\Company;
use Modules\DoubleEntry\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Version4049 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.0.49';

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
            ->where('entry_type', 'discount')
            ->where('ledgerable_type', 'App\Models\Document\DocumentTotal')
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

        $ledgers = Ledger::where('entry_type', 'discount')
            ->where('ledgerable_type', 'App\Models\Document\DocumentTotal')
            ->get();

        foreach ($ledgers as $ledger) {
            $this->updateLedger($ledger);
        }

        Log::channel('stderr')->info('Ledgers updated...');
    }

    public function updateLedger($ledger)
    {
        Log::channel('stderr')->info('Updating ledger: ' . $ledger->id);

        $document_total = $ledger->ledgerable;

        if (! $document_total) {
            return;
        }

        $document = $document_total->document;

        if (! $document) {
            return;
        }

        $document_items = $document->items;

        if (! $document_items) {
            return;
        }

        foreach ($document_items as $document_item) {
            $this->updateLedgerDocumentItem($document_item);
        }

        Log::channel('stderr')->info('Ledger updated: ' . $ledger->id);
    }

    public function updateLedgerDocumentItem($document_item)
    {
        Log::channel('stderr')->info('Updating document item: ' . $document_item->id);

        $document_item_ledger = $document_item->de_ledger;

        if (! $document_item_ledger) {
            return;
        }

        $total = $document_item->price * $document_item->quantity;

        if ($document_item_ledger->credit > 0) {
            $document_item_ledger->update([
                'credit' => $total,
            ]);
        }

        if ($document_item_ledger->debit > 0) {
            $document_item_ledger->update([
                'debit' => $total,
            ]);
        }

        Log::channel('stderr')->info('Document item updated: ' . $document_item->id);
    }
}
