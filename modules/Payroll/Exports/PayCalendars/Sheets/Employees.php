<?php

namespace Modules\Payroll\Exports\PayCalendars\Sheets;

use App\Abstracts\Export;
use Modules\Employees\Models\Employee as Model;
use Modules\Payroll\Models\PayCalendar\PayCalendar;

class Employees extends Export
{
    public $employee_ids = [];

    public function collection()
    {
        PayCalendar::whereIn('id', $this->ids)->each(function ($pay_calendar) {
            $this->employee_ids = array_merge($this->employee_ids, $pay_calendar->employees->pluck('employee_id')->toArray());
        });

        return Model::with(['contact', 'department'])->collectForExport(array_unique($this->employee_ids));
    }

    public function map($model): array
    {
        $model->name = $model->contact->name;
        $model->email = $model->contact->email;
        $model->phone = $model->contact->phone;
        $model->address = $model->contact->address;
        $model->country = $model->contact->country;
        $model->state = $model->contact->state;
        $model->zip_code = $model->contact->zip_code;
        $model->city = $model->contact->city;
        $model->website = $model->contact->website;
        $model->tax_number = $model->contact->tax_number;
        $model->currency_code = $model->contact->currency_code;
        $model->user_id = $model->contact->user_id;
        $model->enabled = $model->contact->enabled ? 1 : 0;
        $model->department = $model->department->name;
        $model->salary = $model->amount;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'name',
            'email',
            'phone',
            'address',
            'country',
            'state',
            'zip_code',
            'city',
            'website',
            'currency_code',
            'tax_number',
            'enabled',
            'birth_day',
            'gender',
            'department',
            'salary',
            'hired_at',
            'bank_account_number',
            'user_id'
        ];
    }
}
