<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SuplierController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_supliers'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_supliers'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create suplier'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create suplier'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit suplier'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit suplier'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete suplier'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete suplier'), except: ['index','create','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Suplier/supliers', [
            'Supliers' => Suplier::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Suplier/createsuplier');
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
            'suplier_name' => 'required|unique:supliers',
            'suplier_zip_code' => 'numeric|min_digits:4|max_digits:4',
            'suplier_address' => 'required|string|min:4|max:255',
            'suplier_settlement' => 'required|string|min:2|max:255',
            'suplier_tax_number' => 'numeric|unique:supliers,suplier_tax_number',
            'suplier_phone' => 'numeric|min_digits:8|max_digits:11',
            'suplier_email' => 'required|string|email|max:255|unique:supliers,suplier_email',
        ]);
        
        Suplier::create($validated);

        return redirect("/supliers")->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function show(Suplier $suplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Suplier $suplier)
    {
        $editSuplier = Suplier::findOrFail($suplier->suplier_id);

        return view('Suplier/editSuplier', compact('editSuplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suplier $suplier)
    {
        $validated = $request->validate([
            'suplier_name' => ['required','string','max:255',Rule::unique('supliers')->ignore($suplier->suplier_id, 'suplier_id')],
            'suplier_zip_code' => 'numeric|min_digits:4|max_digits:4',
            'suplier_address' => 'required|string|min:4|max:255',
            'suplier_settlement' => 'required|string|min:2|max:255',
            'suplier_tax_number' => ['required','numeric','max_digits:255',Rule::unique('supliers')->ignore($suplier->suplier_id, 'suplier_id')],
            'suplier_phone' => 'numeric|min_digits:8|max_digits:11',
            'suplier_email' => ['required','string','email','max:255',Rule::unique('supliers')->ignore($suplier->suplier_id, 'suplier_id')],
        ]);

        Suplier::where('suplier_id', $suplier->suplier_id)->update($validated);

        return redirect("/supliers")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suplier $suplier)
    {
        $deleteSuplier = Suplier::findOrFail($suplier->suplier_id);
        $deleteSuplier->delete();
        
        return redirect("/supliers")->with("success", "Successfull deleted!");
    }
}
