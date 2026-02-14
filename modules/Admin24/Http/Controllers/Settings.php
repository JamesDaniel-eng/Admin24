<?php

namespace Modules\Admin24\Http\Controllers;

use Modules\Admin24\Models\Admin24Quantities as Quantities;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Common\Item;
use Plank\Mediable\MediableCollection as Collection;
use Modules\Inventory\Models\Item as InventoryItem;
use Illuminate\Support\Arr;

class Settings extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Quantities::where('company_id', company_id())->get();
        $qty_data = new Collection();

        foreach($data as $quantity){
            $item = Item::where('id', $quantity->item_id)->first();
            $inventory_item = InventoryItem::where('item_id', $quantity->item_id)->first();

            $ratio = $quantity->ratio. " / " . $quantity->name;
            $multiplier = $quantity->multiplier;

            if(!empty($item) && !empty($inventory_item)){
                $multiplier = $quantity->multiplier;
                

                if($multiplier >= 2){
                    $multiplier = $quantity->multiplier . " " . $quantity->name ."s";
                    if($quantity->ratio >= 2){
                        $ratio = $quantity->ratio . " " . $inventory_item->unit . "s / " . $multiplier;
                    } else {
                        $ratio = $quantity->ratio . " " . $inventory_item->unit . " / " . $multiplier;
                    }
                } else {
                    $multiplier = $quantity->multiplier . " " . $quantity->name;
                    $ratio = $quantity->ratio . " " . $inventory_item->unit . " / " . $quantity->name;
                }

                $qty_data->push((object)[
                    'id' => $quantity->id,
                    'item_id' => $item->id,
                    'name' => $quantity->name,
                    'item_name' => $item->name,
                    'ratio' => $ratio,
                    'multiplier' => $multiplier,
                ]);

            } else {
                $detach = Quantities::where('item_id', $quantity->item_id)->where('company_id', company_id())->first();
                $detach_data = ['item_id' => null];
                $detach->update($detach_data);

                if($multiplier >= 2){
                    $multiplier = $quantity->multiplier . " " . $quantity->name ."s";
                } else {
                    $multiplier = $quantity->multiplier . " " . $quantity->name;
                }

                $qty_data->push((object)[
                    'id' => $quantity->id,
                    'item_id' => null,
                    'name' => $quantity->name,
                    'item_name' => "No Item",
                    'ratio' => $ratio,
                    'multiplier' => $multiplier,
                ]);
            }
        }

        $quantities = $qty_data;

        return view('admin24::settings.quantities.index', compact('quantities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $items = Item::get()->pluck( 'name', 'id' );

        return view('admin24::settings.quantities.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {        
        $request->merge([
            'company_id' => company_id(),
            'user_id' => user_id(),
        ]);
        $input = $request->all();

        $insert = Quantities::create($input);

        $response = [
            'success' => true,
            'error' => false,
            'redirect' => route('admin24.settings.quantities'),
            'data' => [],
        ];

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
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
     * @return Response
     */
    public function edit($id)
    {
        $quantity = Quantities::where('id', $id)->first();
        $item = Item::where('id', $quantity->item_id)->pluck( 'name', 'id' )->first();
        $items = Item::get();

        return view('admin24::settings.quantities.edit', compact('quantity', 'item', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function set()
    {
        $items = Item::get()->pluck( 'name', 'id' );
        $prod_quantities = $this->getQuantities();

        $qtys = new Collection();

        if(!empty($items) && !empty($prod_quantities)){
            foreach($prod_quantities as $quantity){
                $qty = [
                    'id' => $quantity->id,
                    'name' => $quantity->name.
                              " ( ".trans_choice('admin24::settings.unit', 2).": ". $quantity->ratio .
                              " | ".trans_choice('admin24::settings.quantity', 2).": ".$quantity->multiplier.
                              " ) ",
                ];
                $qtys->push($qty);
            }

            $quantities = $qtys;
        }        

        return view('admin24::settings.quantities.set', compact('items', 'quantities'));
    }

    public function setUpdate(Request $request)
    {
        $response = [];
        $input = $request->all();
        $quantity = Quantities::where('id', $input['quantity'])->first();

        if(!empty($quantity)){
            if(empty($quantity->item_id)){
                $update = ['item_id' => $input['item'],];
                $insert = $quantity->update($update);

                $response = [
                    'success' => true,
                    'error' => false,
                    'redirect' => route('admin24.settings.quantities'),
                    'data' => [],
                ];
            } else {
                if($quantity->item_id != $input['item']){
                    $new_qty = [
                        'company_id' => company_id(),
                        'user_id' => user_id(),
                        'name' => $quantity->name,
                        'item_id' => $input['item'],
                        'ratio' => $quantity->ratio,
                        'multiplier' => $quantity->multiplier,
                    ];

                    Quantities::create($new_qty);

                    $response = [
                        'success' => true,
                        'error' => false,
                        'redirect' => route('admin24.settings.quantities'),
                        'data' => [],
                    ];
                }
            }
        }

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
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
        $response = [];
        $input = $request->all();
        $quantity = Quantities::where('id', $id)->first();

        if(!empty($quantity)){
            $data = [
                'name' => $input['name'],
                'item_id' => $input['item'],
                'ratio' => $input['ratio'],
                'multiplier' => $input['multiplier'],
            ];

            $insert = $quantity->update($data);

            $response = [
                'success' => true,
                'error' => false,
                'redirect' => route('admin24.settings.quantities'),
                'data' => [],
            ];
        }

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
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

    public function getQuantities(){
        $quantities = Quantities::where('company_id', company_id())->get();
        return $quantities;
    }

    public function getQuantity($id){
        $quantity = Quantities::where('company_id', company_id())->where('item_id', $id)->pluck( 'name', 'id' )->first();
        return $quantity;
    }

    public function getItems(){
        $items = Item::where('item_id', $id)->pluck( 'name', 'id' )->first();
        return $items;
    }
}
