<?php

namespace Modules\CompositeItems\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;

class Version210 extends Listener
{
    use Permissions;

    const ALIAS = 'composite-items';

    const VERSION = '2.1.0';

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

        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);

        $this->attachPermissionsToAdminRoles([
            self::ALIAS . '-settings' => 'r,u',
        ]);
    }
}
