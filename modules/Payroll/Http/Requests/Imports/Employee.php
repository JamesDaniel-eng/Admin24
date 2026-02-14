<?php

namespace Modules\Payroll\Http\Requests\Imports;

use App\Abstracts\Http\FormRequest as Request;

class Employee extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birth_day' => 'required|date_format:Y-m-d',
            'gender' => 'required|string',
            'department_id' => 'required|integer',
            'amount' => 'required',
            'hired_at' => 'required|date_format:Y-m-d'
        ];
    }
}
