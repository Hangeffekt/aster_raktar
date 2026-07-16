<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class TaxController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_taxes'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_taxes'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create tax'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create tax'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit tax'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit tax'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete tax'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete tax'), except: ['index','create','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Tax/taxes', [
            'Taxes' => Tax::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Tax/createtax');
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
            'tax_value' => 'required|unique:taxes'
        ]);
        $Tax = Tax::create($validated);

        return redirect("/taxes")->with("success", "Sikeres created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        $editTax = Tax::findOrFail($tax->tax_id);

        return view('Tax/editTax', compact('editTax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        $validated = $request->validate([
            'tax_value' => 'required|unique:taxes'
        ]);

        $updateBrand = Tax::where('tax_id', $tax->tax_id)->update($validated);
        
        return redirect("/taxes")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        $deleteBrand = Tax::findOrFail($tax->tax_id);
        $deleteBrand->delete();
        
        return redirect("/taxes")->with("success", "Successfull delete!");
    }
}
