<?php

namespace Modules\Payroll\Http\Requests\RunPayroll;

use App\Abstracts\Http\FormRequest as Request;

class EmployeeDeduction extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required|integer',
            'type' => 'required|string',
            'amount' => 'required|amount',
        ];
    }
}
