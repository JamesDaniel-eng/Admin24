<?php

namespace Modules\DoubleEntry\Traits;

use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Traits\Modules;

trait Permissions
{
    use Modules;

    protected function isNotValidDocumentType($type = null): bool
    {
        if (! $type) {
            return true;
        }

        $valid_document_types = [
            Document::INVOICE_TYPE,
            Document::BILL_TYPE,
        ];

        // This check can be implemented this way because it is only used within the view composer.
        if ($type == 'recurring-invoice' || $type == 'recurring-bill') {
            $type_exploded = explode('-', $type);

            $type = $type_exploded[1] . '-' . $type_exploded[0];

            $valid_document_types = [
                Document::INVOICE_RECURRING_TYPE,
                Document::BILL_RECURRING_TYPE
            ];
        }

        if ($this->moduleIsEnabled('credit-debit-notes')) {
            $valid_document_types[] = \Modules\CreditDebitNotes\Models\CreditNote::TYPE;
            $valid_document_types[] = \Modules\CreditDebitNotes\Models\DebitNote::TYPE;
        }

        if ($this->moduleIsEnabled('expenses')) {
            $valid_document_types[] = \Modules\Expenses\Models\ExpenseClaim::TYPE;
        }

        return ! in_array($type, $valid_document_types);
    }

    protected function isNotValidTransactionType($type = null): bool
    {
        if (! $type) {
            return true;
        }
        
        $valid_transaction_types = [
            Transaction::INCOME_TYPE,
            Transaction::EXPENSE_TYPE,
        ];

        // This check can be implemented this way because it is only used within the view composer.
        if ($type == 'recurring-income' || $type == 'recurring-expense') {
            $type_exploded = explode('-', $type);

            $type = $type_exploded[1] . '-' . $type_exploded[0];

            $valid_transaction_types = [
                Transaction::INCOME_RECURRING_TYPE,
                Transaction::EXPENSE_RECURRING_TYPE
            ];
        }

        if ($this->moduleIsEnabled('credit-debit-notes')) {
            $valid_transaction_types[] ='credit_note_refund';
            $valid_transaction_types[] ='debit_note_refund';
        }

        return ! in_array($type, $valid_transaction_types);
    }
}
