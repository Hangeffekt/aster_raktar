<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class BrandController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_brands'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_brands'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create brand'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create brand'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit brand'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit brand'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete brand'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete brand'), except: ['index','create','store','edit','update']),
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
        return view('Brand/brands', [
            'Brands' => Brand::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Brand/createbrand');
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
            'brand_name' => 'required|unique:brands'
        ]);
        $Brand = Brand::create($validated);
        
        return redirect("/brands")->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $editBrand = Brand::findOrFail($brand->brand_id);

        return view('Brand/editBrand', compact('editBrand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands'
        ]);

        $update = Brand::where('brand_id', $brand->brand_id)->update($validated);
        
        return redirect("/brands")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $deleteBrand = Brand::findOrFail($brand->brand_id);
        $deleteBrand->delete();
        
        return redirect("/brands")->with("success", "Successfull deleted!");
    }
}
