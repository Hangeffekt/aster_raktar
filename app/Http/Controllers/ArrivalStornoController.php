<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Arrival;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ArrivalStornoController extends Controller
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
     * @param  \App\Models\Arrival  $arrivalstorno
     * @return \Illuminate\Http\Response
     */
    public function edit(Arrival $arrivalstorno)
    {
        $Arrival = Arrival::where('arrival_id', $arrivalstorno->arrival_id)
        ->first();

        $Transactions = Transaction::where('inner_table_id', $arrivalstorno->uuid)
            ->with(['product.brand', 'product.catalog'])
            ->paginate(20);
            
        return view('Arrival/arrivalstorno', compact('Transactions', 'Arrival'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newArrival = null;
        $oldSale = Arrival::where('uuid', $id)->first();
        Arrival::where('uuid', $id)->update(['arrival_status' => "STORNOED"]);
        $stornoSale = Arrival::create(['arrival_status' => 'STORNO',
                    'suplier_id' => $oldSale->suplier_id,
                    'arrival_date' => $oldSale->arrival_date,
                    'payment_date' => $oldSale->payment_date,
                    'invoice_number' => $oldSale->invoice_number,
                    'suplier_note_number' => $oldSale->suplier_note_number]);
        $Transactions = Transaction::where('inner_table_id', $id)->get();

        foreach($Transactions as $Transaction){
            Transaction::where('id', $Transaction->id)->update(['status' => 'STORNOED']);
            Transaction::where('inner_table_id', array_slice(explode(',', $Transaction->reference), 0, 0))->first();
            Transaction::create(['product_id' => $Transaction->product_id,
                        'inner_table_id' => $stornoSale->uuid,
                        'qty' => $Transaction->qty * -1,
                        'net_price' => $Transaction->net_price,
                        'sale_price' => $Transaction->sale_price,
                        'status' => 'STORNO']);

            if(isset($request['qty_'.$Transaction->id]) && $request['qty_'.$Transaction->id] > 0 )
            {
                if($newArrival == null)
                    $newArrival = Arrival::create(['arrival_status' => 'COMPLETED',
                    'suplier_id' => $oldSale->suplier_id,
                    'arrival_date' => $oldSale->arrival_date,
                    'payment_date' => $oldSale->payment_date,
                    'invoice_number' => $oldSale->invoice_number,
                    'suplier_note_number' => $oldSale->suplier_note_number]);

                Transaction::create(['product_id' => $Transaction->product_id,
                            'qty' => $request['qty_'.$Transaction->id],
                            'net_price' => $request['sale_price_'.$Transaction->id],
                            'sale_price' => $Transaction->sale_price,
                            'inner_table_id' => $newArrival->uuid,
                            'status' => 'COMPLETED']);
            }
        }

        return redirect('arrivals')->with("success", "Succesfull save!");
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
