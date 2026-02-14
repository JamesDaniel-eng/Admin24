<?php

namespace Modules\Payroll\Exports\RunPayrolls\Sheets;

use App\Abstracts\Export;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Modules\Payroll\Models\PayCalendar\Employee as Model;

class PayCalendarEmployees extends Export
{
    public $employee_ids = [];

    public function collection()
    {
        RunPayroll::whereIn('id', $this->ids)->each(function ($run_payroll) {
            $this->employee_ids = array_merge($this->employee_ids, $run_payroll->employees->pluck('employee_id')->toArray());
        });

        return Model::with('employee.contact:name', 'pay_calendar')
            ->collectForExport(array_unique($this->employee_ids), 'pay_calendar.name', 'employee_id');
    }

    public function map($model): array
    {
        $model->pay_calendar_name = $model->pay_calendar->name;
        $model->employee_name = $model->employee->contact->name;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'pay_calendar_name',
            'employee_name',
        ];
    }
}
