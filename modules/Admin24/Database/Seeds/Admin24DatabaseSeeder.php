<?php

namespace Modules\Admin24\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;

class Admin24DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
