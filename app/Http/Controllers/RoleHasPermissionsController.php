<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleHasPermissionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_permissions'), only: ['index']),
            new Middleware(PermissionMiddleware::using('show main_datas_permissions'), except: ['create','show','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit permission'), only: ['update']),
            new Middleware(PermissionMiddleware::using('edit permission'), except: ['create','show','store','edit','index','destroy']),
        ];
    }
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
        $user = Auth::user();
        foreach($Roles as $Role){
            if($Role->name == 'admin'){
                if(Auth::user()->roles->first()?->name == 'admin'){
                    if($request->has($Role->name)){
                        $Role->givePermissionTo($permission);
                        $permission->assignRole($Role);
                    }
                    else{
                        $Role->revokePermissionTo($permission);
                        $permission->removeRole($Role);         
                    }
                }
            }
            else{
                if($request->has($Role->name)){
                    $Role->givePermissionTo($permission);
                    $permission->assignRole($Role);
                }
                else{
                    $Role->revokePermissionTo($permission);
                    $permission->removeRole($Role);         
                }
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
