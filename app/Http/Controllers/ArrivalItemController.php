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
        //
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
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $deleteItem = ArrivalItem::findOrFail($request->arrival_item_id);
        $deleteItem->delete();
        
        return redirect()->back()->with("success", "Sikeres törlés!");
    }
}
