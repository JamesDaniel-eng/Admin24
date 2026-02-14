<?php

namespace Modules\Employees\Http\Resources;

use App\Http\Resources\Common\Contact;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Employees\Http\Resources\Department;

class Employee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'company_id'            => $this->company_id,
            'birth_day'             => $this->birth_day,
            'gender'                => $this->gender,
            'salary'                => $this->amount,
            'salary_type'           => $this->salary_type,
            'bank_account_number'   => $this->bank_account_number,
            'hired_at'              => $this->hired_at,
            'dismissed'             => $this->dismissed ? true : false,
            'created_at'            => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at'            => $this->updated_at ? $this->updated_at->toIso8601String() : '',
            'contact'               => new Contact($this->contact),
            'department'            => new Department($this->department),
        ];
    }
}
