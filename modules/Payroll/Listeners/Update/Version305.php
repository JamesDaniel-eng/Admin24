<?php

namespace Modules\Payroll\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\File;

class Version305 extends Listener
{
    const ALIAS = 'payroll';

    const VERSION = '3.0.5';

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

        File::delete(base_path('modules/Payroll/Resources/assets/js/employee.js'));
        File::delete(base_path('modules/Payroll/Resources/assets/js/employee.min.js'));
    }
}
