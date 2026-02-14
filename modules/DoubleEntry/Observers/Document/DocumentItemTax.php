<?php

namespace Modules\DoubleEntry\Observers\Document;

use App\Abstracts\Observer;
use App\Models\Document\Document;
use App\Models\Document\DocumentItemTax as Model;
use App\Traits\Jobs;
use Modules\CreditDebitNotes\Models\CreditNote;
use Modules\CreditDebitNotes\Models\DebitNote;
use Modules\DoubleEntry\Jobs\Ledger\CreateLedger;
use Modules\DoubleEntry\Jobs\Ledger\DeleteLedger;
use Modules\DoubleEntry\Jobs\Ledger\UpdateLedger;
use Modules\DoubleEntry\Models\AccountTax;
use Modules\DoubleEntry\Models\Ledger;
use Modules\DoubleEntry\Traits\Permissions;
use Modules\Expenses\Models\ExpenseClaim;

class DocumentItemTax extends Observer
{
    use Jobs, Permissions;

    /**
     * Listen to the created event.
     *
     * @param  Model  $document_item_tax
     * @return void
     */
    public function created(Model $document_item_tax)
    {
        if ($this->skipEvent($document_item_tax)) {
            return;
        }

        $account_id = AccountTax::where('tax_id', $document_item_tax->tax_id)->pluck('account_id')->first();

        if (is_null($account_id)) {
            return;
        }

        $request = $this->getDocumentItemTaxBaseRequest($document_item_tax);

        $request['account_id'] = $account_id;

        $this->dispatch(new CreateLedger($request));

        if ($document_item_tax->tax->type == 'inclusive') {
            $this->updateDocumentItemLedger($document_item_tax);
        }
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model  $document_item_tax
     * @return void
     */
    public function deleted(Model $document_item_tax)
    {
        if ($this->skipEvent($document_item_tax)) {
            return;
        }

        $ledger = Ledger::record($document_item_tax->id, get_class($document_item_tax))->first();

        if (is_null($ledger)) {
            return;
        }

        $this->dispatch(new DeleteLedger($ledger));
    }

    /**
     * Gets the basic parameters for the document item tax request.
     *
     * @param Model $document_item_tax
     * @return array
     */
    private function getDocumentItemTaxBaseRequest($document_item_tax)
    {
        if ($document_item_tax->document->type == Document::INVOICE_TYPE) {
            $label = 'credit';

            if ($document_item_tax->tax->type == 'withholding') {
                $label = 'debit';
            }
        }

        if ($document_item_tax->document->type == Document::BILL_TYPE) {
            $label = 'debit';

            if ($document_item_tax->tax->type == 'withholding') {
                $label = 'credit';
            }
        }

        if ($this->moduleIsEnabled('credit-debit-notes') && $document_item_tax->document->type == CreditNote::TYPE) {
            $label = 'debit';

            if ($document_item_tax->tax->type == 'withholding') {
                $label = 'credit';
            }
        }

        if ($this->moduleIsEnabled('credit-debit-notes') && $document_item_tax->document->type == DebitNote::TYPE) {
            $label = 'credit';

            if ($document_item_tax->tax->type == 'withholding') {
                $label = 'debit';
            }
        }

        if ($this->moduleIsEnabled('expenses') && $document_item_tax->document->type == ExpenseClaim::TYPE) {
            $label = 'debit';

            if ($document_item_tax->tax->type == 'withholding') {
                $label = 'credit';
            }
        }

        return [
            'company_id' => $document_item_tax->company_id,
            'ledgerable_id' => $document_item_tax->id,
            'ledgerable_type' => get_class($document_item_tax),
            'issued_at' => $document_item_tax->document->issued_at,
            'entry_type' => 'item',
            $label => $document_item_tax->amount,
        ];
    }

    /**
     * Updates the document item ledger in case of inclusive tax.
     *
     * @param Model $document_item_tax
     * @return array
     */
    private function updateDocumentItemLedger($document_item_tax)
    {
        $document_item_ledger = Ledger::where('ledgerable_type', 'App\Models\Document\DocumentItem')
            ->where('ledgerable_id', $document_item_tax->document_item_id)
            ->first();

        if (is_null($document_item_ledger)) {
            return;
        }

        $label = 'debit';

        if (! is_null($document_item_ledger->credit)) {
            $label = 'credit';
        }

        $this->dispatch(new UpdateLedger($document_item_ledger, [
            $label => $document_item_ledger->$label - $document_item_tax->amount,
        ]));
    }

    /**
     * Determines event will be continued or not.
     *
     * @param Model $document_item_tax
     * @return bool
     */
    private function skipEvent(Model $document_item_tax)
    {
        $type = isset($document_item_tax->type) ? $document_item_tax->type : null;

        if ($this->moduleIsDisabled('double-entry') ||
            $this->isNotValidDocumentType($type)) {
            return true;
        }

        return false;
    }
}
