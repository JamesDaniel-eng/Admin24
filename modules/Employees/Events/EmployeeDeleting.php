<?php

namespace Modules\Employees\Events;

use App\Abstracts\Event;
use Modules\Employees\Models\Employee;

class EmployeeDeleting extends Event
{
    public $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }
}
