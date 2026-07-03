<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ShopController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_shops'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_shops'), except: ['create','store','edit','update','destroy']),
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
            'Shops' => Shop::get()
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
    public function store(Request $request)
    {
        if(Shop::get()->count() > 0)
            return redirect("/shops")->with("error", "There is alredy exits a shop!");

        $validated = $request->validate([
            'shop_name' => 'required',
            'shop_zip_code' => 'numeric|min_digits:4|max_digits:4',
            'shop_address' => 'required|string|min:4|max:255',
            'shop_settlement' => 'required|string|min:2|max:255',
            'shop_tax_number' => 'numeric|unique:supliers,suplier_tax_number',
            'shop_phone' => 'numeric|min_digits:8|max_digits:11',
            'shop_email' => 'required|email'
        ]);
        Shop::create($validated);
        
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
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'shop_name' => 'required',
            'shop_zip_code' => 'numeric|min_digits:4|max_digits:4',
            'shop_address' => 'required|string|min:4|max:255',
            'shop_settlement' => 'required|string|min:2|max:255',
            'shop_tax_number' => 'numeric|unique:supliers,suplier_tax_number',
            'shop_phone' => 'numeric|min_digits:8|max_digits:11',
            'shop_email' => 'required|email'
        ]);

        Shop::where('shop_id', $shop->shop_id)->update($validated);
        
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
