<?php

namespace Modules\Admin24\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class TransferOrderRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_name' => 'required|string',
            'sku' => 'string',
            'source_warehouse' => 'required|unique|string',
            'destination_warehouse' => 'required|unique|string',
            'transfer_quantity' => 'required|integer',
        ];
    }
}
