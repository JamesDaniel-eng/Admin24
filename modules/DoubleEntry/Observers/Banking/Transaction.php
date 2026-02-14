<?php

namespace Modules\DoubleEntry\Observers\Banking;

use App\Traits\Jobs;
use App\Traits\Modules;
use App\Abstracts\Observer;
use Illuminate\Support\Str;
use Modules\DoubleEntry\Models\Ledger;
use Modules\DoubleEntry\Traits\Accounts;
use Modules\DoubleEntry\Models\AccountBank;
use Modules\DoubleEntry\Traits\Permissions;
use App\Models\Banking\Transaction as Model;
use Modules\DoubleEntry\Models\Account as Coa;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Jobs\Ledger\CreateLedger;
use Modules\DoubleEntry\Jobs\Ledger\DeleteLedger;

class Transaction extends Observer
{
    use Accounts, Jobs, Permissions, Modules;

    /**
     * Listen to the created event.
     *
     * @param Model $transaction
     * @return void
     */
    public function created(Model $transaction)
    {
        if ($this->skipEvent($transaction)) {
            return;
        }

        $account_id = AccountBank::where('bank_id', $transaction->account_id)
            ->pluck('account_id')
            ->first();

        if (empty($account_id)) {
            return;
        }

        $type = $this->getTransactionType($transaction);

        Ledger::create([
            'company_id' => $transaction->company_id,
            'account_id' => $account_id,
            'ledgerable_id' => $transaction->id,
            'ledgerable_type' => get_class($transaction),
            'issued_at' => $transaction->paid_at,
            'entry_type' => 'total',
            $type['total_field'] => $transaction->amount,
        ]);

        Ledger::create([
            'company_id' => $transaction->company_id,
            'account_id' => $type['account_id'],
            'ledgerable_id' => $transaction->id,
            'ledgerable_type' => get_class($transaction),
            'issued_at' => $transaction->paid_at,
            'entry_type' => 'item',
            $type['item_field'] => $transaction->amount,
        ]);

        if (! empty($transaction->split_id)) {
            Ledger::where('ledgerable_id', $transaction->split_id)
                ->where('ledgerable_type', get_class($transaction))
                ->delete();
        }
    }

    /**
     * Listen to the updated event.
     *
     * @param Model $transaction
     * @return void
     */
    public function updated(Model $transaction)
    {
        if ($this->skipEvent($transaction)) {
            return;
        }

        $ledger = Ledger::record($transaction->id, get_class($transaction))->first();

        if (is_null($ledger)) {
            if (! is_null($transaction->parent_id)) {
                $this->createRecurringTransactionLedgers($transaction);
            }

            return;
        }

        $account_id = AccountBank::where('bank_id', $transaction->account_id)
            ->pluck('account_id')
            ->first();

        if (empty($account_id)) {
            return;
        }

        $type = $this->getTransactionType($transaction);

        $total_ledger_data = [
            'company_id' => $transaction->company_id,
            'account_id' => $account_id,
            'ledgerable_id' => $transaction->id,
            'ledgerable_type' => get_class($transaction),
            'issued_at' => $transaction->paid_at,
            'entry_type' => 'total',
            $type['total_field'] => $transaction->amount,
        ];

        $total_ledger = Ledger::record($transaction->id, get_class($transaction))
            ->where('entry_type', 'total')
            ->first();

        if (empty($total_ledger)) {
            Ledger::create($total_ledger_data);
        } else {
            $total_ledger->update($total_ledger_data);
        }

        $item_ledger_data = [
            'company_id' => $transaction->company_id,
            'ledgerable_id' => $transaction->id,
            'ledgerable_type' => get_class($transaction),
            'issued_at' => $transaction->paid_at,
            'entry_type' => 'item',
            'account_id' => $type['account_id'],
            $type['item_field'] => $transaction->amount,
        ];

        $item_ledger = Ledger::record($transaction->id, get_class($transaction))
            ->where('entry_type', 'item')
            ->first();

        if (empty($item_ledger)) {
            Ledger::create($item_ledger_data);
        } else {
            $item_ledger->update($item_ledger_data);
        }

        if (! empty($transaction->split_id)) {
            Ledger::where('ledgerable_id', $transaction->split_id)
                ->where('ledgerable_type', get_class($transaction))
                ->delete();
        }
    }

    /**
     * Listen to the deleted event.
     *
     * @param Model $transaction
     * @return void
     */
    public function deleted(Model $transaction)
    {
        if ($this->skipEvent($transaction)) {
            return;
        }

        foreach ($transaction->ledgers as $ledger) {
            $this->dispatch(new DeleteLedger($ledger));
        }
    }

    /**
     * Gets the type of the transaction.
     *
     * @param Model $transaction
     * @return array
     */
    protected function getTransactionType(Model $transaction)
    {
        $transaction_type = [];

        if ($transaction->type == 'income' || $transaction->type == 'credit_note_refund') {
            $transaction_type['total_field'] = 'debit';
            $transaction_type['item_field'] = 'credit';
        }

        if ($transaction->type == 'expense' || $transaction->type == 'debit_note_refund') {
            $transaction_type['total_field'] = 'credit';
            $transaction_type['item_field'] = 'debit';
        }

        $transaction_type['account_id'] = $this->getAccountId($transaction);

        return $transaction_type;
    }

    /**
     * Gets the id of the given account.
     *
     * @param Model $transaction
     * @return int|null
     */
    protected function getAccountId(Model $transaction)
    {
        if (isset($transaction->allAttributes['chart_of_account'])) {
            return $this->findImportedAccountId($transaction->allAttributes['chart_of_account']);
        }
        
        if (isset($transaction->allAttributes['de_account_id'])) {
            return $transaction->allAttributes['de_account_id'];
        }
        
        if ($transaction->type == 'expense' && $transaction->created_from == source_name('payroll')) {
            $account_id = Coa::code(setting('double-entry.accounts_payroll', 664))->value('id');
            
            return isset($account_id) ? $account_id : null;
        }
        
        if ($transaction->type == 'income' && is_null($transaction->document_id)) {
            $account_id = Coa::code(setting('double-entry.accounts_sales', 400))->value('id');
            
            return isset($account_id) ? $account_id : null;
        }
        
        if (($transaction->type == 'income' || $transaction->type == 'credit_note_refund') && !is_null($transaction->document_id)) {
            $account_id = Coa::code(setting('double-entry.accounts_receivable', 120))->value('id');
            
            return isset($account_id) ? $account_id : null;
        }
        
        if ($transaction->type == 'expense' && is_null($transaction->document_id)) {
            $account_id = Coa::code(setting('double-entry.accounts_expenses', 628))->value('id');
            
            return isset($account_id) ? $account_id : null;
        }
        
        if (($transaction->type == 'expense' || $transaction->type == 'debit_note_refund') && !is_null($transaction->document_id)) {
            $account_id = Coa::code(setting('double-entry.accounts_payable', 200))->value('id');
            
            return isset($account_id) ? $account_id : null;
        }
        
        return null;
    }
    
    /**
     * Gets the id of the given account.
     *
     * @param Model $transaction
     */
    protected function createRecurringTransactionLedgers(Model $transaction)
    {
        $transaction->refresh();

        $parent_transaction = $transaction->parent;

        $recurring_total_ledger = RecurringLedger::record($parent_transaction->id, get_class($parent_transaction))
            ->where('entry_type', 'total')
            ->first();

        if ($recurring_total_ledger) {
            $this->dispatch(new CreateLedger([
                'company_id' => $transaction->company_id,
                'account_id' => $recurring_total_ledger->account_id,
                'ledgerable_id' => $transaction->id,
                'ledgerable_type' => get_class($transaction),
                'issued_at' => $transaction->paid_at,
                'entry_type' => 'total',
                $recurring_total_ledger->debit ? 'debit' : 'credit' => $transaction->amount,
            ]));
        }

        $recurring_item_ledger = RecurringLedger::record($parent_transaction->id, get_class($parent_transaction))
            ->where('entry_type', 'item')
            ->first();

        if ($recurring_item_ledger) {
            $this->dispatch(new CreateLedger([
                'company_id' => $transaction->company_id,
                'account_id' => $recurring_item_ledger->account_id,
                'ledgerable_id' => $transaction->id,
                'ledgerable_type' => get_class($transaction),
                'issued_at' => $transaction->paid_at,
                'entry_type' => 'total',
                $recurring_item_ledger->debit ? 'debit' : 'credit' => $transaction->amount,
            ]));
        }

        foreach ($transaction->taxes as $key => $transaction_tax) {
            $parent_transaction_tax = $parent_transaction->taxes[$key];

            $recurring_tax_ledger = RecurringLedger::record($parent_transaction_tax->id, get_class($parent_transaction_tax))
                ->where('entry_type', 'item')
                ->first();

            if ($recurring_tax_ledger) {
                $this->dispatch(new CreateLedger([
                    'company_id' => $transaction_tax->company_id,
                    'account_id' => $recurring_tax_ledger->account_id,
                    'ledgerable_id' => $transaction_tax->id,
                    'ledgerable_type' => get_class($transaction_tax),
                    'issued_at' => $transaction_tax->created_at,
                    'entry_type' => 'total',
                    $recurring_tax_ledger->debit ? 'debit' : 'credit' => $transaction_tax->amount,
                ]));
            }
        }
    }

    /**
     * Determine the transaction belongs to a journal or not.
     *
     * @param Model $transaction
     * @return bool
     */
    protected function isJournal($transaction)
    {
        if (empty($transaction->reference)) {
            return false;
        }

        if (!Str::contains($transaction->reference, 'journal-entry-ledger:')) {
            return false;
        }

        return true;
    }

    /**
     * Determine the transaction belongs to a reconciliation.
     * 
     * @param Model $transaction
     * @return bool
     */
    public function isReconciliation(Model $transaction)
    {
        return $transaction->isDirty('reconciled');
    }

    /**
     * Determines event will be continued or not.
     *
     * @param Model $transaction
     * @return bool
     */
    private function skipEvent(Model $transaction)
    {
        $type = isset($transaction->type) ? $transaction->type : null;

        if (
            $this->moduleIsDisabled('double-entry')
            || $this->isJournal($transaction)
            || $this->isNotValidTransactionType($type)
            || $this->isReconciliation($transaction)
        ) {
            return true;
        }

        return false;
    }
}
