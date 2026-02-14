<?php

namespace Modules\DoubleEntry\Traits;

use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Traits\Jobs;
use Modules\DoubleEntry\Models\Account as Coa;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Jobs\RecurringLedger\UpdateRecurringLedger;
use Modules\DoubleEntry\Traits\Accounts;

trait Recurring
{
    use Accounts, Jobs;
    
    /**
     * Gets the basic parameters for the document request.
     *
     * @return array
     */
    public function getDocumentBaseRequest($document)
    {
        return [
            'company_id'        => $document->company_id,
            'ledgerable_id'     => $document->id,
            'ledgerable_type'   => get_class($document),
            'issued_at'         => $document->issued_at,
            'entry_type'        => 'total',
        ];
    }

    /**
     * Gets the basic parameters for the document item request.
     *
     * @return array
     */
    public function getDocumentItemBaseRequest($document, $document_item, $item_key)
    {
        $request_item = request()->items[$item_key] ?? [];

        return [
            'company_id'        => $document_item->company_id,
            'ledgerable_id'     => $document_item->id,
            'ledgerable_type'   => get_class($document_item),
            'issued_at'         => $document->issued_at,
            'entry_type'        => 'item',
            'de_account_id'     => $request_item['de_account_id'] ?? null,
            'chart_of_account'  => $request_item['chart_of_account'] ?? null,
        ];
    }

    /**
     * Gets the basic parameters for the document total request.
     *
     * @return array
     */
    public function getDocumentTotalBaseRequest($document, $document_total)
    {
        return [
            'company_id'        => $document_total->company_id,
            'ledgerable_id'     => $document_total->id,
            'ledgerable_type'   => get_class($document_total),
            'issued_at'         => $document->issued_at,
            'entry_type'        => 'discount',
        ];
    }

    /**
     * Gets the type of the transaction.
     *
     * @param Transaction $transaction
     * @return array
     */
    public function getTransactionBaseRequest(Transaction $transaction)
    {
        $total_field = 'debit';
        $item_field = 'credit';
        $account_code = setting('double-entry.accounts_sales', 400);

        if ($transaction->type == 'expense-recurring') {
            $total_field = 'credit';
            $item_field = 'debit';
            $account_code = setting('double-entry.accounts_expenses', 628);
        }

        $account_id = null;
        
        if (isset($transaction->allAttributes['de_account_id'])) {
            $account_id = $transaction->allAttributes['de_account_id'];
        }

        if (! $account_id) {
            $account_id = Coa::code($account_code)->pluck('id')->first();
        }

        return [
            'total_field'   => $total_field,
            'item_field'    => $item_field,
            'account_id'    => $account_id ?? null,
        ];
    }

    /**
     * Gets the basic parameters for the transaction total request.
     *
     * @return array
     */
    public function getTransactionTotalBaseRequest($request, $transaction, $account_id)
    {
        return [
            'company_id'                => $transaction->company_id,
            'account_id'                => $account_id,
            'ledgerable_id'             => $transaction->id,
            'ledgerable_type'           => get_class($transaction),
            'issued_at'                 => $transaction->paid_at,
            'entry_type'                => 'total',
            $request['total_field']     => $transaction->amount,
        ];
    }

    /**
     * Gets the basic parameters for the transaction item request.
     *
     * @return array
     */
    public function getTransactionItemBaseRequest($request, $transaction)
    {
        return [
            'company_id'            => $transaction->company_id,
            'account_id'            => $request['account_id'],
            'ledgerable_id'         => $transaction->id,
            'ledgerable_type'       => get_class($transaction),
            'issued_at'             => $transaction->paid_at,
            'entry_type'            => 'item',
            $request['item_field']  => $transaction->amount,
        ];
    }

    /**
     * Gets the basic parameters for the transaction tax request.
     *
     * @return array
     */
    public function getTransactionTaxBaseRequest($transaction_tax, $account_id)
    {
        $label = 'credit';

        if ($transaction_tax->tax->type == 'withholding') {
            $label = 'debit';
        }

        if ($transaction_tax->type == Transaction::EXPENSE_RECURRING_TYPE) {
            $label = 'debit';

            if ($transaction_tax->tax->type == 'withholding') {
                $label = 'credit';
            }
        }

        return [
            'company_id'        => $transaction_tax->company_id,
            'account_id'        => $account_id,
            'ledgerable_id'     => $transaction_tax->id,
            'ledgerable_type'   => get_class($transaction_tax),
            'issued_at'         => $transaction_tax->created_at,
            'entry_type'        => 'item',
            $label              => $transaction_tax->amount,
        ];
    }

    /**
     * Gets the basic parameters for the transaction tax request.
     *
     * @return array
     */
    public function updateTransactionItemBaseRequest($transaction_tax, $item_ledger)
    {
        $label = 'credit';

        if ($transaction_tax->tax->type == 'withholding') {
            $label = 'debit';
        }

        if ($transaction_tax->type == Transaction::EXPENSE_RECURRING_TYPE) {
            $label = 'debit';

            if ($transaction_tax->tax->type == 'withholding') {
                $label = 'credit';
            }
        }

        return [
            $label => $item_ledger->$label - $transaction_tax->amount,
        ];
    }

    /**
     * Appends the document specific parameters.
     *
     * @param array $request
     * @param Document $document
     * @return array
     */
    public function appendDocumentSpecificFields($request, $document)
    {
        if ($document->type == Document::INVOICE_RECURRING_TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_receivable', 120))->pluck('id')->first();
            $request['debit'] = $document->amount;
        }

        if ($document->type == Document::BILL_RECURRING_TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_payable', 200))->pluck('id')->first();
            $request['credit'] = $document->amount;
        }

        return $request;
    }

    /**
     * Appends the document item specific parameters.
     *
     * @param array $request
     * @return array
     */
    public function appendDocumentItemSpecificFields($request, $document_item)
    {
        $account_id = null;

        if (isset($request['chart_of_account'])) {
            $request['de_account_id'] = $this->findImportedAccountId($request['chart_of_account']);
        }

        if (isset($request['de_account_id'])) {
            $account_id = $request['de_account_id'];
        }

        $request['account_id'] = $account_id;

        $total = $this->calculateDocumentItemTotal($document_item);

        if ($document_item->type == Document::INVOICE_RECURRING_TYPE) {
            $request['credit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();
            }
        }

        if ($document_item->type == Document::BILL_RECURRING_TYPE) {
            $request['debit'] = $total;

            if (empty($account_id)) {
                $request['account_id'] = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();
            }
        }

        return $request;
    }

    /**
     * Gets the basic parameters for the document item tax request.
     *
     * @return array
     */
    public function getDocumentItemTaxBaseRequest($document, $document_item_tax)
    {
        $label = 'credit';

        if ($document_item_tax->tax->type == 'withholding') {
            $label = 'debit';
        }

        if ($document_item_tax->type == Document::BILL_RECURRING_TYPE) {
            $label = 'debit';

            if ($document_item_tax->tax->type == 'withholding') {
                $label = 'credit';
            }
        }

        return [
            'company_id'        => $document_item_tax->company_id,
            'ledgerable_id'     => $document_item_tax->id,
            'ledgerable_type'   => get_class($document_item_tax),
            'issued_at'         => $document->issued_at,
            'entry_type'        => 'item',
            $label              => $document_item_tax->amount,
        ];
    }

    /**
     * Appends the document total specific parameters.
     *
     * @return array
     */
    public function appendDocumentTotalSpecificFields($request, $document_total)
    {
        if ($document_total->type == Document::INVOICE_RECURRING_TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_sales_discount', 825))->pluck('id')->first();
            $request['debit'] = $document_total->amount;
        }

        if ($document_total->type == Document::BILL_RECURRING_TYPE) {
            $request['account_id'] = Coa::code(setting('double-entry.accounts_purchase_discount', 475))->pluck('id')->first();
            $request['credit'] = $document_total->amount;
        }

        return $request;
    }

    /**
     * Updates the document item ledger in case of inclusive tax.
     *
     * @return array
     */
    public function updateDocumentItemLedger($document_item_tax)
    {
        $document_item_ledger = RecurringLedger::where('ledgerable_type', 'App\Models\Document\DocumentItem')
            ->where('ledgerable_id', $document_item_tax->document_item_id)
            ->first();

        if (is_null($document_item_ledger)) {
            return;
        }

        $label = 'debit';

        if (! is_null($document_item_ledger->credit)) {
            $label = 'credit';
        }

        $this->dispatch(new UpdateRecurringLedger($document_item_ledger, [
            $label => $document_item_ledger->$label - $document_item_tax->amount,
        ]));
    }

    /**
     * Calculates the total of the document item.
     *
     * @param Model $document_item
     */
    public function calculateDocumentItemTotal($document_item)
    {
        // When the total is calculated this way, inclusive taxes cannot be calculated correctly. 
        // Therefore, an additional calculation is performed in the document item tax observer.
        $total = (double) $document_item->price * (double) $document_item->quantity;

        // Apply line discount to amount
        if (! empty($document_item->discount)) {
            if ($document_item->discount_type === 'percentage') {
                $total -= ($total * ($document_item->discount / 100));
            } else {
                $total -= $document_item->discount;
            }
        }

        return $total;
    }
}
