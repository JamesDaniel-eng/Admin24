<?php

namespace Modules\Inventory\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use Illuminate\Support\Facades\Artisan;

class Version4124 extends Listener
{
    const ALIAS = 'inventory';

    const VERSION = '4.1.24';

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

        $this->updateDatabase();
    }

    public function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }
}
