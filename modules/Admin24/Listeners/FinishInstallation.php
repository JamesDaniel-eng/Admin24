<?php

namespace Modules\Admin24\Listeners;

use App\Events\Module\Installed as Event;
use App\Traits\Permissions;
use Artisan;

class FinishInstallation
{
    use Permissions;

    public $alias = 'admin24';

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->updatePermissions();
        $this->callSeeds();
    }

    protected function updatePermissions()
    {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-main' => 'c,r,u,d',
            $this->alias . '-settings' => 'c,r,u,d',
        ]);

        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToPortalRoles([
            $this->alias . '-portal-assets' => 'c,r,u',
            $this->alias . '-portal-banking' => 'c,r,u,d',
            $this->alias . '-portal-customer-invoices' => 'c,r,u,d',
            $this->alias . '-portal-customers' => 'c,r,u,d',
            $this->alias . '-portal-expenses' => 'c,r,u,d',
            $this->alias . '-portal-main' => 'c,r,u,d',
            $this->alias . '-portal-payments' => 'c,r,u,d',
            $this->alias . '-portal-sale-items' => 'c,r,u,d',
            $this->alias . '-portal-settings' => 'c,r,u,d',
            $this->alias . '-portal-taxes' => 'c,r,u,d',
        ]);
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\Admin24\Database\Seeds\Admin24DatabaseSeeder',
        ]);
    }
}
