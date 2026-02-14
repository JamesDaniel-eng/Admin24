<?php

namespace Modules\Payroll\Http\Requests\RunPayroll;

use App\Abstracts\Http\FormRequest;

class Start extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = null;

        // Check if store or update
        // Check if store or update. Todo: check if this is the best way to do this
        //if (in_array($this->getMethod(), ['PATCH', 'PUT'])) {
        if ($this->route()->getName() == 'payroll.run-payrolls.employees.update') {
            $id = $this->runPayroll->getAttribute('id');
        }

        // Get company id
        $company_id = $this->request->get('company_id');

        return [
            'name'         => 'required|string|unique:payroll_run_payrolls,NULL,' . $id . ',id,company_id,' . $company_id . ',deleted_at,NULL',
            'from_date'    => 'required|date|before_or_equal:to_date',
            'to_date'      => 'required|date|after_or_equal:from_date',
            'payment_date' => 'required|date',
        ];
    }
}
