<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class SaleStornoController extends Controller
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
     * @param  \App\Models\Sale  $salestorno
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $salestorno)
    {
        $Sale = DB::table('sales as s')
        ->join('sale_statuses as st', 'st.sale_status_id', '=', 's.payment_status')
        ->where('s.sale_id', '=', $salestorno->sale_id)
        ->select('st.sale_status_name', 's.sale_id', 's.customer_code', 's.sale_status')
        ->first();

        $Transactions = Transaction::where('inner_table_id', $salestorno->sale_id)
            ->where('type', 'OUT')
            ->with(['product.brand', 'product.catalog'])
            ->paginate();
        
        return view('editsalestorno', compact('Transactions', 'Sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldSale = Sale::where('sale_id', $id)->first();
        Sale::where('sale_id', $id)->update(['sale_status' => "STORNOED"]);
        $stornoSale = Sale::create(['payment_status' => $oldSale->payment_status, 'sale_status' => 'STORNO']);
        $Transactions = Transaction::where('inner_table_id', $id)->get();

        foreach($Transactions as $Transaction){
            Transaction::where('id', $Transaction->id)->update(['status' => 'STORNOED']);
            $net_price = Transaction::where('inner_table_id', array_slice(explode(',', $Transaction->reference), 0, 0))->first();
            Transaction::create(['product_id' => $Transaction->product_id, 'inner_table_id' => $stornoSale->sale_id, 'qty' => $Transaction->qty * -1, 'sale_price' => $Transaction->sale_price, 'status' => 'STORNO']);

            if(isset($request['qty_'.$Transaction->id]) && $request['sale_qty_'.$Transaction->id] > 0 )
                Transaction::create(['qty' => $request['qty_'.$Transaction->id] * -1, 'sale_price' => $request['sale_price_'.$Transaction->id], 'status' => 'COMPLETED']);
        }

        return redirect('sales')->with("success", "Sikeres mentés!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
