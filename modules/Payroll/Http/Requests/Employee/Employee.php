<?php

namespace Modules\Payroll\Http\Requests\Employee;

use App\Abstracts\Http\FormRequest as Request;
use Illuminate\Validation\Rule;

class Employee extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $email_rule = '';

        if (! empty($this->request->get('email'))) {
            $id = null;
            $company_id = $this->request->get('company_id');
            $type = $this->request->get('type', 'employee');

            // Check if store or update
            if ($this->isMethod('PATCH') && $this->employee->contact) {
                $id = $this->employee->contact->id;
            }

            $email_rule = [
                'email',
                Rule::unique('contacts')
                    ->ignore($id)
                    ->where(function ($query) use ($company_id, $type) {
                        return $query->where([
                            ['company_id', '=', $company_id],
                            ['type', '=', $type],
                            ['deleted_at', '=', null],
                        ]);
                    }),
            ];
        }

        return [
            // Contact
            'type' => 'required|string',
            'name' => 'required|string',
            'email' => $email_rule,
            'phone' => 'nullable|string',
            'enabled' => 'integer|boolean',

            'birth_day' => 'required|date_format:Y-m-d',
            'gender' => 'required|string',
            'department_id' => 'required|integer',
            'amount' => 'required|numeric',
            'hired_at' => 'required|date_format:Y-m-d'
        ];
    }
}
