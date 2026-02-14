<?php

namespace Modules\Payroll\Database\Seeds;

use App\Abstracts\Model;
use App\Models\Setting\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplates extends Seeder
{
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
        $company_id = $this->command->argument('company');

        EmailTemplate::firstOrCreate([
            'company_id' => $company_id,
            'alias'      => 'payroll_pay_slip',
            'class'      => 'Modules\Payroll\Notifications\PaySlip',
            'name'       => 'payroll::email_templates.payroll_pay_slip.title',
            'subject'    => trans('payroll::email_templates.payroll_pay_slip.subject'),
            'body'       => trans('payroll::email_templates.payroll_pay_slip.body'),
        ]);
    }
}
