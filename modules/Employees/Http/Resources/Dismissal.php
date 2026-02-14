<?php

namespace Modules\Employees\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Dismissal extends JsonResource
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
            'id'                => $this->id,
            'company_id'        => $this->company_id,
            'employee_id'       => $this->employee_id,
            'dismissal_type'    => $this->type,
            'dismissal_date'    => $this->dismissal_date,
            'reason'            => $this->reason,
            'created_at'        => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at'        => $this->updated_at ? $this->updated_at->toIso8601String() : '',
        ];
    }
}
