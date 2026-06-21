<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferItemController extends Controller
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
        $validated = $request->validate([
            'inner_table_id' => 'required',
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ]);

        Transaction::create(['inner_table_id' => $validated['inner_table_id'],
                                        'qty' => $validated['qty'] * -1,
                                        'sale_price' => $validated['sale_price'],
                                        'product_id' => $validated['product_id'],
                                        'type' => 'TRANSFER']);
        return redirect("/transfer/".$validated['inner_table_id']."/edit")->with("success", "Succesfull create!");
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
     * @param  \App\Models\Transaction  $transferitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transferitem)
    {
        $validated = $request->validate([
            'sale_price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);
        
        Transaction::where("id", $transferitem->id)->update(['qty' => $validated['qty'] * -1,
                                            'sale_price' => $validated['sale_price'],]);

        return redirect("/transfer/".$transferitem->inner_table_id."/edit")->with("success", "Succesfull update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transferitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transferitem)
    {
        $deleteTransfer = Transaction::findOrFail($transferitem->id);
        $deleteTransfer->delete();
        
        return redirect("/transfer/".$transferitem->inner_table_id."/edit")->with("success", "Succesfull delete!");
    }
}
