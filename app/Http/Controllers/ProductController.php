<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Catalog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductPostRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ProductController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_products'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_products'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create product'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create product'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit product'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit product'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete product'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete product'), except: ['index','create','show','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('product_name')) {
            $query->where('product_name', 'like', '%' . $request->product_name . '%');
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        return view('Product/products', [
            'Products' => Product::with(['brand', 'catalog', 'tax'])->get(),
            'Brands' => Brand::get(),
            'Taxes' => Tax::get(),
            'Catalogs' => Catalog::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Product/createproduct", [
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
    public function store(ProductPostRequest $request)
    {
        Product::create($request->all());

        $product_id = Product::orderby('created_at', 'desc')->first();

        Transaction::create(['product_id' => $product_id->product_id, 'type' => 'SETTLE', 'qty' => 0, 'status' => 'COMPLETED']);

        return redirect("/products")->with("success", "Succesfull created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $Product = Product::findOrFail($product->product_id);
        $History = Transaction::where('product_id', $product->product_id)->get();

        return view('Product/productinfo', compact('Product', 'History'));
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

        return view('Product/editproduct', compact('editProduct', 'Brands', 'Taxes', 'Catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductPostRequest $request, Product $product)
    {
        Product::where('product_id', $product->product_id)->update([
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'ean' => $request->ean,
            'sale_price' => $request->sale_price,
            'tax_id' => $request->tax_id,
            'catalog_id' => $request->catalog_id,
        ]);

        return redirect("/products")->with("success", "Succesfull updated!");
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
        
        return redirect("/products")->with("success", "Succesfull deleted!");
    }
}
