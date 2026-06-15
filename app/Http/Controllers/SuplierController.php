<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supliers', [
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
        return view('createsuplier');
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
            'suplier_zip_code' => 'numeric',
            'suplier_settlement' => 'required',
            'suplier_address' => 'required',
            'suplier_tax_number' => 'numeric|unique:supliers',
            'suplier_phone' => 'numeric',
            'suplier_email' => 'email'
        ]);
        Suplier::create($validated);

        return redirect("/supliers")->with("success", "Sikeres felvétel!");
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

        return view('editSuplier', compact('editSuplier'));
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
            'suplier_name' => 'required|unique:supliers,suplier_name,'.$suplier->suplier_id.',suplier_id',
            'suplier_zip_code' => 'numeric',
            'suplier_address' => 'required',
            'suplier_settlement' => 'required',
            'suplier_tax_number' => 'numeric|unique:supliers,suplier_tax_number,'.$suplier->suplier_id.',suplier_id',
            'suplier_phone' => 'numeric',
            'suplier_email' => 'email'
        ]);

        Suplier::where('suplier_id', $suplier->suplier_id)->update($validated);

        return redirect("/supliers")->with("success", "Sikeres frissítés!");
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
        
        return redirect("/supliers")->with("success", "Sikeres törlés!");
    }
}
