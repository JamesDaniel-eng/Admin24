<?php

namespace Modules\DoubleEntry\Listeners\RecurringDocument;

use App\Events\Document\DocumentDeleted as Event;
use App\Models\Document\Document;
use App\Traits\Modules;
use App\Traits\Jobs;
use Modules\DoubleEntry\Models\RecurringLedger;
use Modules\DoubleEntry\Jobs\RecurringLedger\DeleteRecurringLedger;

class DeleteDocument
{
    use Jobs, Modules;

    /**
     * Handle the event.
     *
     * @param DocumentDeleted $event
     * @return void
     */
    public function handle(Event $event)
    {
        $document = $event->document;

        if ($this->skipEvent($document)) {
            return;
        }

        $ledger = RecurringLedger::record($document->id, get_class($document))->first();

        if (is_null($ledger)) {
            return;
        }

        $this->dispatch(new DeleteRecurringLedger($ledger));

        $document_items = $document->items;

        foreach ($document_items as $document_item) {
            $ledger = RecurringLedger::record($document_item->id, get_class($document_item))->first();

            if (is_null($ledger)) {
                continue;
            }

            $this->dispatch(new DeleteRecurringLedger($ledger));

            $document_item_taxes = $document_item->taxes;

            foreach ($document_item_taxes as $document_item_tax) {
                $ledger = RecurringLedger::record($document_item_tax->id, get_class($document_item_tax))->first();

                if (is_null($ledger)) {
                    continue;
                }

                $this->dispatch(new DeleteRecurringLedger($ledger));
            }
        }

        $document_totals = $document->totals;

        foreach ($document_totals as $document_total) {
            $ledger = RecurringLedger::record($document_total->id, get_class($document_total))->first();

            if (is_null($ledger)) {
                continue;
            }

            $this->dispatch(new DeleteRecurringLedger($ledger));
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
