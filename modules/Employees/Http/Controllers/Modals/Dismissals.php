<?php

namespace Modules\Employees\Http\Controllers\Modals;

use Illuminate\Http\JsonResponse;
use App\Abstracts\Http\Controller;
use Modules\Employees\Models\Employee;
use Modules\Employees\Models\Dismissal;
use Illuminate\Http\Request as HttpRequest;
use Modules\Employees\Jobs\Dismissal\CreateDismissal;
use Modules\Employees\Jobs\Dismissal\DeleteDismissal;
use Modules\Employees\Http\Requests\Dismissal as Request;

class Dismissals extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-employees-dismissals')->only(['create', 'store']);
        $this->middleware('permission:delete-employees-dismissals')->only('destroy');   
    }

    public function create(HttpRequest $request): JsonResponse
    {
        $employee_id = $request->employee_id;

        foreach (json_decode(setting('employees.dismissal_types')) as $key => $value) {
            $dismissal_types[$value] = $value;
        }

        $html = view('employees::modals.dismissals.create', compact('employee_id', 'dismissal_types'))->render();

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

    public function store(Request $request)
    {
        if (! empty($request->selected_employee_ids)) {
            $response = $this->bulkActionDismissals($request);

            return response()->json([
                'success' => true,
                'redirect' => true,
                'error' => false,
                'data' => [],
            ]);
        }

        $response = $this->ajaxDispatch(new CreateDismissal($request));

        if ($response['success']) {
            $response['redirect'] = route('employees.employees.show', $response['data']->employee_id);

            $message = trans('employees::employees.messages.dismissed');

            flash($message)->success();
        } else {
            $response['redirect'] = null;
        }

        return response()->json($response);

    }

    public function revert(Dismissal $dismissal)
    {
        $response = $this->ajaxDispatch(new DeleteDismissal($dismissal));

        if ($response['success']) {
            $message = trans('employees::employees.messages.reverted');

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return redirect()->route('employees.employees.show', $dismissal->employee_id);
    }

    public function bulkActionDismissals($request)
    {
        $employee_ids = explode(',', $request->selected_employee_ids);

        foreach ($employee_ids as $employee_id) {
            $request->merge(['employee_id' => $employee_id]);

            $response = $this->ajaxDispatch(new CreateDismissal($request));

            if ($response['success']) {
                $message = $response['data']->employee->name . ': ' . trans('employees::employees.messages.dismissed');
    
                flash($message)->success();
            }
        }
    }
}
