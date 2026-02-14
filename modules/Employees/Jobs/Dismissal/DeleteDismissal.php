<?php

namespace Modules\Employees\Jobs\Dismissal;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Modules\Employees\Jobs\Employee\UpdateEmployee;
use Modules\Employees\Jobs\Employee\UpdateEmployeeContact;

class DeleteDismissal extends Job implements ShouldDelete
{
    public function handle(): bool
    {
        \DB::transaction(function () {
            $employee = $this->model->employee;

            if ($employee) {
                $this->dispatch(new UpdateEmployee($employee, request()->merge(['dismissed' => 0])));            
            }

            if ($employee->contact) {
                $this->dispatch(new UpdateEmployeeContact($employee->contact, request()->merge(['enabled' => 1])));            
            }
            
            $this->model->delete();
        });

        return true;
    }
}
