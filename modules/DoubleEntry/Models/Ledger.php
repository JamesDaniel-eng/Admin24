<?php

namespace Modules\DoubleEntry\Models;

use App\Abstracts\Model;
use App\Models\Banking\Transaction;
use App\Models\Banking\TransactionTax;
use App\Models\Document\Document;
use App\Models\Document\DocumentItem;
use App\Models\Document\DocumentItemTax;
use App\Models\Document\DocumentTotal;
use App\Traits\Modules;
use Modules\CreditDebitNotes\Models\CreditNote;
use Modules\CreditDebitNotes\Models\DebitNote;
use Modules\DoubleEntry\Casts\DefaultCurrency;
use Modules\DoubleEntry\Models\Journal;
use Modules\Expenses\Models\ExpenseClaim;

class Ledger extends Model
{
    use Modules;

    protected $table = 'double_entry_ledger';

    protected $fillable = ['company_id', 'account_id', 'transaction_id', 'ledgerable_id', 'ledgerable_type', 'issued_at', 'entry_type', 'debit', 'credit', 'notes', 'created_from', 'created_by'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['ledgerable'];

    public function account()
    {
        return $this->belongsTo('Modules\DoubleEntry\Models\Account')->withDefault(['name' => trans('general.na')]);
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Banking\Transaction');
    }

    public function ledgerable()
    {
        return $this->morphTo();
    }

    /**
     * Scope record.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $id
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecord($query, $id, $type)
    {
        return $query->where('ledgerable_id', $id)->where('ledgerable_type', $type);
    }

    public function scopeCash($query)
    {
        $query->where('ledgerable_type', Transaction::class)
            ->OrWhereHasMorph('ledgerable', [
                Journal::class,
            ], function ($query) {
                $query->where('basis', 'cash');
            });
    }

    public function scopeAccrual($query)
    {
        $query->whereHasMorph('ledgerable', [
            Document::class,
            DocumentItem::class,
            DocumentItemTax::class,
            DocumentTotal::class,
            Transaction::class,
            TransactionTax::class,
            Journal::class,
        ], function ($query, $type) {
            if ($type == 'App\Models\Document\Document') {
                $query->accrued();
            }

            if (in_array($type, ['App\Models\Document\DocumentItem', 'App\Models\Document\DocumentItemTax', 'App\Models\Document\DocumentTotal'])) {
                $query->whereHas('document', function ($query) {
                    $query->accrued();
                });
            }
        });
    }

    public function scopeContact($query, $contact)
    {
        if (empty($contact)) {
            return $query;
        }

        $query->whereHasMorph('ledgerable', [
            Document::class,
            DocumentItem::class,
            DocumentItemTax::class,
            DocumentTotal::class,
            Transaction::class,
            TransactionTax::class,
        ], function ($query, $type) use ($contact) {
            if (in_array($type, [Document::class, Transaction::class])) {
                $query->contact($contact);
            }

            if (in_array($type, ['App\Models\Document\DocumentItem', 'App\Models\Document\DocumentItemTax', 'App\Models\Document\DocumentTotal'])) {
                $query->whereHas('document', function ($query) use ($contact) {
                    $query->contact($contact);
                });
            }
        });
    }

    public function getDescriptionAttribute()
    {
        $ledgerable = $this->ledgerable;

        if (!$ledgerable) {
            return '';
        }

        switch ($this->ledgerable_type) {
            case 'App\Models\Banking\Transaction':

                if ($ledgerable->type == 'income') {
                    $label = trans('revenues.revenue_received') . '. ' . trans('revenues.paid_by') . ' ' . $ledgerable->contact->name;
                } else {
                    $label = trans('payments.payment_made') . '. ' . trans('payments.paid_to') . ' ' . $ledgerable->contact->name;
                }

                break;

            case 'Modules\DoubleEntry\Models\Journal':

                $label = $ledgerable->description;

                if (empty($label)) {
                    $label = trans_choice('double-entry::general.manual_journals', 1) . '-' . $ledgerable->id;
                }

                break;

            case 'App\Models\Document\Document':

                if ($ledgerable->type == 'invoice') {
                    $label = trans('invoices.invoice_number') . ': ' . $ledgerable->document_number;
                } else {
                    $label = trans('bills.bill_number') . ': ' . $ledgerable->document_number;
                }

                break;

            case 'App\Models\Document\DocumentItem':
            case 'App\Models\Document\DocumentItemTax':

                if ($ledgerable->type == 'invoice') {
                    $label = trans('invoices.invoice_number') . ': ' . $ledgerable->document->document_number;
                } else {
                    $label = trans('bills.bill_number') . ': ' . $ledgerable->document->document_number;
                }

                break;

            default:
                $label = '';

                break;
        }

        return $label;
    }

    public function getTransactionLabelAttribute()
    {
        $ledgerable = $this->ledgerable;

        if (!$ledgerable) {
            return trans('general.na');
        }

        switch ($this->ledgerable_type) {
            case 'App\Models\Banking\Transaction':

                $label = '#' . $ledgerable->id;

                break;

            case 'Modules\DoubleEntry\Models\Journal':

                $label = '#' . $ledgerable->id;

                if (!empty($ledgerable->journal_number)) {
                    $label = '#' . $ledgerable->journal_number;
                }

                break;

            case 'App\Models\Document\Document':

                $label = '#' . $ledgerable->document_number;

                break;

            case 'App\Models\Document\DocumentItem':
            case 'App\Models\Document\DocumentItemTax':

                $label = '#' . $ledgerable->document->document_number;

                break;

            default:
                $label = trans('general.na');

                break;
        }

        return $label;
    }

    public function getLedgerableLinkAttribute()
    {
        $ledgerable = $this->ledgerable;

        if (!$ledgerable) {
            return null;
        }

        $company_id = $this->company_id;
        $document_id = null;
        $document_type = null;

        // Determine document type and ID based on ledgerable type
        switch ($this->ledgerable_type) {
            case 'Modules\DoubleEntry\Models\Journal':
                $document_id = $ledgerable->id;
                $document_type = 'journal';
                break;

            case 'App\Models\Banking\Transaction':
                $document_id = $ledgerable->id;
                $document_type = 'transaction';
                break;

            case 'App\Models\Document\Document':
                $document_id = $ledgerable->id;
                $document_type = $ledgerable->type; // 'invoice' or 'bill'
                break;

            case 'App\Models\Document\DocumentItem':
            case 'App\Models\Document\DocumentItemTax':
                if ($ledgerable->document) {
                    $document_id = $ledgerable->document->id;
                    $document_type = $ledgerable->document->type; // 'invoice' or 'bill'
                }
                break;

            default:
                return null;
        }

        if (!$document_id || !$document_type) {
            return null;
        }

        // Build the link based on document type
        switch ($document_type) {
            case 'journal':
                return route('double-entry.journal-entry.show', $document_id);

            case 'transaction':
                return route('transactions.show', $document_id);

            case 'invoice':
                return route('invoices.show', $document_id);

            case 'bill':
                return route('bills.show', $document_id);

            case CreditNote::TYPE:
                if ($this->moduleIsEnabled('credit-debit-notes')) {
                    return route('credit-debit-notes.credit-notes.show', $document_id);
                }
                break;

            case DebitNote::TYPE:
                if ($this->moduleIsEnabled('credit-debit-notes')) {
                    return route('credit-debit-notes.debit-notes.show', $document_id);
                }
                break;

            case ExpenseClaim::TYPE:
                if ($this->moduleIsEnabled('expenses')) {
                    return route('expenses.expense-claims.show', $document_id);
                }
                break;
        }

        return null;
    }

    public function castDebit($castable = DefaultCurrency::class)
    {
        $this->mergeCasts([
            'debit' => $castable,
        ]);
    }

    public function castCredit($castable = DefaultCurrency::class)
    {
        $this->mergeCasts([
            'credit' => $castable,
        ]);
    }
}
