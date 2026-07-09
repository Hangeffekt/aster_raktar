<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SaleStornoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('create storno_sale'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('create storno_sale'), except: ['store','create','index','show','destroy'])
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
     * @param  \App\Models\Sale  $salestorno
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $salestorno)
    {
        $Sale = DB::table('sales as s')
        ->join('payment_types as st', 'st.payment_id', '=', 's.payment_type')
        ->where('s.sale_id', $salestorno->sale_id)
        ->select('st.payment_type', 's.uuid', 's.customer_code', 's.sale_status')
        ->first();

        $Transactions = Transaction::where('inner_table_id', $salestorno->uuid)
            ->where('type', 'OUT')
            ->with(['product.brand', 'product.catalog'])
            ->paginate();
        
        return view('Sale/editsalestorno', compact('Transactions', 'Sale'));
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
        $newSale = null;
        $oldSale = Sale::where('uuid', $id)->first();
        Sale::where('uuid', $id)->update(['sale_status' => "STORNOED"]);
        $stornoSale = Sale::create(['payment_type' => $oldSale->payment_type,
                            'sale_status' => 'STORNO']);
        $Transactions = Transaction::where('inner_table_id', $id)->get();

        foreach($Transactions as $Transaction){
            Transaction::where('id', $Transaction->id)->update(['status' => 'STORNOED']);
            Transaction::where('inner_table_id', array_slice(explode(',', $Transaction->reference), 0, 0))->first();
            Transaction::create(['product_id' => $Transaction->product_id,
                        'inner_table_id' => $stornoSale->uuid,
                        'type' => $oldSale->type,
                        'qty' => $Transaction->qty * -1,
                        'sale_price' => $Transaction->sale_price,
                        'status' => 'STORNO']);

            if(isset($request['qty_'.$Transaction->id]) && $request['qty_'.$Transaction->id] > 0 )
            {
                if($newSale == null)
                    $newSale = Sale::create(['sale_status' => 'COMPLETED',
                    'customer_code' => $oldSale->customer_code,
                    'payment_type' => $oldSale->payment_type]);

                Transaction::create(['product_id' => $Transaction->product_id,
                            'qty' => $request['qty_'.$Transaction->id] * -1,
                            'net_price' => $Transaction->net_price,
                            'sale_price' => $request['sale_price_'.$Transaction->id],
                            'inner_table_id' => $newSale->uuid,
                            'type' => 'OUT',
                            'status' => 'COMPLETED']);
            }
        }

        return redirect('sales')->with("success", "Successfull save!");
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
