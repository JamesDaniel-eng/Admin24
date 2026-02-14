<?php

namespace Modules\Employees\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Dismissal extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'dismissal_date'    => 'required|date',
            'type'              => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
