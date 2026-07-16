<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\InventoryAdjustmentItemPostRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class InventoryAdjustmentItemController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('create edit_sale'), only: ['store']),
            new Middleware(PermissionMiddleware::using('create edit_sale'), except: ['create','index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit edit_sale'), only: ['update']),
            new Middleware(PermissionMiddleware::using('edit edit_sale'), except: ['edit','index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete edit_sale'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete edit_sale'), except: ['index','create','show','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryAdjustmentItemPostRequest $request)
    {
        Transaction::create(['inner_table_id' => $request['inner_table_id'],
                                        'qty' => $request['qty'] * -1,
                                        'product_id' => $request['product_id'],
                                        'net_price' => $request['net_price'],
                                        'type' => 'ADJUSTMENT']);
        
        return redirect()->back()->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $inventory_adjustment_item;
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryAdjustmentItemPostRequest $request, Transaction $inventory_adjustment_item)
    {
        Transaction::where("id", $inventory_adjustment_item->id)->update(['qty' => $request['qty'] * -1]);

        return redirect()->back()->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \App\Models\Transaction  $inventory_adjustment_item;
     */
    public function destroy(Transaction $inventory_adjustment_item)
    {
        $deleteCart = Transaction::findOrFail($inventory_adjustment_item->id);
        $deleteCart->delete();
        
        return redirect()->back()->with("success", "Successfull deleted!");
    }
}
