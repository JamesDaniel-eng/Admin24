<?php

namespace Modules\Admin24\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\Admin24\Imports\TransferOrdersImport as Import;
use App\Http\Requests\Common\Import as ImportRequest;
use Modules\Inventory\Jobs\TransferOrders\CreateTransferOrder;
use Modules\Admin24\Traits\Businesses;
use Modules\Inventory\Models\TransferOrder;

class Main extends Controller
{
    use Businesses;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $businesses = $this->getBusinesses();
        return $this->response('admin24::admin.businesses.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $types = $this->getTypes();
        $tax_status = $this->getStatuses();      
        $industries = $this->getIndustries();
        $bkmethods = $this->getBKMethods();

        //dd($types, $tax_status, $industries, $bkmethods);
        return view('admin24::admin.businesses.create', compact('types', 'tax_status', 'bkmethods'));
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

    /**
     * Import the specified resource.
     *
     * @param  ImportRequest  $request
     *
     * @return Response
     */
    public function import(ImportRequest $request)
    {
        $response = $this->importExcel(new Import, $request, trans_choice('admin24::general.transfer_orders', 2));

        if ($response['success']) {
            $response['redirect'] = route('inventory.transfer-orders.index');

            flash($response['message'])->success();
        } else {
            $response['redirect'] = route('import.create', ['admin24', 'transfer-orders']);

            flash($response['message'])->error()->important();
        }
        
        return response()->json($response);        
    }
}
