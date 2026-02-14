<?php

namespace Modules\Employees\Imports;

use App\Abstracts\Import;
use App\Models\Common\Contact;
use App\Jobs\Common\CreateContact;
use Modules\Employees\Models\Employee;
use Modules\Employees\Models\Dismissal;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Employees\Models\Department;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Modules\Employees\Models\Employee as Model;
use Modules\Employees\Jobs\Dismissal\CreateDismissal;
use App\Http\Requests\Common\Contact as ContactRequest;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Modules\Employees\Jobs\Department\CreateDepartment;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Modules\Employees\Http\Requests\Employee as EmployeeRequest;

class Employees extends Import implements HasReferencesToOtherSheets, WithEvents
{
    use Importable, RegistersEventListeners;

    public $model = Model::class;

    public $columns = [
        'contact_id',
    ];

    public function batchSize(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        if (self::hasRow($row)) {
            return;
        }
        
        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        $row['type'] = 'employee';
        $row['amount'] = $row['salary'];
        $row['department_id'] = $this->getDepartmentId($row);
        $row['contact_id'] = $this->getEmployeeContactId($row);

        return $row;
    }

    public function getDepartmentId($row)
    {
        $department = Department::where('name', $row['department'])->first();

        if (! $department) {
            $department = $this->dispatch(new CreateDepartment([
                'company_id'    => company_id(),
                'name'          => $row['department'],
                'enabled'       => true,
            ]));
        }

        return (int) $department?->id;
    }

    public function getEmployeeContactId($row)
    {
        if (! empty($row['email'])) {
            $id = $this->getEmployeeContactIdFromEmail($row);
        }

        if (empty($id) && !empty($row['name'])) {
            $id = $this->getEmployeeContactIdFromName($row);
        }

        return is_null($id) ? $id : (int) $id;
    }

    public function getEmployeeContactIdFromEmail($row)
    {
        $contact_id = Contact::type($row['type'])->where('email', $row['email'])->pluck('id')->first();

        if (!empty($contact_id)) {
            return $contact_id;
        }

        $row['enabled'] = $row['enabled'] ?? 1;
        $row['created_from'] = !empty($row['created_from']) ? $row['created_from'] : $this->getSourcePrefix() . 'import';
        $row['created_by'] = !empty($row['created_by']) ? $row['created_by'] : user()?->id;

        Validator::validate($row, (new ContactRequest)->rules());

        $contact = $this->dispatch(new CreateContact($row));

        return $contact->id;
    }

    public function getEmployeeContactIdFromName($row)
    {
        $contact_id = Contact::type($row['type'])->where('name', $row['name'])->pluck('id')->first();

        if (!empty($contact_id)) {
            return $contact_id;
        }

        $row['enabled'] = $row['enabled'] ?? 1;
        $row['created_from'] = !empty($row['created_from']) ? $row['created_from'] : $this->getSourcePrefix() . 'import';
        $row['created_by'] = !empty($row['created_by']) ? $row['created_by'] : user()?->id;

        Validator::validate($row, (new ContactRequest)->rules());

        $contact = $this->dispatch(new CreateContact($row));

        return $contact->id;
    }

    public function rules(): array
    {
        $employee_rules = array_filter((new EmployeeRequest())->rules(), function ($value, $key) {
            return in_array($key, [
                'birth_day',
                'gender',
                'department_id',
                'amount',
                'hired_at',
                'currency_code',
            ]);
        }, ARRAY_FILTER_USE_BOTH);

        $rules = array_merge(
            (new ContactRequest([], ['email' => 'just a string to trigger adding the email rule']))->rules(),
            $employee_rules
        );

        unset($rules['email']);

        return $this->replaceForBatchRules($rules);
    }

    public function afterSheet(AfterSheet $event)
    {
        $rows = $event->sheet->getDelegate()->toArray();

        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $dismissed = $row[array_keys($rows[0], 'dismissed')[0]];

            if ($dismissed) {
                $contact = Contact::type('employee');

                $email = $row[array_keys($rows[0], 'email')[0]];

                if ($email) {
                    $contact = $contact->where('email', $email);
                }

                $name = $row[array_keys($rows[0], 'name')[0]];

                if (! $email && $name) {
                    $contact = $contact->where('name', $name);
                }

                $contact = $contact->first();

                if (! $contact) {
                    continue;
                }

                $employee = Employee::where('contact_id', $contact->id)->first();

                if (! $employee) {
                    continue;
                }

                $this->dispatch(new CreateDismissal([
                    'company_id'        => company_id(),
                    'employee_id'       => $employee->id,
                    'type'              => $row[array_keys($rows[0], 'dismissal_type')[0]] ?? 'Fired',
                    'dismissal_date'    => $row[array_keys($rows[0], 'dismissal_date')[0]] ?? now()->format('Y-m-d'),
                    'reason'            => $row[array_keys($rows[0], 'dismissal_reason')[0]] ?? 'No reason provided',
                ]));

                continue;
            }
        }
    }
}
