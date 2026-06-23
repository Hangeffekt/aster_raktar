<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransferStornoController extends Controller
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
     * @param  \App\Models\Transfer  $transferstorno
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transferstorno)
    {
        $Transfer = Transfer::where('transfer_id', $transferstorno->transfer_id)
        ->first();

        $Transactions = Transaction::where('inner_table_id', $transferstorno->uuid)
            ->where('type', 'TRANSFER')
            ->with(['product.brand', 'product.catalog'])
            ->paginate();
        
        return view('Transfer/transferstorno', compact('Transactions', 'Transfer'));
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
        $newTransfer = null;
        $oldSale = Transfer::where('uuid', $id)->first();
        Transfer::where('uuid', $id)->update(['status' => "STORNOED"]);
        $stornoSale = Transfer::create(['status' => 'STORNO',
                    'suplier_id' => $oldSale->suplier_id]);
        $Transactions = Transaction::where('inner_table_id', $id)->get();

        foreach($Transactions as $Transaction){
            Transaction::where('id', $Transaction->id)->update(['status' => 'STORNOED']);
            Transaction::where('inner_table_id', array_slice(explode(',', $Transaction->reference), 0, 0))->first();
            Transaction::create(['product_id' => $Transaction->product_id,
                        'inner_table_id' => $stornoSale->uuid,
                        'type' => 'TRANSFER',
                        'qty' => $Transaction->qty,
                        'net_price' => $Transaction->net_price,
                        'sale_price' => $Transaction->sale_price,
                        'status' => 'STORNO']);

            if(isset($request['qty_'.$Transaction->id]) && $request['qty_'.$Transaction->id] > 0 )
            {
                if($newTransfer == null)
                    $newTransfer = Transfer::create(['status' => 'COMPLETED',
                    'suplier_id' => $oldSale->suplier_id,]);

                Transaction::create(['product_id' => $Transaction->product_id,
                            'type' => 'TRANSFER',
                            'qty' => $request['qty_'.$Transaction->id],
                            'net_price' => $Transaction->sale_price,
                            'sale_price' => $request['sale_price_'.$Transaction->id],
                            'inner_table_id' => $newTransfer->uuid,
                            'status' => 'COMPLETED']);
            }
        }

        return redirect('transfer')->with("success", "Succesfull save!");
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
