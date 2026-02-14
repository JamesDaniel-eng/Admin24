<?php

namespace Modules\Payroll\Listeners\Update;

use App\Traits\Permissions;
use App\Models\Common\Report;
use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use App\Models\Module\Module;
use App\Models\Common\Company;

class Version3017 extends Listener
{
    use Permissions;

    const ALIAS = 'payroll';

    const VERSION = '3.0.17';
    
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

        $current_company_id = company_id();

        $company_ids = Module::allCompanies()->alias(static::ALIAS)->pluck('company_id');

        foreach ($company_ids as $company_id) {
            $company = Company::find($company_id);

            if (! $company instanceof Company) {
                continue;
            }

            $company->makeCurrent();

            $this->createReport();
        }

        company($current_company_id)->makeCurrent();
        
    }

    public function createReport()
    {
        Report::create([
            'company_id'    => company_id(),
            'class'         => 'Modules\Payroll\Reports\BenefitDeductionSummary',
            'name'          => trans('payroll::general.benefit_deduction_summary'),
            'description'   => trans('payroll::general.description_benefit_deduction_summary'),
            'settings'      => ['group' => 'employee', 'period' => 'quarterly'],
        ]);

        $this->attachPermissionsToAdminRoles(['payroll-reports-benefit-deduction-summary' => 'r']);
    }
}
