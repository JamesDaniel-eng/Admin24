<?php

namespace Modules\Admin24\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Banking extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->response('admin24::portal.banking.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function income_accs()
    {
        return $this->response('admin24::portal.banking.income-accs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function expense_accs()
    {
        return $this->response('admin24::portal.banking.expense-accs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function transactions()
    {
        return $this->response('admin24::portal.banking.transactions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function reconciliations()
    {
        return $this->response('admin24::portal.banking.reconciliations');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin24::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('admin24::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin24::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
