<?php

namespace Modules\DoubleEntry\Listeners\RecurringDocument;

use App\Events\Document\DocumentUpdated as Event;
use App\Models\Document\Document;
use App\Traits\Modules;
use App\Traits\Jobs;
use Modules\DoubleEntry\Models\AccountTax;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Jobs\RecurringLedger\CreateRecurringLedger;
use Modules\DoubleEntry\Jobs\RecurringLedger\UpdateRecurringLedger;
use Modules\DoubleEntry\Traits\Accounts;
use Modules\DoubleEntry\Traits\Recurring;
use Modules\DoubleEntry\Traits\Permissions;

class UpdateDocument
{
    use Accounts, Jobs, Permissions, Modules, Recurring;

    /**
     * Handle the event.
     *
     * @param DocumentUpdated $event
     * @return void
     */
    public function handle(Event $event)
    {
        $document = $event->document->refresh();

        if ($this->skipEvent($document)) {
            return;
        }

        $ledger = RecurringLedger::record($document->id, get_class($document))->first();

        if (is_null($ledger)) {
            return;
        }

        $request = $this->getDocumentBaseRequest($document);

        $request = $this->appendDocumentSpecificFields($request, $document);

        $this->dispatch(new UpdateRecurringLedger($ledger, $request));

        $document_items = $document->items;

        foreach ($document_items as $item_key => $document_item) {      
            $request = $this->getDocumentItemBaseRequest($document, $document_item, $item_key);

            $request = $this->appendDocumentItemSpecificFields($request, $document_item);

            $this->dispatch(new CreateRecurringLedger($request));

            $document_item_taxes = $document_item->taxes;

            foreach ($document_item_taxes as $document_item_tax) {
                $account_id = AccountTax::where('tax_id', $document_item_tax->tax_id)->pluck('account_id')->first();

                if (is_null($account_id)) {
                    continue;
                }

                $request = $this->getDocumentItemTaxBaseRequest($document, $document_item_tax);

                $request['account_id'] = $account_id;

                $this->dispatch(new CreateRecurringLedger($request));

                if ($document_item_tax->tax->type == 'inclusive') {
                    $this->updateDocumentItemLedger($document_item_tax);
                }
            }
        }

        $document_totals = $document->totals;

        foreach ($document_totals as $document_total) {
            if ($document_total->code != 'discount') {
                continue;
            }

            $request = $this->getDocumentTotalBaseRequest($document, $document_total);
    
            $request = $this->appendDocumentTotalSpecificFields($request, $document_total);

            $ledger = RecurringLedger::record($document_total->id, get_class($document_total))->first();

            if (is_null($ledger)) {
                $this->dispatch(new CreateRecurringLedger($request));
            } else {
                $this->dispatch(new UpdateRecurringLedger($ledger, $request));
            }
        }
    }

    /**
     * Determines event will be continued or not.
     *
     * @param Document $document
     * @return bool
     */
    private function skipEvent(Document $document)
    {
        if ($this->moduleIsDisabled('double-entry') ||
            ! in_array($document->type, [Document::INVOICE_RECURRING_TYPE, Document::BILL_RECURRING_TYPE])) {
            return true;
        }

        return false;
    }
}
