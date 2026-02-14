<?php

namespace Modules\Employees\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\Employees\Jobs\Department\CreateDepartment;
use Modules\Employees\Jobs\Department\DeleteDepartment;
use Modules\Employees\Jobs\Department\UpdateDepartment;
use Modules\Employees\Http\Requests\Department as Request;
use Modules\Employees\Http\Resources\Department as Resource;
use Modules\Employees\Models\Department;

class Departments extends ApiController
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-employees-departments')->only('create', 'store');
        $this->middleware('permission:read-employees-departments')->only('index', 'edit', 'show');
        $this->middleware('permission:update-employees-departments')->only('update', 'enable', 'disable');
        $this->middleware('permission:delete-employees-departments')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $departments = Department::collect();

        return Resource::collection($departments);
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $department = Department::find($id);

        if (! $department instanceof Department) {
            return $this->errorInternal('No query results for model [' . Department::class . '] ' . $id);
        }

        return new Resource($department);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $department = $this->dispatch(new CreateDepartment($request));
            
        return $this->created(route('api.departments.show', $department->id), new Resource($department));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $department = Department::find($id);

        $department = $this->dispatch(new UpdateDepartment($department, $request));

        return new Resource($department->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        try {
            $this->dispatch(new DeleteDepartment($department));

            return $this->noContent();
        } catch(\Exception $e) {
            $this->errorUnauthorized($e->getMessage());
        }
    }
}
