<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shops', [
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
        return view('createshop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|unique:shops',
            'shop_address' => 'required',
            'shop_phone' => 'required|numeric',
            'shop_email' => 'required|unique:shops|email'
        ]);
        Shop::create($validated);
        
        return redirect("/shops")->with("success", "Sikeres felvétel!");
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
        $edit = Shop::findOrFail($shop->shop_id);

        return view('editShop', compact('editShop'));
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
            'shop_name' => 'required|unique:shops,shop_name,'.$shop->shop_id.',shop_id',
            'shop_address' => 'required',
            'shop_phone' => 'required|numeric',
            'shop_email' => 'required|email|unique:shops,shop_email,'.$shop->shop_id.',shop_id'
        ]);

        Shop::where('shop_id', $shop->shop_id)->update($validated);
        
        return redirect("/shops")->with("success", "Sikeres frissítés!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $deleteBrand = Shop::findOrFail($shop->shop_id);
        $deleteBrand->delete();
        
        return redirect("/shops")->with("success", "Sikeres törlés!");
    }
}
