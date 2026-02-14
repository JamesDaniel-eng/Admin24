<?php

namespace Modules\DoubleEntry\Listeners\RecurringTransaction;

use App\Traits\Jobs;
use App\Traits\Modules;
use App\Models\Banking\Transaction;
use App\Events\Banking\TransactionDeleted as Event;

class DeleteTransaction
{
    use Jobs, Modules;

    /**
     * Handle the event.
     *
     * @param TransactionDeleted $event
     * @return void
     */
    public function handle(Event $event)
    {
        $transaction = $event->transaction;

        if ($this->skipEvent($transaction)) {
            return;
        }

        $transaction->recur_ledgers()->delete();

        foreach ($transaction->taxes as $tax) {
            $tax->recur_ledgers()->delete();
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
