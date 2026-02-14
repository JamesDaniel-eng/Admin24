<?php

namespace Modules\DoubleEntry\Jobs\Install;

use App\Abstracts\Job;
use App\Models\Banking\Account;
use App\Models\Document\Document;
use App\Models\Banking\Transaction;
use App\Models\Banking\Transfer;
use App\Models\Setting\Tax;
use App\Traits\Documents;
use Modules\DoubleEntry\Models\Account as Coa;
use Modules\DoubleEntry\Models\AccountBank;
use Modules\DoubleEntry\Models\AccountTax;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Models\Ledger;
use Modules\DoubleEntry\Jobs\Journal\CreateJournalEntry;
use Modules\DoubleEntry\Traits\Accounts;

class CopyData extends Job
{
    use Accounts, Documents;

    public function handle()
    {
        \DB::transaction(function () {
            $this->copyAccounts();
            $this->copyTransfers();
            $this->copyTaxes();
            $this->copyInvoices();
            $this->copyRecurringInvoices();
            $this->copyIncomeTransactions();
            $this->copyIncomeRecurringTransactions();
            $this->copyBills();
            $this->copyRecurringBills();
            $this->copyExpenseTransactions();
            $this->copyExpenseRecurringTransactions();
        });
    }

    /**
     * Copy existing banking accounts to the chart of accounts.
     *
     * @return void
     */
    protected function copyAccounts()
    {
        foreach (Account::lazy() as $account) {
            $account_bank = AccountBank::where('bank_id', $account->id)->first();

            if (is_null($account_bank)) {
                $this->createBankAccount($account);

                continue;
            }

            $account_bank->account->update([
                'name' => $account->name,
                'enabled' => $account->enabled,
            ]);
        }
    }

    /**
     * Copy existing transfers to the journals.
     *
     * @return void
     */
    protected function copyTransfers()
    {
        Transfer::cursor()->each(function ($transfer) {
            $payment = $transfer->expense_transaction;
            $revenue = $transfer->income_transaction;
    
            $payment_account_id = AccountBank::where('bank_id', $payment->account_id)->pluck('account_id')->first();
            $revenue_account_id = AccountBank::where('bank_id', $revenue->account_id)->pluck('account_id')->first();
    
            if (empty($payment_account_id) || empty($revenue_account_id)) {
                return;
            }
    
            // $journal_number = $this->getNextJournalNumber();
    
            // $journal = Journal::where('company_id', $transfer->company_id)
            //     ->where('reference', 'transfer:' . $transfer->id)
            //     ->where('journal_number', $journal_number)
            //     ->first();
    
            // if (! $journal) {
            //     $journal = Journal::create([
            //         'company_id' => $transfer->company_id,
            //         'reference' => 'transfer:' . $transfer->id,
            //         'journal_number' => $journal_number,
            //         'amount' => $payment->amount,
            //         'currency_code' => $payment->currency_code,
            //         'currency_rate' => $payment->currency_rate,
            //         'paid_at' => $payment->paid_at,
            //         'description' => $payment->description ?: trans_choice('general.transfers', 1),
            //     ]);
    
            //     event(new JournalCreated($journal));
            // }
    
            $l1 = Ledger::updateOrCreate([
                'company_id' => $transfer->company_id,
                'ledgerable_type' => get_class($payment),
                'ledgerable_id' => $payment->id,
                'account_id' => $payment_account_id,
                'entry_type' => 'item',
            ], [
                'issued_at' => $payment->paid_at,
                'credit' => $payment->amount,
                'reference' => 'transfer:' . $transfer->id,
            ]);
    
            $payment->reference = 'journal-entry-ledger:' . $l1->id;
            $payment->save();
    
            $l2 = Ledger::updateOrCreate([
                'company_id' => $transfer->company_id,
                'ledgerable_type' => get_class($revenue),
                'ledgerable_id' => $revenue->id,
                'account_id' => $revenue_account_id,
                'entry_type' => 'item',
            ], [
                'issued_at' => $revenue->paid_at,
                'debit' => $revenue->amount,
                'reference' => 'transfer:' . $transfer->id,
            ]);
    
            $revenue->reference = 'journal-entry-ledger:' . $l2->id;
            $revenue->save();
        });
    }

    /**
     * Copy existing taxes to the chart of accounts.
     *
     * @return void
     */
    protected function copyTaxes()
    {
        foreach (Tax::lazy() as $tax) {
            $account_tax = AccountTax::where('tax_id', $tax->id)->first();

            if (is_null($account_tax)) {
                $chart_of_account = Coa::create([
                    'company_id' => company_id(),
                    'type_id' => setting('double-entry.types_tax', 17),
                    'code' => $this->getNextAccountCode(),
                    'name' => $tax->name,
                    'enabled' => 1,
                ]);

                $chart_of_account->tax()->create([
                    'company_id' => company_id(),
                    'account_id' => $chart_of_account->id,
                    'tax_id' => $tax->id,
                ]);

                continue;
            }

            $account_tax->account->update([
                'name' => $tax->name,
                'enabled' => $tax->enabled,
            ]);
        }
    }

    /**
     * Copy existing invoices to the ledgers.
     *
     * @return void
     */
    protected function copyInvoices()
    {
        Document::invoice()->with(['items', 'item_taxes', 'transactions'])->cursor()->each(function ($invoice) {
            $accounts_receivable_id = Coa::code(setting('double-entry.accounts_receivable', 120))->pluck('id')->first();

            Ledger::updateOrCreate([
                'company_id' => company_id(),
                'ledgerable_type' => get_class($invoice),
                'ledgerable_id' => $invoice->id,
                'account_id' => $accounts_receivable_id,
                'entry_type' => 'total',
            ], [
                'issued_at' => $invoice->issued_at,
                'debit' => $invoice->amount,
            ]);

            $invoice->items()->each(function ($item) use ($invoice) {
                $account_id = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();

                $ledger = Ledger::where('ledgerable_type', get_class($item))->where('ledgerable_id', $item->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item),
                    'ledgerable_id' => $item->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $invoice->issued_at,
                    'credit' => $item->total,
                ]);
            });

            $invoice->item_taxes()->each(function ($item_tax) use ($invoice) {
                $account_id = AccountTax::where('tax_id', $item_tax->tax_id)->pluck('account_id')->first();

                $ledger = Ledger::where('ledgerable_type', get_class($item_tax))->where('ledgerable_id', $item_tax->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item_tax),
                    'ledgerable_id' => $item_tax->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $invoice->issued_at,
                    'credit' => $item_tax->amount,
                ]);
            });

            $invoice->totals()->where('code', 'discount')->each(function ($total) use ($invoice) {
                $account_id = Coa::code(setting('double-entry.accounts_sales_discount', 825))->pluck('id')->first();

                $ledger = Ledger::where('ledgerable_type', get_class($total))->where('ledgerable_id', $total->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($total),
                    'ledgerable_id' => $total->id,
                    'account_id' => $account_id,
                    'entry_type' => 'discount',
                ], [
                    'issued_at' => $invoice->issued_at,
                    'debit' => $total->amount,
                ]);
            });

            $invoice->transactions()->each(function ($transaction) use ($accounts_receivable_id) {
                $account_id = AccountBank::where('bank_id', $transaction->account_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    $account = $this->createBankAccount($transaction->account);

                    $account_id = $account->id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'total',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'debit' => $transaction->amount,
                ]);

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $accounts_receivable_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'credit' => $transaction->amount,
                ]);
            });
        });
    }

    /**
     * Copy existing recurring invoices to the ledgers.
     *
     * @return void
     */
    protected function copyRecurringInvoices()
    {
        Document::invoiceRecurring()->with(['items', 'item_taxes', 'transactions'])->cursor()->each(function ($invoice) {
            $accounts_receivable_id = Coa::code(setting('double-entry.accounts_receivable', 120))->pluck('id')->first();

            RecurringLedger::updateOrCreate([
                'company_id' => company_id(),
                'ledgerable_type' => get_class($invoice),
                'ledgerable_id' => $invoice->id,
                'account_id' => $accounts_receivable_id,
                'entry_type' => 'total',
            ], [
                'issued_at' => $invoice->issued_at,
                'debit' => $invoice->amount,
            ]);

            $invoice->items()->each(function ($item) use ($invoice) {
                $account_id = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();

                $ledger = RecurringLedger::where('ledgerable_type', get_class($item))->where('ledgerable_id', $item->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item),
                    'ledgerable_id' => $item->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $invoice->issued_at,
                    'credit' => $item->total,
                ]);
            });

            $invoice->item_taxes()->each(function ($item_tax) use ($invoice) {
                $account_id = AccountTax::where('tax_id', $item_tax->tax_id)->pluck('account_id')->first();

                $ledger = RecurringLedger::where('ledgerable_type', get_class($item_tax))->where('ledgerable_id', $item_tax->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item_tax),
                    'ledgerable_id' => $item_tax->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $invoice->issued_at,
                    'credit' => $item_tax->amount,
                ]);
            });

            $invoice->totals()->where('code', 'discount')->each(function ($total) use ($invoice) {
                $account_id = Coa::code(setting('double-entry.accounts_sales_discount', 825))->pluck('id')->first();

                $ledger = RecurringLedger::where('ledgerable_type', get_class($total))->where('ledgerable_id', $total->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($total),
                    'ledgerable_id' => $total->id,
                    'account_id' => $account_id,
                    'entry_type' => 'discount',
                ], [
                    'issued_at' => $invoice->issued_at,
                    'debit' => $total->amount,
                ]);
            });
        });
    }

    /**
     * Copy existing transactions that type's are income to the ledgers.
     *
     * @return void
     */
    protected function copyIncomeTransactions()
    {
        Transaction::where('reference', 'NOT LIKE', 'journal-entry-ledger%')
            ->orWhereNull('reference')
            ->type('income')
            ->isNotDocument()
            ->isNotTransfer()
            ->cursor()
            ->each(function ($transaction) {
                $account_id = AccountBank::where('bank_id', $transaction->account_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    $account = $this->createBankAccount($transaction->account);

                    $account_id = $account->id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'total',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'debit' => $transaction->amount,
                ]);

                $account_id = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'credit' => $transaction->amount,
                ]);

                $transaction_taxes = $transaction->taxes;

                foreach ($transaction_taxes as $transaction_tax) {
                    $account_id = AccountTax::where('tax_id', $transaction_tax->tax_id)->pluck('account_id')->first();

                    if (is_null($account_id)) {
                        continue;
                    }

                    Ledger::updateOrCreate([
                        'company_id' => company_id(),
                        'ledgerable_type' => get_class($transaction_tax),
                        'ledgerable_id' => $transaction_tax->id,
                        'account_id' => $account_id,
                        'entry_type' => 'item',
                    ], [
                        'issued_at' => $transaction_tax->created_at,
                        'credit' => $transaction_tax->amount,
                    ]);

                    $transaction_ledger = Ledger::where('ledgerable_id', $transaction_tax->transaction->id)
                        ->where('ledgerable_type', get_class($transaction_tax->transaction))
                        ->where('entry_type', 'item')
                        ->first();

                    if (is_null($transaction_ledger)) {
                        return;
                    }

                    $label = 'credit';

                    if ($transaction_tax->tax->type == 'withholding') {
                        $label = 'debit';
                    }

                    $transaction_ledger->update([
                        $label => $transaction_ledger->$label - $transaction_tax->amount,
                    ]);
                }
            }
        );
    }

    /**
     * Copy existing transactions that type's are income to the ledgers.
     *
     * @return void
     */
    protected function copyIncomeRecurringTransactions()
    {
        Transaction::where('reference', 'NOT LIKE', 'journal-entry-ledger%')
            ->orWhereNull('reference')
            ->type('income-recurring')
            ->cursor()
            ->each(function ($transaction) {
                $account_id = AccountBank::where('bank_id', $transaction->account_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    $account = $this->createBankAccount($transaction->account);

                    $account_id = $account->id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'total',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'debit' => $transaction->amount,
                ]);

                $account_id = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'credit' => $transaction->amount,
                ]);

                $transaction_taxes = $transaction->taxes;

                foreach ($transaction_taxes as $transaction_tax) {
                    $account_id = AccountTax::where('tax_id', $transaction_tax->tax_id)->pluck('account_id')->first();

                    if (is_null($account_id)) {
                        continue;
                    }

                    RecurringLedger::updateOrCreate([
                        'company_id' => company_id(),
                        'ledgerable_type' => get_class($transaction_tax),
                        'ledgerable_id' => $transaction_tax->id,
                        'account_id' => $account_id,
                        'entry_type' => 'item',
                    ], [
                        'issued_at' => $transaction_tax->created_at,
                        'credit' => $transaction_tax->amount,
                    ]);

                    $transaction_ledger = RecurringLedger::where('ledgerable_id', $transaction_tax->transaction->id)
                        ->where('ledgerable_type', get_class($transaction_tax->transaction))
                        ->where('entry_type', 'item')
                        ->first();

                    if (is_null($transaction_ledger)) {
                        return;
                    }

                    $label = 'credit';

                    if ($transaction_tax->tax->type == 'withholding') {
                        $label = 'debit';
                    }

                    $transaction_ledger->update([
                        $label => $transaction_ledger->$label - $transaction_tax->amount,
                    ]);
                }
            }
        );
    }

    /**
     * Copy existing bills to the ledgers.
     *
     * @return void
     */
    protected function copyBills()
    {
        Document::bill()->with(['items', 'item_taxes', 'transactions'])->cursor()->each(function ($bill) {
            $accounts_payable_id = Coa::code(setting('double-entry.accounts_payable', 200))->pluck('id')->first();

            Ledger::updateOrCreate([
                'company_id' => company_id(),
                'ledgerable_type' => get_class($bill),
                'ledgerable_id' => $bill->id,
                'account_id' => $accounts_payable_id,
                'entry_type' => 'total',
            ], [
                'issued_at' => $bill->issued_at,
                'credit' => $bill->amount,
            ]);

            $bill->items()->each(function ($item) use ($bill) {
                $account_id = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();

                $ledger = Ledger::where('ledgerable_type', get_class($item))->where('ledgerable_id', $item->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item),
                    'ledgerable_id' => $item->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $bill->issued_at,
                    'debit' => $item->total,
                ]);
            });

            $bill->item_taxes()->each(function ($item_tax) use ($bill) {
                $account_id = AccountTax::where('tax_id', $item_tax->tax_id)->pluck('account_id')->first();

                $ledger = Ledger::where('ledgerable_type', get_class($item_tax))->where('ledgerable_id', $item_tax->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item_tax),
                    'ledgerable_id' => $item_tax->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $bill->issued_at,
                    'debit' => $item_tax->amount,
                ]);
            });

            $bill->totals()->where('code', 'discount')->each(function ($total) use ($bill) {
                $account_id = Coa::code(setting('double-entry.accounts_purchase_discount', 475))->pluck('id')->first();

                $ledger = Ledger::where('ledgerable_type', get_class($total))->where('ledgerable_id', $total->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($total),
                    'ledgerable_id' => $total->id,
                    'account_id' => $account_id,
                    'entry_type' => 'discount',
                ], [
                    'issued_at' => $bill->issued_at,
                    'credit' => $total->amount,
                ]);
            });

            $bill->transactions()->each(function ($transaction) use ($accounts_payable_id) {
                $account_id = AccountBank::where('bank_id', $transaction->account_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    $account = $this->createBankAccount($transaction->account);

                    $account_id = $account->id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'total',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'credit' => $transaction->amount,
                ]);

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $accounts_payable_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'debit' => $transaction->amount,
                ]);
            });
        });
    }

    /**
     * Copy existing recurring bills to the ledgers.
     *
     * @return void
     */
    protected function copyRecurringBills()
    {
        Document::billRecurring()->with(['items', 'item_taxes', 'transactions'])->cursor()->each(function ($bill) {
            $accounts_payable_id = Coa::code(setting('double-entry.accounts_payable', 200))->pluck('id')->first();

            RecurringLedger::updateOrCreate([
                'company_id' => company_id(),
                'ledgerable_type' => get_class($bill),
                'ledgerable_id' => $bill->id,
                'account_id' => $accounts_payable_id,
                'entry_type' => 'total',
            ], [
                'issued_at' => $bill->issued_at,
                'credit' => $bill->amount,
            ]);

            $bill->items()->each(function ($item) use ($bill) {
                $account_id = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();

                $ledger = RecurringLedger::where('ledgerable_type', get_class($item))->where('ledgerable_id', $item->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item),
                    'ledgerable_id' => $item->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $bill->issued_at,
                    'debit' => $item->total,
                ]);
            });

            $bill->item_taxes()->each(function ($item_tax) use ($bill) {
                $account_id = AccountTax::where('tax_id', $item_tax->tax_id)->pluck('account_id')->first();

                $ledger = RecurringLedger::where('ledgerable_type', get_class($item_tax))->where('ledgerable_id', $item_tax->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($item_tax),
                    'ledgerable_id' => $item_tax->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $bill->issued_at,
                    'debit' => $item_tax->amount,
                ]);
            });

            $bill->totals()->where('code', 'discount')->each(function ($total) use ($bill) {
                $account_id = Coa::code(setting('double-entry.accounts_purchase_discount', 475))->pluck('id')->first();

                $ledger = RecurringLedger::where('ledgerable_type', get_class($total))->where('ledgerable_id', $total->id)->first();

                if ($ledger) {
                    $account_id = $ledger->account_id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($total),
                    'ledgerable_id' => $total->id,
                    'account_id' => $account_id,
                    'entry_type' => 'discount',
                ], [
                    'issued_at' => $bill->issued_at,
                    'credit' => $total->amount,
                ]);
            });
        });
    }

    /**
     * Copy existing transactions that type's are expense to the ledgers.
     *
     * @return void
     */
    protected function copyExpenseTransactions()
    {
        Transaction::where('reference', 'NOT LIKE', 'journal-entry-ledger%')
            ->orWhereNull('reference')
            ->type('expense')
            ->isNotDocument()
            ->isNotTransfer()
            ->cursor()
            ->each(function ($transaction) {
                $account_id = AccountBank::where('bank_id', $transaction->account_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    $account = $this->createBankAccount($transaction->account);

                    $account_id = $account->id;
                }

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                ], [
                    'issued_at' => $transaction->paid_at,
                    'entry_type' => 'total',
                    'credit' => $transaction->amount,
                ]);

                $account_id = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();

                Ledger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'debit' => $transaction->amount,
                ]);

                $transaction_taxes = $transaction->taxes;

                foreach ($transaction_taxes as $transaction_tax) {
                    $account_id = AccountTax::where('tax_id', $transaction_tax->tax_id)->pluck('account_id')->first();

                    if (is_null($account_id)) {
                        continue;
                    }

                    Ledger::updateOrCreate([
                        'company_id' => company_id(),
                        'ledgerable_type' => get_class($transaction_tax),
                        'ledgerable_id' => $transaction_tax->id,
                        'account_id' => $account_id,
                        'entry_type' => 'item',
                    ], [
                        'issued_at' => $transaction_tax->created_at,
                        'credit' => $transaction_tax->amount,
                    ]);

                    $transaction_ledger = Ledger::where('ledgerable_id', $transaction_tax->transaction->id)
                        ->where('ledgerable_type', get_class($transaction_tax->transaction))
                        ->where('entry_type', 'item')
                        ->first();

                    if (is_null($transaction_ledger)) {
                        return;
                    }

                    $label = 'debit';

                    if ($transaction_tax->tax->type == 'withholding') {
                        $label = 'credit';
                    }

                    $transaction_ledger->update([
                        $label => $transaction_ledger->$label - $transaction_tax->amount,
                    ]);
                }
            }
        );
    }

    /**
     * Copy existing recurring transactions that type's are expense to the ledgers.
     *
     * @return void
     */
    protected function copyExpenseRecurringTransactions()
    {
        Transaction::where('reference', 'NOT LIKE', 'journal-entry-ledger%')
            ->orWhereNull('reference')
            ->type('expense-recurring')
            ->cursor()
            ->each(function ($transaction) {
                $account_id = AccountBank::where('bank_id', $transaction->account_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    $account = $this->createBankAccount($transaction->account);

                    $account_id = $account->id;
                }

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'total',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'credit' => $transaction->amount,
                ]);

                $account_id = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();

                RecurringLedger::updateOrCreate([
                    'company_id' => company_id(),
                    'ledgerable_type' => get_class($transaction),
                    'ledgerable_id' => $transaction->id,
                    'account_id' => $account_id,
                    'entry_type' => 'item',
                ], [
                    'issued_at' => $transaction->paid_at,
                    'debit' => $transaction->amount,
                ]);

                $transaction_taxes = $transaction->taxes;

                foreach ($transaction_taxes as $transaction_tax) {
                    $account_id = AccountTax::where('tax_id', $transaction_tax->tax_id)->pluck('account_id')->first();

                    if (is_null($account_id)) {
                        continue;
                    }

                    RecurringLedger::updateOrCreate([
                        'company_id' => company_id(),
                        'ledgerable_type' => get_class($transaction_tax),
                        'ledgerable_id' => $transaction_tax->id,
                        'account_id' => $account_id,
                        'entry_type' => 'item',
                    ], [
                        'issued_at' => $transaction_tax->created_at,
                        'credit' => $transaction_tax->amount,
                    ]);

                    $transaction_ledger = RecurringLedger::where('ledgerable_id', $transaction_tax->transaction->id)
                        ->where('ledgerable_type', get_class($transaction_tax->transaction))
                        ->where('entry_type', 'item')
                        ->first();

                    if (is_null($transaction_ledger)) {
                        return;
                    }

                    $label = 'debit';

                    if ($transaction_tax->tax->type == 'withholding') {
                        $label = 'credit';
                    }

                    $transaction_ledger->update([
                        $label => $transaction_ledger->$label - $transaction_tax->amount,
                    ]);
                }
            }
        );
    }

    /**
     * Creates a chart of account
     *
     * @param Account $account
     * @return Coa
     */
    protected function createBankAccount(Account $account)
    {
        $chart_of_account = Coa::create([
            'company_id' => company_id(),
            'type_id' => setting('double-entry.types_bank', 6),
            'code' => $this->getNextAccountCode(),
            'name' => $account->name,
            'enabled' => 1,
        ]);

        $chart_of_account->bank()->create([
            'company_id' => company_id(),
            'account_id' => $chart_of_account->id,
            'bank_id' => $account->id,
        ]);

        if ($account->opening_balance <= 0) {
            return $chart_of_account;
        }

        $owner_contribution = Coa::code(setting('double-entry.accounts_owners_contribution'))->first();

        if (is_null($owner_contribution)) {
            return $chart_of_account;
        }

        $request = [
            'company_id' => $account->company_id,
            'paid_at' => $account->created_at,
            'description' => trans('accounts.opening_balance') . ';' . $account->name,
            'reference' => 'opening-balance:' . $chart_of_account->id,
            'items' => [
                ['account_id' => $chart_of_account->id, 'debit' => $account->opening_balance],
                ['account_id' => $owner_contribution->id, 'credit' => $account->opening_balance],
            ],
        ];

        $this->dispatch(new CreateJournalEntry($request));

        return $chart_of_account;
    }
}
