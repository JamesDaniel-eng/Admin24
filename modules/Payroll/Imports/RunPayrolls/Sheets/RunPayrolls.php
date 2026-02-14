<?php

namespace Modules\Payroll\Imports\RunPayrolls\Sheets;

use App\Abstracts\Import;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Payroll\Models\RunPayroll\RunPayroll as Model;

class RunPayrolls extends Import
{
    public $return = false;

    public $model = Model::class;

    public $columns = [
        'name',
        'pay_calendar_id',
    ];

    public function model(array $row)
    {
        if (! $row || self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $pay_calendar_id = PayCalendar::where('name', $row['pay_calendar_name'])->pluck('id')->first();

        if (! $pay_calendar_id) {
            $this->return = true;
            
            return [];
        }

        $row['name'] = $row['run_payroll_number'];
        $row['pay_calendar_id'] = $pay_calendar_id;
        $row['category_id'] = $this->getCategoryId($row, 'other');
        $row['account_id'] = $this->getAccountId($row);
        $row['amount'] = str_replace("'", '', $row['amount']);

        return parent::map($row);
    }

    public function rules(): array
    {
        if ($this->return) {
            return [];
        }

        $rules = [
            'name'              => 'required|string',
            'from_date'         => 'required|date|before_or_equal:to_date',
            'to_date'           => 'required|date|after_or_equal:from_date',
            'payment_date'      => 'required|date',
            'pay_calendar_id'   => 'required',
            'category_id'       => 'required',
            'account_id'        => 'required',
            'payment_method'    => 'required|string',
            'currency_code'     => 'required|string',
            'currency_rate'     => 'required|numeric',
            'amount'            => 'required',
            'status'            => 'required|string|in:not_approved,approved',
        ];

        return $this->replaceForBatchRules($rules);
    }
}
