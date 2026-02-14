<?php

namespace Modules\Employees\Listeners;

use App\Traits\Contacts;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;
use App\Events\Module\Installed as Event;

class FinishInstallation
{
    use Contacts, Permissions;

    public $alias = 'employees';

    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->callSeeds();
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\Employees\Database\Seeds\EmployeesDatabaseSeeder',
        ]);
    }
}
