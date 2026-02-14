<?php

namespace Modules\Employees\Http\Controllers\Modals;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Employees\Http\Requests\Department as Request;
use Modules\Employees\Jobs\Department\CreateDepartment;
use Modules\Employees\Models\Department;

class Departments extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-employees-departments')->only(['index', 'create', 'store']);
    }

    public function index()
    {
        $departments = Department::enabled()->collect();

        return $this->response('employees::settings.departments.index', compact('departments'));
    }

    public function create(): JsonResponse
    {
        $managers = company()->users()->pluck('name', 'id')->sortBy('name');

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => 'null',
            'html' => view('employees::modals.departments.create', compact('managers'))->render(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreateDepartment($request));

        if ($response['success']) {
            $response['message'] = trans('messages.success.added', ['type' => trans_choice('employees::general.departments', 1)]);
        }

        return response()->json($response);
    }
}
