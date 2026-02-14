<?php

namespace Modules\DoubleEntry\Listeners\Update\V41;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Traits\Permissions;

class Version414 extends Listener
{
    use Permissions;

    const ALIAS = 'double-entry';

    const VERSION = '4.1.4';

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

        $this->updatePermissions();
    }

    protected function updatePermissions()
    {
        $this->attachPermissionsByRoleNames([
            'accountant' => [
                self::ALIAS . '-chart-of-accounts' => 'r',
                self::ALIAS . '-journal-entry' => 'r',
                self::ALIAS . '-reports-balance-sheet' => 'r',
                self::ALIAS . '-reports-general-ledger' => 'r',
                self::ALIAS . '-reports-journal-report' => 'r',
                self::ALIAS . '-reports-trial-balance' => 'r',
            ]
        ]);
    }
}
