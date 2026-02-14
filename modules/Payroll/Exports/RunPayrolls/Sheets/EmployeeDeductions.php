<?php

namespace Modules\Payroll\Exports\RunPayrolls\Sheets;

use App\Abstracts\Export;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Modules\Payroll\Models\Employee\Deduction as Model;

class EmployeeDeductions extends Export
{
    public $employee_ids = [];

    public function collection()
    {
        RunPayroll::whereIn('id', $this->ids)->each(function ($run_payroll) {
            $this->employee_ids = array_merge($this->employee_ids, $run_payroll->employees->pluck('employee_id')->toArray());
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
