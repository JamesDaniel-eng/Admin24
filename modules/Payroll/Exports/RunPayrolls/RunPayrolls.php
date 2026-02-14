<?php

namespace Modules\Payroll\Exports\RunPayrolls;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Payroll\Exports\RunPayrolls\Sheets\RunPayrollEmployeeBenefits;
use Modules\Payroll\Exports\RunPayrolls\Sheets\RunPayrollEmployeeDeductions;
use Modules\Payroll\Exports\RunPayrolls\Sheets\RunPayrollEmployees;
use Modules\Payroll\Exports\RunPayrolls\Sheets\Employees;
use Modules\Payroll\Exports\RunPayrolls\Sheets\Departments;
use Modules\Payroll\Exports\RunPayrolls\Sheets\EmployeeBenefits;
use Modules\Payroll\Exports\RunPayrolls\Sheets\EmployeeDeductions;
use Modules\Payroll\Exports\RunPayrolls\Sheets\PayCalendars;
use Modules\Payroll\Exports\RunPayrolls\Sheets\PayCalendarEmployees;
use Modules\Payroll\Exports\RunPayrolls\Sheets\RunPayrolls as Base;

class RunPayrolls implements WithMultipleSheets
{
    use Exportable;

    public $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function sheets(): array
    {
        return [
            new Base($this->ids),
            new Employees($this->ids),
            new Departments($this->ids),
            new EmployeeBenefits($this->ids),
            new EmployeeDeductions($this->ids),
            new PayCalendars($this->ids),
            new PayCalendarEmployees($this->ids),
            new RunPayrollEmployees($this->ids),
            new RunPayrollEmployeeBenefits($this->ids),
            new RunPayrollEmployeeDeductions($this->ids),
        ];
    }
}
