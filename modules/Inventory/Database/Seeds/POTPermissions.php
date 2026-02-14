<?php

namespace Modules\Inventory\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Permissions;
use Illuminate\Database\Seeder;

class POTPermissions extends Seeder
{
    use Permissions;

    public $alias = 'inventory';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-pot'       => 'c,r,u,d',
        ]);
    }
}
