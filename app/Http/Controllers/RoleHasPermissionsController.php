<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Roles = Role::get();
        $Permissions = Permission::get();

        return view('Permission/permissions', compact(['Roles','Permissions']));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Spatie\Permission\Models\Permission  $permission
     */
    public function update(Request $request, Permission $permission)
    {
        $Roles = Role::get();
        foreach($Roles as $Role){
            if($request->has($Role->name)){
                $Role->givePermissionTo($permission);
                $permission->assignRole($Role);
            }
            else{
                $Role->revokePermissionTo($permission);
                $permission->removeRole($Role);         
            }
        }
        
        return redirect("/permissions")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
