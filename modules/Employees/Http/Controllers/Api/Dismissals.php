<?php

namespace Modules\Employees\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\Employees\Jobs\Dismissal\CreateDismissal;
use Modules\Employees\Jobs\Dismissal\DeleteDismissal;
use Modules\Employees\Http\Requests\Dismissal as Request;
use Modules\Employees\Http\Resources\Dismissal as Resource;
use Modules\Employees\Models\Dismissal;

class Dismissals extends ApiController
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-employees-dismissals')->only('create', 'store');
        $this->middleware('permission:read-employees-dismissals')->only('index', 'edit', 'show');
        $this->middleware('permission:update-employees-dismissals')->only('update', 'enable', 'disable');
        $this->middleware('permission:delete-employees-dismissals')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $dismissals = Dismissal::collect();

        return Resource::collection($dismissals);
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $dismissal = Dismissal::find($id);

        if (! $dismissal instanceof Dismissal) {
            return $this->errorInternal('No query results for model [' . Dismissal::class . '] ' . $id);
        }

        return new Resource($dismissal);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $dismissal = $this->dispatch(new CreateDismissal($request));
            
        return $this->created(route('api.dismissals.show', $dismissal->id), new Resource($dismissal));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dismissal = Dismissal::find($id);

        try {
            $this->dispatch(new DeleteDismissal($dismissal));

            return $this->noContent();
        } catch(\Exception $e) {
            $this->errorUnauthorized($e->getMessage());
        }
    }
}
