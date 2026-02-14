<?php

namespace Modules\DoubleEntry\Http\ViewComposers;

use App\Models\Banking\Transaction;
use App\Traits\Modules;
use Illuminate\View\View;
use Modules\DoubleEntry\View\Components\Journals as Component;

class Journals
{
    use Modules;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->moduleIsDisabled('double-entry')) {
            return;
        }

        $mapping = [
            'income' => 'transaction',
            'income-recurring' => 'transaction',
            'expense' => 'transaction',
            'journal' => 'transaction',
            'credit_note_refund' => 'transaction',
            'debit_note_refund' => 'transaction',
            'invoice' => 'document',
            'invoice-recurring' => 'document',
            'bill' => 'document',
            'bill-recurring' => 'document',
            'credit-note' => 'document',
            'debit-note' => 'document',
            'expense-claim' => 'document',
        ];

        $type = $view->getData()['type'];

        if (! array_key_exists($type, $mapping)) {
            return;
        }

        $referenceDocuments = $view->getData()[$mapping[$type]];

        if ($type == 'journal') {
            $journal = $referenceDocuments;

            $transaction = $journal->ledgers->where('transaction_id', '!=', null)->first();

            if ($transaction) {
                $view->getFactory()->startPush('row_create_end', view('double-entry::partials.journal_show_transaction', compact('journal')));
            }

            return;
        }

        if ($ledger = $referenceDocuments->journal_ledger) {
            $journal = $ledger->ledgerable;

            if ($journal->getMorphClass() == 'Modules\DoubleEntry\Models\Journal') {
                $view->getFactory()->startPush('row_create_end', view('double-entry::partials.transaction_show_journal', compact('journal')));
            }
            
            return;
        }

        if (! $referenceDocuments->de_ledger && ! $referenceDocuments->de_recur_ledger) {
            if ($referenceDocuments->type == 'income-split' || $referenceDocuments->type == 'expense-split') {
                $referenceDocuments = Transaction::where('split_id', $referenceDocuments->id)->get();
            } else {
                return;
            }
        }

        $journals = new Component($referenceDocuments); 

        $section = 'get_paid_end';

        if ($type == 'bill' || $type == 'recurring-bill' || $type == 'expense-claim') {
            $section = 'make_paid_end';
        }

        if ($mapping[$type] == 'transaction') {
            $section = 'row_create_end';
        }

        $view->getFactory()->startPush($section, $journals->render()->with($journals->data()));
    }
}
