<?php

namespace Modules\DoubleEntry\Observers\Document;

use App\Abstracts\Observer;
use App\Models\Document\Document;
use App\Models\Document\DocumentItem as Model;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\CreditDebitNotes\Models\CreditNote;
use Modules\CreditDebitNotes\Models\DebitNote;
use Modules\DoubleEntry\Jobs\Ledger\CreateLedger;
use Modules\DoubleEntry\Jobs\Ledger\DeleteLedger;
use Modules\DoubleEntry\Models\Account as Coa;
use Modules\DoubleEntry\Models\Ledger;
use Modules\DoubleEntry\Traits\Accounts;
use Modules\DoubleEntry\Traits\Permissions;
use Modules\Expenses\Models\ExpenseClaim;

class DocumentItem extends Observer
{
    use Accounts, Jobs, Permissions, Modules;

    /**
     * Listen to the created event.
     *
     * @param  Model  $document_item
     * @return void
     */
    public function created(Model $document_item)
    {
        if ($this->skipEvent($document_item)) {
            return;
        }

        $request = $this->getDocumentItemBaseRequest($document_item);

        $request = $this->appendDocumentItemSpecificFields($request, $document_item);

        $this->dispatch(new CreateLedger($request));
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model  $document_item
     * @return void
     */
    public function deleted(Model $document_item)
    {
        if ($this->skipEvent($document_item)) {
            return;
        }

        $ledger = Ledger::record($document_item->id, get_class($document_item))->first();

        if (is_null($ledger)) {
            return;
        }

        $this->dispatch(new DeleteLedger($ledger));
    }

    /**
     * Gets the basic parameters for the document item request.
     *
     * @param Model $document_item
     * @return array
     */
    private function getDocumentItemBaseRequest($document_item)
    {
        return [
            'company_id' => $document_item->company_id,
            'ledgerable_id' => $document_item->id,
            'ledgerable_type' => get_class($document_item),
            'issued_at' => $document_item->document?->issued_at,
            'entry_type' => 'item',
        ];
    }

    /**
     * Appends the document item specific parameters.
     *
     * @param array $request
     * @param Model $document_item
     * @return array
     */
    private function appendDocumentItemSpecificFields($request, $document_item)
    {
        $account_id = null;

        // First, check if de_account_id was submitted in the request
        if (isset($document_item->allAttributes['de_account_id'])) {
            $account_id = $document_item->allAttributes['de_account_id'];
        }

        // If not, try to find the imported account
        if (empty($account_id) && isset($document_item->allAttributes['chart_of_account'])) {
            $document_item->allAttributes['de_account_id'] = $this->findImportedAccountId($document_item->allAttributes['chart_of_account']);
            if (isset($document_item->allAttributes['de_account_id'])) {
                $account_id = $document_item->allAttributes['de_account_id'];
            }
        }

        // If still empty, try to get the item's default account from AccountItem
        if (empty($account_id) && !empty($document_item->item_id)) {
            $account_item = \Modules\DoubleEntry\Models\AccountItem::where('item_id', $document_item->item_id)
                ->where('company_id', $document_item->company_id)
                ->first();

            if ($account_item) {
                $account_id = $account_item->account_id;
            }
        }

        $request['account_id'] = $account_id;

        $total = $this->calculateDocumentItemTotal($document_item);

        if ($document_item->document->type == Document::INVOICE_TYPE) {
            $request['credit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();
            }
        }

        if ($document_item->document->type == Document::BILL_TYPE) {
            $request['debit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();
            }
        }

        if ($this->moduleIsEnabled('credit-debit-notes') && $document_item->document->type == CreditNote::TYPE) {
            $request['debit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();
            }
        }

        if ($this->moduleIsEnabled('credit-debit-notes') && $document_item->document->type == DebitNote::TYPE) {
            $request['credit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();
            }
        }

        if ($this->moduleIsEnabled('expenses') && $document_item->document->type == ExpenseClaim::TYPE) {
            $request['debit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();
            }
        }

        return $request;
    }

    /**
     * Calculates the total of the document item.
     *
     * @param Model $document_item
     */
    private function calculateDocumentItemTotal($document_item)
    {
        // When the total is calculated this way, inclusive taxes cannot be calculated correctly. 
        // Therefore, an additional calculation is performed in the document item tax observer.
        $total = (double) $document_item->price * (double) $document_item->quantity;

        // Apply line discount to amount
        if (! empty($document_item->discount_rate)) {
            if ($document_item->discount_type === 'percentage') {
                $total -= ($total * ($document_item->discount_rate / 100));
            } else {
                $total -= $document_item->discount_rate;
            }
        }

        return $total;
    }

    /**
     * Determines event will be continued or not.
     *
     * @param Model $document_item
     * @return bool
     */
    private function skipEvent(Model $document_item)
    {
        $type = isset($document_item->type) ? $document_item->type : null;

        if ($this->moduleIsDisabled('double-entry') ||
            $this->isNotValidDocumentType($type)) {
            return true;
        }

        return false;
    }
}
