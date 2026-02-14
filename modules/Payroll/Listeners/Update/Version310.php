<?php

namespace Modules\Payroll\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Common\Company;
use App\Models\Module\Module;
use App\Models\Setting\EmailTemplate;
use Illuminate\Support\Facades\Log;

class Version310 extends Listener
{
    const ALIAS = 'payroll';

    const VERSION = '3.1.0';

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

        Log::channel('stdout')->info('Updating companies...');

        $current_company_id = company_id();

        $company_ids = Module::allCompanies()->alias(static::ALIAS)->pluck('company_id');

        foreach ($company_ids as $company_id) {
            Log::channel('stdout')->info('Updating company: ' . $company_id);

            $company = Company::find($company_id);

            if (! $company instanceof Company) {
                continue;
            }

            $company->makeCurrent();

            $this->addedEmailTemplate();

            Log::channel('stdout')->info('Company updated: ' . $company_id);
        }

        company($current_company_id)->makeCurrent();

        Log::channel('stdout')->info('Companies updated.');
    }

    public function addedEmailTemplate()
    {
        EmailTemplate::firstOrCreate([
            'company_id' => company_id(),
            'alias'      => 'payroll_pay_slip',
            'class'      => 'Modules\Payroll\Notifications\PaySlip',
            'name'       => 'payroll::email_templates.payroll_pay_slip.title',
            'subject'    => trans('payroll::email_templates.payroll_pay_slip.subject'),
            'body'       => trans('payroll::email_templates.payroll_pay_slip.body'),
        ]);
    }
}