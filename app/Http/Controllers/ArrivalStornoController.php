<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Arrival;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Http\Requests\ArrvalStornoPostRequest;

class ArrivalStornoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('create storno_arrival'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('create storno_arrival'), except: ['store','create','index','show','destroy'])
        ];
    }
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
    public function update(ArrvalStornoPostRequest $request, $id)
    {
        $newArrival = null;
        
        //set stornoed the old arrival and create new storno arrival
        $oldSale = Arrival::where('uuid', $id)->first();
        Arrival::where('uuid', $id)->update(['arrival_status' => "STORNOED"]);
        $stornoSale = Arrival::create(['arrival_status' => 'STORNO',
                    'suplier_id' => $oldSale->suplier_id,
                    'arrival_date' => $oldSale->arrival_date,
                    'payment_date' => $oldSale->payment_date,
                    'invoice_number' => $oldSale->invoice_number,
                    'suplier_note_number' => $oldSale->suplier_note_number]);

        foreach($request->storno_items as $Key => $Transaction){
            
            //set transaction stornoed and create new storno transaction
            Transaction::where('uuid', $Key)->update(['status' => 'STORNOED']);
            $oldTransaction = Transaction::where('uuid', $Key)->first();
            Transaction::create(['product_id' => $oldTransaction->product_id,
                        'inner_table_id' => $stornoSale->uuid,
                        'qty' => $oldTransaction->qty * -1,
                        'net_price' => $oldTransaction->net_price,
                        'sale_price' => $oldTransaction->sale_price,
                        'status' => 'STORNO']);

            //create new arrival if net sale or qty was changed
            if($Transaction['net_price'] != $oldTransaction->net_price || $Transaction['qty'] != $oldTransaction->qty )
            {
                if($newArrival == null)
                    $newArrival = Arrival::create(['arrival_status' => 'COMPLETED',
                        'suplier_id' => $oldSale->suplier_id,
                        'arrival_date' => $oldSale->arrival_date,
                        'payment_date' => $oldSale->payment_date,
                        'invoice_number' => $oldSale->invoice_number,
                        'suplier_note_number' => $oldSale->suplier_note_number]);

                Transaction::create(['product_id' => $oldTransaction->product_id,
                    'qty' => $Transaction['qty'],
                    'net_price' => $Transaction['net_price'],
                    'sale_price' => $oldTransaction->sale_price,
                    'inner_table_id' => $newArrival->uuid,
                    'status' => 'COMPLETED']);
            }
        }

        return redirect('arrivals')->with("success", "Successfull save!");
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
