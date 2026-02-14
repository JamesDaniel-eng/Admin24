<?php

namespace Modules\DoubleEntry\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Permissions as Helper;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    use Helper;

    public $alias = 'double-entry';

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

    /**
     * Creates permissions.
     * 
     * @return void
     */
    private function create()
    {
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-chart-of-accounts' => 'c,r,u,d',
            $this->alias . '-journal-entry' => 'c,r,u,d',
            $this->alias . '-settings' => 'r,u',
        ],);

        $this->attachPermissionsByRoleNames([
            'accountant' => [
                $this->alias . '-chart-of-accounts' => 'r',
                $this->alias . '-journal-entry' => 'r',
                $this->alias . '-reports-balance-sheet' => 'r',
                $this->alias . '-reports-general-ledger' => 'r',
                $this->alias . '-reports-journal-report' => 'r',
                $this->alias . '-reports-trial-balance' => 'r',
            ]
        ]);
    }
}
