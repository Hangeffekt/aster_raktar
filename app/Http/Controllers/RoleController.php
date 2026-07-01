<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Role/roles', [
            'Roles' => Role::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role/createrole');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles'
        ]);
        Role::create($validated);
        
        return redirect("/roles")->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \Spatie\Permission\Models\Role  $role
     */
    public function edit(Role $role)
    {
        $editRole = Role::findOrFail($role->id);

        return view('Role/editrole', compact('editRole'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Spatie\Permission\Models\Role  $role
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles'
        ]);

        Role::where('id', $role->id)->update($validated);
        
        return redirect("/roles")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Spatie\Permission\Models\Role  $role
     */
    public function destroy( Role $role)
    {
        Role::findOrFail($role->id)->delete();
        
        return redirect("/roles")->with("success", "Successfull deleted!");
    }
}
