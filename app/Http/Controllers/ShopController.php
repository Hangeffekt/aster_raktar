<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Http\Requests\ShopPostRequest;

class ShopController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_shop'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_shop'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create shop'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create shop'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit shop'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit shop'), except: ['index','show','create','store','destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Shop/shops', [
            'Shops' => Shop::paginate(1)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Shop/createshop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopPostRequest $request)
    {
        if(Shop::get()->count() > 0)
            return redirect("/shops")->with("error", "There is alredy exits a shop!");

        Shop::create($$request->validated());
        
        return redirect("/shops")->with("success", "Succesfull created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $editShop = Shop::findOrFail($shop->shop_id);

        return view('Shop/editshop', compact('editShop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(ShopPostRequest $request, Shop $shop)
    {
        Shop::where('shop_id', $shop->shop_id)->update($request->validated());
        
        return redirect("/shops")->with("success", "Succesfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
