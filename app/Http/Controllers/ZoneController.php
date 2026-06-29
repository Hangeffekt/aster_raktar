<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Zone/zones', [
            'Zones' => Zone::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Zone/createzone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'name' => 'required|unique:zones',
            'is_active' => 'boolean'
        ]);
        
        Zone::create($validated);
        
        return redirect("/zones")->with("success", "Successfull create!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        $editZone = Zone::findOrFail($zone->zone_id);

        return view('Zone/editZone', compact('editZone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'name' => 'required',
            'is_active' => 'boolean'
        ]);

        Zone::where('zone_id', $zone->zone_id)->update($validated);
        
        return redirect("/zones")->with("success", "Successfull update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        Zone::findOrFail($zone->zone_id)->delete();
        
        return redirect("/zones")->with("success", "Successfull update!");
    }
}
