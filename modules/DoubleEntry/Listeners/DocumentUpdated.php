<?php

namespace Modules\DoubleEntry\Listeners;

use App\Traits\Modules;
use App\Models\Document\Document;
use Modules\DoubleEntry\Traits\Permissions;
use App\Events\Document\DocumentUpdated as Event;

class DocumentUpdated
{
    use Modules, Permissions;

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($this->skipEvent($event->document)) {
            return;
        }

        $event->document->refresh();

        foreach ($event->document->items as $document_item) {
            if ($ledger = $document_item->de_ledger) {
                $ledger->issued_at = $event->document->issued_at;
                $ledger->save();
            }
        }

        foreach ($event->document->item_taxes as $document_item_tax) {
            if ($ledger = $document_item_tax->de_ledger) {
                $ledger->issued_at = $event->document->issued_at;
                $ledger->save();
            }
        }

        foreach ($event->document->totals as $document_total) {
            if ($ledger = $document_total->de_ledger) {
                $ledger->issued_at = $event->document->issued_at;
                $ledger->save();
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
            $this->isNotValidDocumentType($document->type)) {
            return true;
        }

        return false;
    }
}
