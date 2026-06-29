<?php

namespace App\Http\Controllers;

use App\Models\Modul_locatoin;
use App\Models\Modul;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModulLocatoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ModulLocations = DB::table('modul_locations as ml')
        ->join('moduls as m','m.modul_id','=','ml.modul_id')
        ->join('zones as z','z.zone_id','=','m.zone_id')
        ->select('ml.uuid','z.name','m.line','ml.order','ml.qty','ml.faces','ml.is_active','ml.created_at','ml.updated_at')
        ->get();

        return view('ModulLocation/modullocations', [
            'ModulLocations' => $ModulLocations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modul_locatoin  $modul_locatoin
     * @return \Illuminate\Http\Response
     */
    public function show(Modul_locatoin $modul_locatoin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modul_locatoin  $modul_locatoin
     * @return \Illuminate\Http\Response
     */
    public function edit(Modul_locatoin $modul_locatoin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modul_locatoin  $modul_locatoin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modul_locatoin $modul_locatoin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modul_locatoin  $modul_locatoin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modul_locatoin $modul_locatoin)
    {
        //
    }
}
