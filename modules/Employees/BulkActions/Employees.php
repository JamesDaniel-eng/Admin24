<?php

namespace Modules\Employees\BulkActions;

use App\Abstracts\BulkAction;
use App\Jobs\Common\UpdateContact;
use Modules\Employees\Models\Employee;
use Modules\Employees\Jobs\Employee\DeleteEmployee;
use Modules\Employees\Jobs\Dismissal\DeleteDismissal;
use Modules\Employees\Jobs\Employee\UpdateEmployeeContact;

class Employees extends BulkAction
{
    public $model = Employee::class;

    public $text = 'employees::general.employees';

    public $path = [
        'group' => 'employees',
        'type' => 'employees',
    ];

    public $actions = [
        'enable'  => [
            'name'          => 'general.enable',
            'message'       => 'bulk_actions.message.enable',
            'path'          =>  ['group' => 'employees', 'type' => 'employees'],
            'type'          => '*',
            'permission'    => 'update-employees-employees',
        ],
        'disable' => [
            'name'          => 'general.disable',
            'message'       => 'bulk_actions.message.disable',
            'path'          =>  ['group' => 'employees', 'type' => 'employees'],
            'type'          => '*',
            'permission'    => 'update-employees-employees',
        ],
        'delete'  => [
            'name'          => 'general.delete',
            'message'       => 'bulk_actions.message.delete',
            'path'          =>  ['group' => 'employees', 'type' => 'employees'],
            'type'          => '*',
            'permission'    => 'delete-employees-employees',
        ],
        'dismissal' => [
            'icon'          => 'person_remove',
            'name'          => 'employees::employees.dismissal',
            'message'       => '',
            'permission'    => 'create-employees-dismissals',
            'type'          => 'modal',
            'handle'        => 'store',
        ],
        'revert' => [
            'icon'          => 'person_add',
            'name'          => 'employees::general.revert_dismissal',
            'message'       => '',
            'permission'    => 'delete-employees-dismissals',
            'type'          => '*',
            'handle'        => 'revert',
        ],
    ];

    public function dismissal($request)
    {
        $selected = $this->getSelectedInput($request);

        foreach (json_decode(setting('employees.dismissal_types')) as $key => $value) {
            $dismissal_types[$value] = $value;
        }

        $html = view('employees::modals.dismissals.create', compact('selected', 'dismissal_types'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => null,
            'html'    => $html,
            'data'    => [
                'title'   => trans_choice('employees::general.dismissals', 1),
                'buttons' => [
                    'cancel'    => [
                        'text'  => trans('general.cancel'),
                        'class' => 'btn-outline-secondary'
                    ],
                    'confirm'   => [
                        'text'  => trans('general.save'),
                        'class' => 'btn-success'
                    ]
                ],
            ]
        ]);
    }

    public function revert($request)
    {
        $items = $this->getSelectedRecords($request);

        foreach ($items as $item) {
            try {
                $this->dispatch(new DeleteDismissal($item->dismissal));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function destroy($request)
    {
        $items = $this->getSelectedRecords($request);

        foreach ($items as $item) {
            try {
                $this->dispatch(new DeleteEmployee($item));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function disable($request)
    {
        $employees = $this->getSelectedRecords($request);

        foreach ($employees as $employee) {
            try {
                if ($contact = $employee->contact) {
                    $this->dispatch(new UpdateEmployeeContact($contact, ['enabled' => 0]));
                }
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function enable($request)
    {
        $employees = $this->getSelectedRecords($request);

        foreach ($employees as $employee) {
            try {
                if ($contact = $employee->contact) {
                    $this->dispatch(new UpdateContact($contact, ['enabled' => 1]));
                }
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
