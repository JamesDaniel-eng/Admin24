<?php

namespace Modules\Employees\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished as Event;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;

class Version2023 extends Listener
{
    use Permissions;

    const ALIAS = 'employees';

    const VERSION = '2.0.23';

    public function handle(Event $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->updateDatabase();

        $this->updatePermissions();
    }

    protected function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }

    protected function updatePermissions()
    {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            self::ALIAS . '-dismissals' => 'c,r,u,d',
        ]);
    }
}
