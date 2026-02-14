<?php

namespace Modules\Employees\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished as Event;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;

class Version2024 extends Listener
{
    use Permissions;

    const ALIAS = 'employees';

    const VERSION = '2.0.24';

    public function handle(Event $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }
}
