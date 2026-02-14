<?php

namespace Modules\DoubleEntry\Listeners\Update\V41;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Banking\Transaction;
use App\Models\Common\Company;
use App\Models\Module\Module;
use App\Models\Document\Document;
use App\Traits\Jobs;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Modules\DoubleEntry\Models\Account as Coa;
use Modules\DoubleEntry\Models\AccountBank;
use Modules\DoubleEntry\Models\AccountTax;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Models\Ledger;
use Modules\DoubleEntry\Jobs\RecurringLedger\CreateRecurringLedger;
use Modules\DoubleEntry\Jobs\RecurringLedger\UpdateRecurringLedger;
use Modules\DoubleEntry\Jobs\Ledger\CreateLedger;
use Modules\DoubleEntry\Jobs\Ledger\UpdateLedger;
use Modules\DoubleEntry\Traits\Recurring;

class Version410 extends Listener
{
    use Jobs, Recurring;

    const ALIAS = 'double-entry';

    const VERSION = '4.1.0';

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

        $this->updateDatabase();


        /* 
            This function should only be executed manually for companies experiencing recurring ledger issues.
            Running it for all companies is risky. It uses the default chart of accounts (COA). 
        */
        // $this->updateCompanies();
    }

    public function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }

    public function updateCompanies()
    {
        Log::channel('stderr')->info('Updating companies...');

        $current_company_id = company_id();

        $company_ids = Module::allCompanies()->alias('double-entry')->pluck('company_id');

        foreach ($company_ids as $company_id) {
            Log::channel('stderr')->info('Updating company: ' . $company_id);

            $company = Company::find($company_id);

            if (! $company instanceof Company) {
                continue;
            }

            $company->makeCurrent();

            $recurring_documents = Document::whereIn('type', [Document::INVOICE_RECURRING_TYPE, Document::BILL_RECURRING_TYPE])
                ->whereHas('recurring', function ($recurring) {
                    $recurring->whereNull('deleted_at');
                })
                ->get();

            if ($recurring_documents->isNotEmpty()) {
                foreach ($recurring_documents as $recurring_document) {
                    $this->addedDocumentRecurringLedgers($recurring_document);
                }
            }

            $recurring_transactions = Transaction::whereIn('type', [Transaction::INCOME_RECURRING_TYPE, Transaction::EXPENSE_RECURRING_TYPE])
                ->whereHas('recurring', function ($recurring) {
                    $recurring->whereNull('deleted_at');
                })
                ->get();

            if ($recurring_transactions->isNotEmpty()) {
                foreach ($recurring_transactions as $recurring_transaction) {
                    $this->addedTransactionRecurringLedgers($recurring_transaction);
                }
            }

            Log::channel('stderr')->info('Company updated: ' . $company_id);
        }

        company($current_company_id)->makeCurrent();

        Log::channel('stderr')->info('Companies updated.');
    }

    public function addedDocumentRecurringLedgers($recurring_document) 
    {
        $request = $this->getDocumentBaseRequest($recurring_document);
        $request = $this->appendDocumentSpecificFields($request, $recurring_document);

        $this->dispatch(new CreateRecurringLedger($request));

        $this->addedDocumentItemRecurringLedgers($recurring_document);
        $this->addedDocumentTotalRecurringLedgers($recurring_document);
        $this->addedDocumentChildLedgers($recurring_document);
    }

    public function addedDocumentItemRecurringLedgers($recurring_document) 
    {
        $document_items = $recurring_document->items;

        foreach ($document_items as $document_item) {      
            $request = [
                'company_id'        => $document_item->company_id,
                'ledgerable_id'     => $document_item->id,
                'ledgerable_type'   => get_class($document_item),
                'issued_at'         => $recurring_document->issued_at,
                'entry_type'        => 'item',
            ];

            $total = $this->calculateDocumentItemTotal($document_item);

            if ($document_item->type == Document::INVOICE_RECURRING_TYPE) {
                $request['credit'] = $total;
                $request['account_id'] = Coa::code(setting('double-entry.accounts_sales', 400))->pluck('id')->first();
            }
    
            if ($document_item->type == Document::BILL_RECURRING_TYPE) {
                $request['debit'] = $total;
                $request['account_id'] = Coa::code(setting('double-entry.accounts_expenses', 628))->pluck('id')->first();
            }
            
            $this->dispatch(new CreateRecurringLedger($request));

            $this->addedDocumentItemTaxRecurringLedgers($recurring_document, $document_item);
        }
    }

    public function addedDocumentItemTaxRecurringLedgers($recurring_document, $document_item) 
    {
        $document_item_taxes = $document_item->taxes;

        foreach ($document_item_taxes as $document_item_tax) {
            $account_id = AccountTax::where('tax_id', $document_item_tax->tax_id)->pluck('account_id')->first();

            if (is_null($account_id)) {
                continue;
            }

            $request = $this->getDocumentItemTaxBaseRequest($recurring_document, $document_item_tax);

            $request['account_id'] = $account_id;

            $this->dispatch(new CreateRecurringLedger($request));

            if ($document_item_tax->tax->type == 'inclusive') {
                $this->updateDocumentItemLedger($document_item_tax);
            }
        }
    }

    public function addedDocumentTotalRecurringLedgers($recurring_document) 
    {
        $document_totals = $recurring_document->totals;

        foreach ($document_totals as $document_total) {
            if ($document_total->code != 'discount') {
                continue;
            }

            $request = $this->getDocumentTotalBaseRequest($recurring_document, $document_total);

            $request = $this->appendDocumentTotalSpecificFields($request, $document_total);

            $this->dispatch(new CreateRecurringLedger($request));
        }
    }

    public function addedDocumentChildLedgers($recurring_document) 
    {
        $child_documents = $recurring_document->children;

        foreach ($child_documents as $child_document) {
            $ledger = Ledger::record($child_document->id, get_class($child_document))->first();

            if (is_null($ledger) && ! is_null($child_document->parent_id)) {
                $recurring_ledger = RecurringLedger::record($recurring_document->id, get_class($recurring_document))->first();

                if (is_null($recurring_ledger)) {
                    continue;
                }

                $request = [
                    'company_id'        => $child_document->company_id,
                    'ledgerable_id'     => $child_document->id,
                    'ledgerable_type'   => get_class($child_document),
                    'issued_at'         => $child_document->issued_at,
                    'entry_type'        => 'total',
                    'account_id'        => $recurring_ledger->account_id,
                    'credit'            => $recurring_ledger->credit,
                    'debit'             => $recurring_ledger->debit,
                ];

                $this->dispatch(new CreateLedger($request));

                $this->addedDocumentItemChildLedgers($recurring_document, $child_document);
                $this->addedDocumentTotalChildLedgers($recurring_document, $child_document);
            }
        }
    }

    public function addedDocumentItemChildLedgers($recurring_document, $child_document) 
    {
        $document_items = $child_document->items;
    
        foreach ($document_items as $item_key => $document_item) {     
            $parent_document_item = $recurring_document->items[$item_key];

            $recurring_ledger = RecurringLedger::record($parent_document_item->id, get_class($parent_document_item))->first();

            if (is_null($recurring_ledger)) {
                continue;
            }
            
            $request = [
                'company_id'        => $document_item->company_id,
                'ledgerable_id'     => $document_item->id,
                'ledgerable_type'   => get_class($document_item),
                'issued_at'         => $child_document->issued_at,
                'entry_type'        => 'item',
                'account_id'        => $recurring_ledger->account_id,
                'credit'            => $recurring_ledger->credit,
                'debit'             => $recurring_ledger->debit,
            ];
        
            $this->dispatch(new CreateLedger($request));

            $this->addedDocumentItemTaxChildLedgers($document_item, $parent_document_item, $child_document);
        }
    }

    public function addedDocumentItemTaxChildLedgers($document_item, $parent_document_item, $child_document) 
    {
        $document_item_taxes = $document_item->taxes;

        foreach ($document_item_taxes as $item_tax_key =>$document_item_tax) {
            $parent_document_item_tax = $parent_document_item->taxes[$item_tax_key];

            $recurring_ledger = RecurringLedger::record($parent_document_item_tax->id, get_class($parent_document_item_tax))->first();
            
            $request = [
                'company_id'        => $document_item_tax->company_id,
                'ledgerable_id'     => $document_item_tax->id,
                'ledgerable_type'   => get_class($document_item_tax),
                'issued_at'         => $child_document->issued_at,
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

    public function addedDocumentTotalChildLedgers($recurring_document, $child_document) 
    {
        $document_totals = $child_document->totals;

        foreach ($document_totals as $total_key => $document_total) {
            if ($document_total->code != 'discount') {
                continue;
            }

            $parent_document_total = $recurring_document->totals[$total_key];

            $recurring_ledger = RecurringLedger::record($parent_document_total->id, get_class($parent_document_total))->first();

            if (is_null($recurring_ledger)) {
                continue;
            }

            $request = [
                'company_id'        => $document_total->company_id,
                'ledgerable_id'     => $document_total->id,
                'ledgerable_type'   => get_class($document_total),
                'issued_at'         => $child_document->issued_at,
                'entry_type'        => 'discount',
                'account_id'        => $recurring_ledger->account_id,
                'credit'            => $recurring_ledger->credit,
                'debit'             => $recurring_ledger->debit,
            ];

            $this->dispatch(new CreateLedger($request));
        }
    }

    public function addedTransactionRecurringLedgers($recurring_transaction) 
    {
        $account_id = AccountBank::where('bank_id', $recurring_transaction->account_id)
            ->pluck('account_id')
            ->first();

        if (empty($account_id)) {
            return;
        }

        $request = $this->getTransactionBaseRequest($recurring_transaction);

        $total_request = $this->getTransactionTotalBaseRequest($request, $recurring_transaction, $account_id);

        $this->dispatch(new CreateRecurringLedger($total_request));

        $item_request = $this->getTransactionItemBaseRequest($request, $recurring_transaction);

        $item_ledger = $this->dispatch(new CreateRecurringLedger($item_request));

        $this->addedTransactionTaxRecurringLedgers($recurring_transaction, $item_ledger);

        $this->addedTransactionChildLedgers($recurring_transaction);
    }

    public function addedTransactionTaxRecurringLedgers($recurring_transaction, $item_ledger) 
    {
        foreach ($recurring_transaction->taxes as $transaction_tax) {
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

    public function addedTransactionChildLedgers($recurring_transaction) 
    {
        $child_transactions = $recurring_transaction->children;

        foreach ($child_transactions as $child_transaction) {
            $ledger = Ledger::record($child_transaction->id, get_class($child_transaction))->first();

            if (is_null($ledger) && ! is_null($child_transaction->parent_id)) {
                $total_recurring_ledger = RecurringLedger::record($recurring_transaction->id, get_class($recurring_transaction))
                    ->where('entry_type', 'total')
                    ->first();

                if (is_null($total_recurring_ledger)) {
                    continue;
                }

                $item_recurring_ledger = RecurringLedger::record($recurring_transaction->id, get_class($recurring_transaction))
                    ->where('entry_type', 'item')
                    ->first();

                if (is_null($item_recurring_ledger)) {
                    continue;
                }

                $this->dispatch(new CreateLedger([
                    'company_id'        => $child_transaction->company_id,
                    'ledgerable_id'     => $child_transaction->id,
                    'ledgerable_type'   => get_class($child_transaction),
                    'issued_at'         => $child_transaction->paid_at,
                    'entry_type'        => 'total',
                    'account_id'        => $total_recurring_ledger->account_id,
                    'credit'            => $total_recurring_ledger->credit,
                    'debit'             => $total_recurring_ledger->debit,
                ]));

                $this->dispatch(new CreateLedger([
                    'company_id'        => $child_transaction->company_id,
                    'ledgerable_id'     => $child_transaction->id,
                    'ledgerable_type'   => get_class($child_transaction),
                    'issued_at'         => $child_transaction->paid_at,
                    'entry_type'        => 'item',
                    'account_id'        => $item_recurring_ledger->account_id,
                    'credit'            => $item_recurring_ledger->credit,
                    'debit'             => $item_recurring_ledger->debit,
                ]));
            }

            $this->addedTransactionTaxChildLedgers($recurring_transaction);
        }
    }

    public function addedTransactionTaxChildLedgers($recurring_transaction) 
    {
        $child_transaction_taxes = $recurring_transaction->taxes; 

        foreach ($child_transaction_taxes as $child_transaction_tax) {
            $tax_recurring_ledger = RecurringLedger::record($child_transaction_tax->id, get_class($child_transaction_tax))->first();

            if (is_null($tax_recurring_ledger)) {
                continue;
            }

            $this->dispatch(new CreateLedger([
                'company_id'        => $child_transaction_tax->company_id,
                'ledgerable_id'     => $child_transaction_tax->id,
                'ledgerable_type'   => get_class($child_transaction_tax),
                'issued_at'         => $child_transaction_tax->created_at,
                'entry_type'        => $tax_recurring_ledger->entry_type,
                'account_id'        => $tax_recurring_ledger->account_id,
                'credit'            => $tax_recurring_ledger->credit,
                'debit'             => $tax_recurring_ledger->debit,
            ]));
        }
    }
}
