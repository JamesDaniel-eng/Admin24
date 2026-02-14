<?php

namespace Modules\Payroll\Exports\PayCalendars\Sheets;

use App\Abstracts\Export;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Payroll\Models\Employee\Benefit as Model;

class EmployeeBenefits extends Export
{
    public $employee_ids = [];

    public function collection()
    {
        PayCalendar::whereIn('id', $this->ids)->each(function ($pay_calendar) {
            $this->employee_ids = array_merge($this->employee_ids, $pay_calendar->employees->pluck('employee_id')->toArray());
        });

        return Model::collectForExport(array_unique($this->employee_ids), null, 'employee_id');
    }

    public function map($model): array
    {
        $model->employee_name = $model->employee->name;
        $model->type = $model->pay_item->pay_item;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'employee_name',
            'type',
            'amount',
            'currency_code',
            'recurring',
            'description',
            'from_date',
            'to_date',
        ];
    }
}
