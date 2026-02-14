<?php

namespace Modules\Payroll\Imports\RunPayrolls\Sheets;

use App\Abstracts\Import;
use App\Models\Common\Contact;
use Modules\Employees\Models\Employee;
use Modules\Payroll\Models\Setting\PayItem;
use Modules\Payroll\Models\Employee\Benefit as Model;
use Modules\Payroll\Http\Requests\Employee\Benefit as Request;
use Modules\Payroll\Jobs\Setting\CreatePayItem;

class EmployeeBenefits extends Import
{
    public $request_class = Request::class;

    public $model = Model::class;

    public $columns = [
        'employee_id',
        'type',
        'amount',
        'currency_code',
        'description'
    ];

    public function model(array $row)
    {
        if (empty($row['employee_id']) || self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $row['employee_id'] = $this->getEmployeeId($row);
        $row['type'] = $this->getPayItemType($row);

        return parent::map($row);
    }

    public function getEmployeeId($row)
    {
        $contact = Contact::where('name', $row['employee_name'])->first();

        if (! $contact) {
            return null;
        }

        return Employee::where('contact_id', $contact->id)->first()?->id;
    }

    public function getPayItemType($row)
    {
        $type = PayItem::where('pay_item', $row['type'])->first();

        if (! $type) {
            $type = $this->dispatch(new CreatePayItem([
                'company_id'    => company_id(),
                'pay_type'      => 'benefit',
                'pay_item'      => $row['type'],
                'amount_type'   => 'addition',
            ]));
        }

        return (string) $type?->id;
    }
}
