<?php

namespace Modules\DoubleEntry\Observers\Document;

use App\Traits\Jobs;
use App\Traits\Modules;
use App\Traits\Documents;
use App\Abstracts\Observer;
use Modules\DoubleEntry\Models\Ledger;
use Modules\DoubleEntry\Traits\Recurring;
use Modules\Expenses\Models\ExpenseClaim;
use App\Models\Document\Document as Model;
use Modules\DoubleEntry\Traits\Permissions;
use Modules\CreditDebitNotes\Models\DebitNote;
use Modules\DoubleEntry\Models\Account as Coa;
use Modules\CreditDebitNotes\Models\CreditNote;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Jobs\Ledger\CreateLedger;
use Modules\DoubleEntry\Jobs\Ledger\DeleteLedger;
use Modules\DoubleEntry\Jobs\Ledger\UpdateLedger;

class Document extends Observer
{
    use Documents, Jobs, Permissions, Modules, Recurring;

    /**
     * Listen to the created event.
     *
     * @param  Model  $document
     * @return void
     */
    public function created(Model $document)
    { 
        if ($this->skipEvent($document)) {
            return;
        }

        $request = $this->getDocumentBaseRequest($document);

        $request = $this->appendDocumentSpecificFields($request, $document);

        $this->dispatch(new CreateLedger($request));
    }

    /**
     * Listen to the updated event.
     *
     * @param  Model  $document
     * @return void
     */
    public function updated(Model $document)
    {
        if ($this->skipEvent($document)) {
            return;
        }

        $ledger = Ledger::record($document->id, get_class($document))->first();

        if (is_null($ledger)) {
            if (! is_null($document->parent_id)) {
                $this->createRecurringDocumentLedgers($document);
            }

            return;
        }

        $request = $this->getDocumentBaseRequest($document);

        $request = $this->appendDocumentSpecificFields($request, $document);

        $this->dispatch(new UpdateLedger($ledger, $request));
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model  $document
     * @return void
     */
    public function deleted(Model $document)
    {
        if ($this->skipEvent($document)) {
            return;
        }

        $ledger = Ledger::record($document->id, get_class($document))->first();

        if (is_null($ledger)) {
            return;
        }

        $this->dispatch(new DeleteLedger($ledger));
    }

    /**
     * Gets the basic parameters for the document request.
     *
     * @param Model $document
     * @return array
     */
    private function getDocumentBaseRequest($document)
    {
        return [
            'company_id' => $document->company_id,
            'ledgerable_id' => $document->id,
            'ledgerable_type' => get_class($document),
            'issued_at' => $document->issued_at,
            'entry_type' => 'total',
        ];
    }

    /**
     * Appends the document specific parameters.
     *
     * @param array $request
     * @param Model $document
     * @return array
     */
    private function appendDocumentSpecificFields($request, $document)
    {
        if ($document->type == Model::INVOICE_TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_receivable', 120))->pluck('id')->first();
            $request['debit'] = $document->amount;
        }

        if ($document->type == Model::BILL_TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_payable', 200))->pluck('id')->first();
            $request['credit'] = $document->amount;
        }

        if ($this->moduleIsEnabled('credit-debit-notes') && $document->type == CreditNote::TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_receivable', 120))->pluck('id')->first();
            $request['credit'] = $document->amount;
        }

        if ($this->moduleIsEnabled('credit-debit-notes') && $document->type == DebitNote::TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_payable', 200))->pluck('id')->first();
            $request['debit'] = $document->amount;
        }

        if ($this->moduleIsEnabled('expenses') && $document->type == ExpenseClaim::TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_payable', 200))->pluck('id')->first();
            $request['credit'] = $document->amount;
        }

        return $request;
    }

    /**
     * Creates the recurring document ledgers.
     *
     * @param Model $document
     */
    private function createRecurringDocumentLedgers($document)
    {
        $document->refresh();

        $request = $this->getDocumentBaseRequest($document);

        $request = $this->appendDocumentSpecificFields($request, $document);

        $this->dispatch(new CreateLedger($request));

        $this->createRecurringDocumentItemLedgers($document);

        $this->createRecurringDocumentTotalLedgers($document);
    }

    /**
     * Creates the recurring document item ledgers.
     *
     * @param Model $document
     */
    private function createRecurringDocumentItemLedgers($document)
    {
        $parent_document = $document->parent;
        $document_items = $document->items;

        foreach ($document_items as $item_key => $document_item) {
            $parent_document_item = $parent_document->items[$item_key];

            $recurring_ledger = RecurringLedger::record($parent_document_item->id, get_class($parent_document_item))->first();
            
            $request = [
                'company_id'        => $document_item->company_id,
                'ledgerable_id'     => $document_item->id,
                'ledgerable_type'   => get_class($document_item),
                'issued_at'         => $document->issued_at,
                'entry_type'        => 'item',
                'account_id'        => $recurring_ledger->account_id,
                'credit'            => $recurring_ledger->credit,
                'debit'             => $recurring_ledger->debit,
            ];
        
            $this->dispatch(new CreateLedger($request));

            $this->createRecurringDocumentItemTaxLedgers($document, $document_item, $parent_document_item);
        }
    }

    /**
     * Creates the recurring document item tax ledgers.
     *
     * @param Model $document
     */
    private function createRecurringDocumentItemTaxLedgers($document, $document_item, $parent_document_item)
    {
        $document_item_taxes = $document_item->taxes;

        foreach ($document_item_taxes as $item_tax_key => $document_item_tax) {
            $parent_document_item_tax = $parent_document_item->taxes[$item_tax_key];

            $recurring_ledger = RecurringLedger::record($parent_document_item_tax->id, get_class($parent_document_item_tax))->first();
            
            $request = [
                'company_id'        => $document_item_tax->company_id,
                'ledgerable_id'     => $document_item_tax->id,
                'ledgerable_type'   => get_class($document_item_tax),
                'issued_at'         => $document->issued_at,
                'entry_type'        => 'item',
                'account_id'        => $recurring_ledger->account_id,
                'credit'            => $recurring_ledger->credit,
                'debit'             => $recurring_ledger->debit,
            ];

            $this->dispatch(new CreateLedger($request));

            if ($document_item_tax->tax->type == 'inclusive') {
                $document_item_ledger = Ledger::where('ledgerable_type', 'App\Models\Document\DocumentItem')
                    ->where('ledgerable_id', $document_item_tax->document_item_id)
                    ->first();
        
                if (is_null($document_item_ledger)) {
                    continue;
                }
        
                $label = 'debit';
        
                if (! is_null($document_item_ledger->credit)) {
                    $label = 'credit';
                }
        
                $this->dispatch(new UpdateLedger($document_item_ledger, [
                    $label => $document_item_ledger->$label - $document_item_tax->amount,
                ]));
            }
        }
    }

    /**
     * Creates the recurring document total ledgers.
     *
     * @param Model $document
     */
    private function createRecurringDocumentTotalLedgers($document)
    {
        $document_totals = $document->totals;

        foreach ($document_totals as $total_key => $document_total) {
            if ($document_total->code != 'discount') {
                continue;
            }

            $parent_document = $document->parent;

            $parent_document_total = $parent_document->totals[$total_key];

            $recurring_ledger = RecurringLedger::record($parent_document_total->id, get_class($parent_document_total))->first();

            $request = [
                'company_id'        => $document_total->company_id,
                'ledgerable_id'     => $document_total->id,
                'ledgerable_type'   => get_class($document_total),
                'issued_at'         => $document->issued_at,
                'entry_type'        => 'discount',
                'account_id'        => $recurring_ledger->account_id,
                'credit'            => $recurring_ledger->credit,
                'debit'             => $recurring_ledger->debit,
            ];

            $this->dispatch(new CreateLedger($request));
        }
    }

    /**
     * Determines event will be continued or not.
     *
     * @param Model $document
     * @return bool
     */
    private function skipEvent(Model $document)
    {
        $type = isset($document->type) ? $document->type : null;

        if ($this->moduleIsDisabled('double-entry') ||
            $this->isNotValidDocumentType($type)) {
            return true;
        }

        return false;
    }
}
