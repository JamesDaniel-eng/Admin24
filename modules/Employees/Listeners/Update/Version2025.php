<?php

namespace Modules\Employees\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished as Event;
use Illuminate\Support\Facades\DB;

class Version2025 extends Listener
{
    const ALIAS = 'employees';

    const VERSION = '2.0.25';

    public function handle(Event $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        DB::table('employees_dismissals')->whereNull('deleted_at')->groupBy('employee_id')->get()->each(function ($dismissal) {
            DB::table('employees_employees')->where('id', $dismissal->employee_id)->update([
                'dismissed' => 1
            ]);
        });
    }
}
