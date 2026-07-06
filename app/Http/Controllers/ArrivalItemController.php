<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArrivalItem;

class ArrivalItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $validated = $request->validate([
            'arrival_table_id' => 'required',
            'item_id' => 'required|numeric',
            'net_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);
        
        ArrivalItem::create($validated);
        
        return redirect()->back()->with("success", "Succesfull create!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'arrival_item_id' => 'required|numeric',
            'net_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);
        $arrival = ArrivalItem::where("arrival_item_id", $request->arrival_item_id)->update($validated);

        return redirect()->back()->with("success", "Sikeres módosítás!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArrivalItem  $arrivalitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArrivalItem $arrivalitem)
    {
        $deleteItem = ArrivalItem::findOrFail($arrivalitem->arrival_item_id);
        $deleteItem->delete();
        
        return redirect()->back()->with("success", "Sikeres törlés!");
    }
}
