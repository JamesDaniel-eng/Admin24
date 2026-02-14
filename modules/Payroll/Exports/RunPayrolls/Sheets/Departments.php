<?php

namespace Modules\Payroll\Exports\RunPayrolls\Sheets;

use App\Abstracts\Export;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Modules\Employees\Models\Department as Model;

class Departments extends Export
{
    public $department_ids = [];

    public function collection()
    {
        RunPayroll::whereIn('id', $this->ids)->each(function ($run_payroll) {
            $run_payroll->employees->each(function ($rp_employee) {
                if ($department_id = $rp_employee->employee?->department_id) {
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
