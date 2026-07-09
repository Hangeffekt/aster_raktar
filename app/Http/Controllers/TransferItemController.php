<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Http\Requests\TransferItemPostRequest;

class TransferItemController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('create edit_transfer'), only: ['store']),
            new Middleware(PermissionMiddleware::using('create edit_transfer'), except: ['create','index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit edit_transfer'), only: ['update']),
            new Middleware(PermissionMiddleware::using('edit edit_transfer'), except: ['edit','index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete edit_transfer'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete edit_transfer'), except: ['index','create','show','store','edit','update']),
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
    public function store(TransferItemPostRequest $request)
    {

        Transaction::create(['inner_table_id' => $request['inner_table_id'],
                                        'qty' => $request['qty'] * -1,
                                        'sale_price' => $request['sale_price'],
                                        'product_id' => $request['product_id'],
                                        'type' => 'TRANSFER']);
        return redirect()->back()->with("success", "Successfull created!");
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
    public function update(TransferItemPostRequest $request, Transaction $transferitem)
    {
        Transaction::where("id", $transferitem->id)->update(['qty' => $request['qty'] * -1,
                                            'sale_price' => $request['sale_price'],]);

        return redirect()->back()->with("success", "Successfull updated!");
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
        
        return redirect()->back()->with("success", "Successfull deleted!");
    }
}
