<?php

namespace Modules\Employees\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\Employees\Models\Employee;
use Modules\Employees\Jobs\Employee\CreateEmployee;
use Modules\Employees\Jobs\Employee\DeleteEmployee;
use Modules\Employees\Jobs\Employee\UpdateEmployee;
use Modules\Employees\Http\Requests\Employee as Request;
use Modules\Employees\Http\Resources\Employee as Resource;

class Employees extends ApiController
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-employees-employees')->only('create', 'store');
        $this->middleware('permission:read-employees-employees')->only('index', 'edit', 'show');
        $this->middleware('permission:update-employees-employees')->only('update', 'enable', 'disable');
        $this->middleware('permission:delete-employees-employees')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $employees = Employee::collect();

        return Resource::collection($employees);
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (! $employee instanceof Employee) {
            return $this->errorInternal('No query results for model [' . Employee::class . '] ' . $id);
        }

        return new Resource($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $employee = $this->dispatch(new CreateEmployee($request));
            
        return $this->created(route('api.employees.show', $employee->id), new Resource($employee));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $employee = Employee::find($id);

        $employee = $this->dispatch(new UpdateEmployee($employee, $request));

        return new Resource($employee->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        try {
            $this->dispatch(new DeleteEmployee($employee));

            return $this->noContent();
        } catch(\Exception $e) {
            $this->errorUnauthorized($e->getMessage());
        }
    }
}
