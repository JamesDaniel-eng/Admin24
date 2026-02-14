<?php

namespace Modules\Payroll\Jobs\RunPayroll;

use App\Abstracts\Job;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployee;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeBenefit;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeDeduction;
use Modules\Payroll\Services\RunPayroll as RunPayrollService;
use Modules\Payroll\Traits\RunPayrolls;

class CreateRunPayrollEmployees extends Job
{
    use RunPayrolls;

    protected $pay_calendar;

    protected $run_payroll;

    protected $request;

    protected $run_payroll_service;

    public function __construct($pay_calendar, $run_payroll, $request)
    {
        $this->pay_calendar = $pay_calendar;
        $this->run_payroll = $run_payroll;
        $this->request = $request;

        $this->run_payroll_service = new RunPayrollService($run_payroll);
    }

    public function handle()
    {
        $grand_total = 0;

        foreach ($this->pay_calendar->employees as $pay_calendar_employee) {
            $employee = $pay_calendar_employee->employee;

            $benefits = $this->run_payroll_service->determineBenefits($employee);

            $deductions = $this->run_payroll_service->determineDeductions($employee);

            $benefits_sum = $this->getBenefits($this->pay_calendar->type, $employee, $benefits);

            $deductions_sum = $this->getDeductions($this->pay_calendar->type, $employee, $deductions);

            $salary = $this->getSalary($this->pay_calendar->type, $employee);

            $total = ($salary + $benefits_sum) - $deductions_sum;

            $currency = $employee->contact->currency;

            // Convert total to run payroll currency if different
            $converted_total = $total;
            $stored_total = $total;
            
            if ($this->run_payroll->currency_code != $currency->code) {
                $converted_total = money($total, $currency->code)
                    ->convert(currency($this->run_payroll->currency_code), $currency->rate)
                    ->getAmount();
                $stored_total = $converted_total;
            }

            // Use updateOrCreate to prevent duplicate entries
            RunPayrollEmployee::updateOrCreate(
                [
                    'run_payroll_id' => $this->run_payroll->id,
                    'employee_id' => $employee->id,
                ],
                [
                    'company_id'      => $this->pay_calendar->company_id,
                    'pay_calendar_id' => $this->pay_calendar->id,
                    'salary'          => $salary,
                    'benefit'         => $benefits_sum,
                    'deduction'       => $deductions_sum,
                    'total'           => $stored_total
                ]
            );

            foreach ($benefits as $benefit) {
                if ($benefit->recurring == "everymonth" && $this->pay_calendar->type != "monthly") {
                    continue;
                }
                RunPayrollEmployeeBenefit::create([
                    'company_id'          => $this->run_payroll->company_id,
                    'employee_id'         => $employee->id,
                    'employee_benefit_id' => $benefit->id,
                    'pay_calendar_id'     => $this->pay_calendar->id,
                    'run_payroll_id'      => $this->run_payroll->id,
                    'type'                => $benefit->type,
                    'amount'              => $benefit->amount,
                    'currency_code'       => $currency->code,
                    'currency_rate'       => $currency->rate
                ]);
            }

            foreach ($deductions as $deduction) {
                if ($deduction->recurring == "everymonth" && $this->pay_calendar->type != "monthly") {
                    continue;
                }
                RunPayrollEmployeeDeduction::create([
                    'company_id'            => $this->run_payroll->company_id,
                    'employee_id'           => $employee->id,
                    'employee_deduction_id' => $deduction->id,
                    'pay_calendar_id'       => $this->pay_calendar->id,
                    'run_payroll_id'        => $this->run_payroll->id,
                    'type'                  => $deduction->type,
                    'amount'                => $deduction->amount,
                    'currency_code'         => $currency->code,
                    'currency_rate'         => $currency->rate
                ]);
            }

            $grand_total += $converted_total;
        }

        $this->request['grand_total'] = $grand_total;
    }
}
