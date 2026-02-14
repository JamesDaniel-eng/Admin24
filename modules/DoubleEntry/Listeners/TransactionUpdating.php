<?php

namespace Modules\DoubleEntry\Listeners;

use App\Events\Banking\TransactionUpdating as Event;
use App\Traits\Modules;

class TransactionUpdating
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('double-entry')) {
            return;
        }

        $group = request()->segment(2);
        $prefix = request()->segment(3);

        if ($group !== 'banking' && $prefix !== 'transactions') {
            return;
        }

        $transaction = $event->transaction;

        if (! in_array($transaction->type, ['income', 'expense'])) {
            return;
        }

        if (! $transaction->journal) {
            return;
        }

        throw new \Exception(trans('double-entry::messages.transaction_cannot_be_updated', [
            'url' => route('double-entry.journal-entry.edit', $transaction->journal->id),
        ]));
        
    }
}
