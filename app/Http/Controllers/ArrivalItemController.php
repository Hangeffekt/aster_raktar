<?php

namespace App\Http\Controllers;

use App\Models\ArrivalItem;
use App\Http\Requests\ArrivalItemPostRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ArrivalItemController extends Controller implements HasMiddleware
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
    public function store(ArrivalItemPostRequest $request)
    {
        ArrivalItem::create($request->all());
        
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
     * @param  \App\Models\ArrivalItem  $arrivalitem
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ArrivalItem  $arrivalitem, ArrivalItemPostRequest $request)
    {
        ArrivalItem::where("arrival_item_id", $arrivalitem->arrival_item_id)->update([
            'net_price' => $request->net_price,
            'sale_price' => $request->sale_price,
            'qty' => $request->qty,
        ]);

        return redirect()->back()->with("success", "Successfull updated!");
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
        
        return redirect()->back()->with("success", "Successfull deleted!");
    }
}
