<?php

namespace Modules\Payroll\Widgets;

use App\Abstracts\Widget;
use Modules\Payroll\Models\RunPayroll\RunPayroll;

class LatestPayRunRecords extends Widget
{
    public $default_name = 'payroll::dashboard.description';

    public $default_settings = [
        'width' => 'w-full px-12 my-8',
    ];

    public function show()
    {
        $payrolls = RunPayroll::take(5)->get();

        return $this->view('payroll::widgets.latest_pay_run_records', [
            'payrolls' => $payrolls,
        ]);
    }
}
