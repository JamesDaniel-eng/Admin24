<?php

namespace Modules\Employees\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Department extends JsonResource
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
            'manager_id'        => $this->manager_id,
            'parent_id'         => $this->parent_id,
            'employee_ids'      => $this->employees->pluck('id')->toArray(),
            'name'              => $this->name,
            'description'       => $this->description,
            'enabled'           => $this->enabled,
            'created_at'        => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at'        => $this->updated_at ? $this->updated_at->toIso8601String() : '',
        ];
    }
}
