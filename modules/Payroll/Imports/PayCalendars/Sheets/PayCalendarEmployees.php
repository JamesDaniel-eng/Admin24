<?php

namespace Modules\Payroll\Imports\PayCalendars\Sheets;

use App\Utilities\Date;
use App\Abstracts\Import;
use Modules\Employees\Models\Employee;
use Modules\Employees\Models\Department;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Payroll\Models\PayCalendar\Employee as Model;

class PayCalendarEmployees extends Import
{
    public $model = Model::class;

    public $columns = [
        'pay_calendar_id',
        'employee_id'
    ];

    public function model(array $row)
    {
        if (self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $pay_calendar_id = PayCalendar::where('name', $row['pay_calendar_name'])->pluck('id')->first();

        if (!$pay_calendar_id) {
            return [];
        }

        $employee_id = $this->getEmployeeId($row);

        if (!$employee_id) {
            return [];
        }

        $row['pay_calendar_id'] = $pay_calendar_id;
        $row['employee_id'] = $employee_id;

        return parent::map($row);
    }

    public function getEmployeeId($row)
    {   
        $row['contact_name'] = $row['employee_name'];

        $contact_id = $this->getContactId($row, 'employee');

        $employee_id = Employee::where('contact_id', $contact_id)->pluck('id')->first();

        if (! $employee_id) {
            $employee_id = $this->getEmployeeIdFromName($contact_id);
        }

        return $employee_id;
    }

    public function getEmployeeIdFromName($contact_id)
    {
        $data = [
            'company_id'    => company_id(),
            'contact_id'    => $contact_id,
            'birth_day'     => Date::now()->addYear(-18)->format('Y-m-d'),
            'gender'        => 'male',
            'department_id' => $this->getDepartmentId(),
            'amount'        => 0,
            'salary_type'   => 'monthly',
            'hired_at'      => Date::now()->format('Y-m-d'),
        ];

        $employee = Employee::create($data);

        return $employee->id;
    }

    public function getDepartmentId()
    {
        $department = Department::first();

        if (! $department) {
            $department = Department::create([
                'company_id' => company_id(),
                'name'       => 'Default',
            ]);
        }

        return $department->id;
    }
  
    public function rules(): array
    {
        return [
            'pay_calendar_name' => 'required|string',
            'employee_name'     => 'required|string',
        ];
    }
}
