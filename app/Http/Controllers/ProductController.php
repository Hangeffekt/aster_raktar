<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Catalog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products', [
        'Products' => Product::with(['brand', 'catalog', 'tax'])->get()
    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("createproduct", [
            'Brands' => Brand::get(),
            'Taxes' => Tax::get(),
            'Catalogs' => Catalog::get()
        ]);
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
            'brand_id' => 'required|numeric',
            'product_name' => 'required|unique:products',
            'ean' => 'required|numeric',
            'sale_price' => 'numeric',
            'tax_id' => 'required|numeric',
            'catalog_id' => 'required|numeric'
        ]);
        Product::create($validated);

        $product_id = Product::orderby('created_at', 'desc')->first();

        Transaction::create(['product_id' => $product_id->product_id, 'type' => 'SETTLE', 'qty' => 0]);

        return redirect("/products")->with("success", "Sikeres felvétel!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $editProduct = Product::findOrFail($product->product_id);
        $Brands = Brand::get();
        $Taxes = Tax::get();
        $Catalogs = Catalog::get();

        return view('editproduct', compact('editProduct', 'Brands', 'Taxes', 'Catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand_id' => 'required|numeric',
            'product_name' => 'required|unique:products,product_name,'.$product->product_id.',product_id',
            'ean' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'tax_id' => 'required|numeric',
            'catalog_id' => 'required|numeric'
        ]);

        Product::where('product_id', $product->product_id)->update($validated);

        return redirect("/products")->with("success", "Sikeres frissítés!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $deleteProduct = Product::findOrFail($product->product_id);
        $deleteProduct->delete();
        
        return redirect("/products")->with("success", "Sikeres törlés!");
    }
}
