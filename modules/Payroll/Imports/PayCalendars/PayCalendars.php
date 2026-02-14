<?php

namespace Modules\Payroll\Imports\PayCalendars;

use App\Abstracts\ImportMultipleSheets;
use Modules\Employees\Imports\Employees;
use Modules\Employees\Imports\Departments;
use Modules\Payroll\Imports\PayCalendars\Sheets\PayCalendarEmployees;
use Modules\Payroll\Imports\PayCalendars\Sheets\PayCalendars as Base;
use Modules\Payroll\Imports\RunPayrolls\Sheets\EmployeeBenefits;
use Modules\Payroll\Imports\RunPayrolls\Sheets\EmployeeDeductions;

class PayCalendars extends ImportMultipleSheets
{
    public function sheets(): array
    {
        return [
            'departments'            => new Departments(),
            'employees'              => new Employees(),
            'employee_benefits'      => new EmployeeBenefits(),
            'employee_deductions'    => new EmployeeDeductions(),
            'pay_calendars'          => new Base(),
            'pay_calendar_employees' => new PayCalendarEmployees(),
        ];
    }
}
