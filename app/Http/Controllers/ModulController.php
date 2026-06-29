<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Zone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Moduls = DB::table('moduls as m')
        ->join('zones as z','z.zone_id','=','m.zone_id')
        ->select('m.uuid','z.name','m.line','m.modul_number','m.is_active','m.created_at','m.updated_at')
        ->get();

        return view('Modul/moduls', [
            'Moduls' => $Moduls
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Zones = Zone::where('is_active', 1)->get();

        return view('Modul/createmodul', compact('Zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //zone is active?

        //there is a valid line?
        //in this line exits tha modul?

        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'zone_id' => 'required',
            'line' => 'required',
            'modul_number' => 'required',
            'is_active' => 'boolean'
        ]);
        
        Modul::create($validated);
        
        return redirect("/moduls")->with("success", "Successfull create!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modul  $modul
     * @return \Illuminate\Http\Response
     */
    public function show(Modul $modul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modul  $modul
     * @return \Illuminate\Http\Response
     */
    public function edit(Modul $modul)
    {
        $Zones = Zone::where('is_active', 1)->get();
        $editModul = Modul::findOrFail($modul->modul_id);

        return view('Modul/editmodul', compact('editModul', 'Zones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modul  $modul
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modul $modul)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'zone_id' => 'required',
            'line' => 'required',
            'modul_number' => 'required',
            'is_active' => 'boolean'
        ]);
        
        Modul::where('modul_id', $modul->modul_id)->update($validated);
        
        return redirect("/moduls")->with("success", "Successfull update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modul  $modul
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modul $modul)
    {
        Modul::findOrFail($modul->modul_id)->delete();
        
        return redirect("/moduls")->with("success", "Successfull delete!");
    }
}
