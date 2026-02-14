<?php

namespace Modules\Payroll\Reports;

use App\Utilities\Date;
use App\Abstracts\Report;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeBenefit;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeDeduction;

class BenefitDeductionSummary extends Report
{
    public $default_name = 'payroll::general.benefit_deduction_summary';

    public $category = 'payroll::general.name';

    public $icon = 'groups';

    public $type = 'summary';

    public $chart = [
        'bar' => [
            'colors' => [
                '#fb7185',
            ],
        ],
        'donut' => [
            //
        ],
    ];

    public function setTables()
    {
        $this->tables = [
            'benefit'   => trans_choice('payroll::general.benefits', 2),
            'deduction' => trans_choice('payroll::general.deductions', 2)
        ];
    }

    public function setData()
    {
        $this->getData(RunPayrollEmployeeBenefit::with('employee'), 'benefit');
        $this->getData(RunPayrollEmployeeDeduction::with('employee'), 'deduction');
    }

    public function getData($query, $table)
    {
        $rows = $this->applyFilters($query, [
            'date_field' => 'created_at',
            'employee' => 'employee_id',
        ])->get();

        foreach ($rows as $row) {
            $date = $this->getFormattedDate(Date::parse($row->created_at));

            if (empty($date)) {
                continue;
            }

            $this->row_values[$table][$row->pay_item->id][$date] += $row->amount;
            $this->footer_totals[$table][$date] += $row->amount;
        }
    }
}
