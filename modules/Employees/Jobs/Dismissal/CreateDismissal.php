<?php

namespace Modules\Employees\Jobs\Dismissal;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\Employees\Models\Dismissal;
use Modules\Employees\Jobs\Employee\UpdateEmployee;
use Modules\Employees\Jobs\Employee\UpdateEmployeeContact;

class CreateDismissal extends Job implements HasOwner, HasSource, ShouldCreate
{
    public function handle(): Dismissal
    {
        \DB::transaction(function () {
            $this->model = Dismissal::updateOrCreate([
                'company_id' => $this->request->company_id,
                'employee_id' => $this->request->employee_id,
            ], $this->request->all());

            $employee = $this->model->employee;

            if ($employee) {
                $this->dispatch(new UpdateEmployee($employee, request()->merge(['dismissed' => 1])));            
            }

            if ($employee->contact) {
                $this->dispatch(new UpdateEmployeeContact($employee->contact, request()->merge(['enabled' => 0])));            
            }
        });

        return $this->model;
    }
}
