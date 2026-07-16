<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Http\Requests\SuplierPostRequest;
use App\Http\Requests\SuplierGetRequest;

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
    public function index(SuplierGetRequest $request)
    {
        $query = Suplier::query()
            ->OfSuplierName($request['suplier_name'])
            ->OfSuplierSettlement($request['suplier_settlement'])
            ->OfSuplierAddress($request['suplier_address'])
            ->OfSuplierZipCode($request['suplier_zip_code'])
            ->OfSuplierTaxNumber($request['suplier_tax_number'])
            ->OfSuplierPhone($request['suplier_phone'])
            ->OfSuplierEmail($request['suplier_email'])
            ->paginate(10);

        return view('Suplier/supliers', [
            'Supliers' => $query
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
    public function store(SuplierPostRequest $request)
    {
        
        Suplier::create($request->all());

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
    public function update(SuplierPostRequest $request, Suplier $suplier)
    {
        Suplier::where('suplier_id', $suplier->suplier_id)->update($request->validated());

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
