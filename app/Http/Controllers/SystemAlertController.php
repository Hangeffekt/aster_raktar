<?php

namespace App\Http\Controllers;

use App\Models\SystemAlert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('System/systemalerts', $Systemalerts = Systemalert::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $Systemalerts = SystemAlert::limit(5)->orderBy('created_at', 'desc')->get();

        return response()->json(['Systemalerts' => $Systemalerts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SystemAlert $systemAlert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemAlert $systemAlert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemAlert $systemAlert)
    {
        //
    }
}
