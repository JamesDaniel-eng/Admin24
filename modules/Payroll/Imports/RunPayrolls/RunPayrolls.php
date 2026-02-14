<?php

namespace Modules\Payroll\Imports\RunPayrolls;

use App\Abstracts\ImportMultipleSheets;
use Modules\Employees\Imports\Employees;
use Modules\Employees\Imports\Departments;
use Modules\Payroll\Imports\RunPayrolls\Sheets\EmployeeBenefits;
use Modules\Payroll\Imports\RunPayrolls\Sheets\EmployeeDeductions;
use Modules\Payroll\Imports\RunPayrolls\Sheets\RunPayrolls as Base;
use Modules\Payroll\Imports\RunPayrolls\Sheets\RunPayrollEmployeeBenefits;
use Modules\Payroll\Imports\RunPayrolls\Sheets\RunPayrollEmployeeDeductions;
use Modules\Payroll\Imports\RunPayrolls\Sheets\RunPayrollEmployees;
use Modules\Payroll\Imports\PayCalendars\Sheets\PayCalendars;
use Modules\Payroll\Imports\PayCalendars\Sheets\PayCalendarEmployees;

class RunPayrolls extends ImportMultipleSheets
{
    public function sheets(): array
    {
        return [
            'departments'                       => new Departments(),
            'employees'                         => new Employees(),
            'employee_benefits'                 => new EmployeeBenefits(),
            'employee_deductions'               => new EmployeeDeductions(),
            'pay_calendars'                     => new PayCalendars(),
            'pay_calendar_employees'            => new PayCalendarEmployees(),
            'run_payrolls'                      => new Base(),
            'run_payroll_employees'             => new RunPayrollEmployees(),
            'run_payroll_employee_benefits'     => new RunPayrollEmployeeBenefits(),
            'run_payroll_employee_deductions'   => new RunPayrollEmployeeDeductions(),
        ];
    }
}
