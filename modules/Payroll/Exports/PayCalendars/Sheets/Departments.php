<?php

namespace Modules\Payroll\Exports\PayCalendars\Sheets;

use App\Abstracts\Export;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Employees\Models\Department as Model;

class Departments extends Export
{
    public $department_ids = [];

    public function collection()
    {
        PayCalendar::whereIn('id', $this->ids)->each(function ($pay_calendar) {
            $pay_calendar->employees->each(function ($py_employee) {
                if ($department_id = $py_employee->employee?->department_id) {
                    $this->department_ids[] = $department_id;
                }
            });
        });
        
        return Model::collectForExport(array_unique($this->department_ids));
    }

    public function fields(): array
    {
        return [
            'name',
            'manager',
            'parent_id',
            'description',
            'enabled',
        ];
    }
}
