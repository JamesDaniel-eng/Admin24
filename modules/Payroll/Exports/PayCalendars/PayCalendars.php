<?php

namespace Modules\Payroll\Exports\PayCalendars;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Payroll\Exports\PayCalendars\Sheets\PayCalendarEmployees;
use Modules\Payroll\Exports\PayCalendars\Sheets\PayCalendars as Base;
use Modules\Payroll\Exports\PayCalendars\Sheets\Employees;
use Modules\Payroll\Exports\PayCalendars\Sheets\Departments;
use Modules\Payroll\Exports\PayCalendars\Sheets\EmployeeBenefits;
use Modules\Payroll\Exports\PayCalendars\Sheets\EmployeeDeductions;


class PayCalendars implements WithMultipleSheets
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
            new PayCalendarEmployees($this->ids),
        ];
    }
}
