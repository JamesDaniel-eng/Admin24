<?php

namespace Modules\Employees\Exports;

use App\Abstracts\Export;
use Modules\Employees\Models\Employee as Model;

class Employees extends Export
{
    public function collection()
    {
        return Model::with(['contact', 'department'])->collectForExport($this->ids, 'contact.name');
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
        $model->enabled = $model->contact->enabled ? 1 : 0;
        $model->department = $model->department->name;
        $model->salary = $model->amount;

        if ($model->dismissed) {
            $model->dismissal_type = $model->dismissal->type;
            $model->dismissal_date = $model->dismissal->dismissal_date;
            $model->dismissal_reason = $model->dismissal->reason;
        }

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
            'dismissed',
            'dismissal_type',
            'dismissal_date',
            'dismissal_reason',
        ];
    }
}
