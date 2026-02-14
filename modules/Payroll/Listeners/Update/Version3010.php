<?php

namespace Modules\Payroll\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Traits\Permissions;

class Version3010 extends Listener
{
    use Permissions;

    const ALIAS = 'payroll';

    const VERSION = '3.0.10';
    
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
        $rows = [
            'employee' => [
                self::ALIAS . '-pay-slips' => 'r'
            ],
        ];

        $this->attachPermissionsByRoleNames($rows);
    }
}
