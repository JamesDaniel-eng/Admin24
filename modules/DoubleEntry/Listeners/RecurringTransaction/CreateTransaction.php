<?php

namespace Modules\DoubleEntry\Listeners\RecurringTransaction;

use App\Events\Banking\TransactionCreated as Event;
use App\Models\Banking\Transaction;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\DoubleEntry\Models\AccountBank;
use Modules\DoubleEntry\Models\AccountTax;
use Modules\DoubleEntry\Jobs\RecurringLedger\CreateRecurringLedger;
use Modules\DoubleEntry\Jobs\RecurringLedger\UpdateRecurringLedger;
use Modules\DoubleEntry\Traits\Accounts;
use Modules\DoubleEntry\Traits\Recurring;
use Modules\DoubleEntry\Traits\Permissions;

class CreateTransaction
{
    use Accounts, Jobs, Permissions, Modules, Recurring;

    /**
     * Handle the event.
     *
     * @param TransactionCreated $event
     * @return void
     */
    public function handle(Event $event)
    {
        $transaction = $event->transaction;

        if ($this->skipEvent($transaction)) {
            return;
        }

        $account_id = AccountBank::where('bank_id', $transaction->account_id)
            ->pluck('account_id')
            ->first();

        if (empty($account_id)) {
            return;
        }

        $request = $this->getTransactionBaseRequest($transaction);

        $total_request = $this->getTransactionTotalBaseRequest($request, $transaction, $account_id);

        $this->dispatch(new CreateRecurringLedger($total_request));

        $item_request = $this->getTransactionItemBaseRequest($request, $transaction);

        $item_ledger = $this->dispatch(new CreateRecurringLedger($item_request));

        foreach ($transaction->taxes as $transaction_tax) {
            $account_id = AccountTax::where('tax_id', $transaction_tax->tax_id)->pluck('account_id')->first();

            if (is_null($account_id)) {
                continue;
            }

            $tax_request = $this->getTransactionTaxBaseRequest($transaction_tax, $account_id);

            $this->dispatch(new CreateRecurringLedger($tax_request));

            $update_item_ledger_request = $this->updateTransactionItemBaseRequest($transaction_tax, $item_ledger);

            $this->dispatch(new UpdateRecurringLedger($item_ledger, $update_item_ledger_request));
        }
    }

    /**
     * Determines event will be continued or not.
     *
     * @param Transaction $transaction
     * @return bool
     */
    public function skipEvent(Transaction $transaction)
    {
        if ($this->moduleIsDisabled('double-entry') || $this->isNotRecurring($transaction)) {
            return true;
        }

        return false;
    }

    /**
     * Determines event will be continued or not.
     * 
     * @param Model $transaction
     * @return bool
     */
    public function isNotRecurring(Transaction $transaction)
    {
        if (! in_array($transaction->type, [Transaction::INCOME_RECURRING_TYPE, Transaction::EXPENSE_RECURRING_TYPE])) {
            return true;
        }

        $recurring = $transaction->recurring;

        if (! empty($recurring) && $recurring->status == 'ended') {  
            return true;
        }

        return false;
    }
}
