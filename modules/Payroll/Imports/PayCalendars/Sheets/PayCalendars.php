<?php

namespace Modules\Payroll\Imports\PayCalendars\Sheets;

use App\Abstracts\Import;
use Modules\Payroll\Http\Requests\PayCalendar as Request;
use Modules\Payroll\Models\PayCalendar\PayCalendar as Model;

class PayCalendars extends Import
{
    public $model = Model::class;

    public $columns = [
        'name',
        'type',
        'pay_day_mode',
    ];

    public function model(array $row)
    {
        if (self::hasRow($row)) {
            return;
        }
        
        return new Model($row);
    }

    public function rules(): array
    {
        $rules = (new Request())->rules();

        unset($rules['employees']);

        return $rules;
    }
}
