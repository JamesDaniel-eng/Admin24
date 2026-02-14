<?php

namespace Modules\Payroll\Listeners;

use App\Traits\Currencies;
use App\Models\Common\Contact;
use App\Events\Report\RowsShowing;
use App\Events\Report\GroupShowing;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupApplying;
use App\Events\Report\FilterApplying;
use App\Abstracts\Listeners\Report as Listener;
use Modules\Employees\Models\Employee;
use Modules\Payroll\Models\Setting\PayItem;
use Illuminate\Support\Facades\Route;

class AddEmployeesToReports extends Listener
{
    use Currencies;

    protected $classes = [
        'App\Reports\ExpenseSummary',
        'Modules\Payroll\Reports\EmployeeSummary',
        'Modules\Payroll\Reports\EmployeeDetailed',
        'Modules\Payroll\Reports\BenefitDeductionSummary',
    ];

    /**
     * Handle filter showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterShowing(FilterShowing $event)
    {
        $classes = [
            'Modules\Payroll\Reports\EmployeeSummary',
            'Modules\Payroll\Reports\EmployeeDetailed',
            'Modules\Payroll\Reports\BenefitDeductionSummary',
        ];

        if (empty($event->class) || !in_array(get_class($event->class), $classes)) {
            return;
        }

        $employee_list = [];

        Contact::type('employee')->orderBy('name')->get()->each(function ($contact) use (&$employee_list) {
            $employee = $contact->employee()->first();

            if ($employee && isset($employee->id)) {
                $employee_list[$employee->id] = $contact->name;
            }
        });

        $event->class->filters['employee'] = $employee_list;
        $event->class->filters['routes']['employee'] = Route::has('employees.employees.index') ? 'employees.employees.index' : null;
        $event->class->filters['names']['employee'] = trans_choice('employees::general.employees', 1);
    }

    /**
     * Handle filter applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterApplying(FilterApplying $event)
    {
        $classes = [
            'Modules\Payroll\Reports\EmployeeSummary',
            'Modules\Payroll\Reports\EmployeeDetailed',
            'Modules\Payroll\Reports\BenefitDeductionSummary',
        ];

        if (empty($event->class) || !in_array(get_class($event->class), $classes)) {
            return;
        }

        $employee_id = $this->getSearchStringValue('employee_id', '');

        $event->model->when($employee_id, function ($query, $employee) use ($event) {
            return $query->where('employee_id', $employee);
        });
    }

    /**
     * Handle group showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupShowing(GroupShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->class->groups['employee'] = trans_choice('payroll::general.employees', 1);
    }

    /**
     * Handle group applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupApplying(GroupApplying $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $employee_id = Employee::where('contact_id', $event->model->contact_id)->pluck('id')->first();

        if (empty($employee_id)) {
            return;
        }

        $event->model->employee_id = $employee_id;
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'employee')) {
            return;
        }

        switch (get_class($event->class)) {
            case 'Modules\Payroll\Reports\BenefitDeductionSummary':
                $rows = PayItem::pluck('pay_item', 'id')->toArray();
            break;
            default:
                $employee_list = [];

                Contact::type('employee')->orderBy('name')->get()->each(function ($contact) use (&$employee_list) {
                    $employee = $contact->employee()->first();
        
                    if ($employee && isset($employee->id)) {
                        $employee_list[$employee->id] = $contact->name;
                    }
                });
        
                if ($employees = request('employees')) {
                    $rows = collect($employee_list)->filter(function ($value, $key) use ($employees) {
                        return in_array($key, $employees);
                    });
                } else {
                    $rows = $employee_list;
                }
            break;
        }

        $this->setRowNamesAndValues($event, $rows);
    }
}
