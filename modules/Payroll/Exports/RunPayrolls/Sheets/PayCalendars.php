<?php

namespace Modules\Payroll\Exports\RunPayrolls\Sheets;

use App\Abstracts\Export;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Modules\Payroll\Models\PayCalendar\PayCalendar as Model;

class PayCalendars extends Export
{
    public $pay_calendar_ids = [];

    public function collection()
    {
        RunPayroll::whereIn('id', $this->ids)->each(function ($run_payroll) {
            $this->pay_calendar_ids = array_merge($this->pay_calendar_ids, $run_payroll->employees->pluck('pay_calendar_id')->toArray());
        });

        return Model::collectForExport(array_unique($this->pay_calendar_ids));
    }

    public function fields(): array
    {
        return [
            'name',
            'type',
            'pay_day_mode',
            'pay_day',
        ];
    }
}
