<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_roles'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_roles'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create role'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create role'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit role'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit role'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete role'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete role'), except: ['index','create','show','store','edit','update']),
        ];
    }

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
        if($role->name == 'admin')
            return redirect("/roles")->with("error", "You can not do this action!");
        
        Role::findOrFail($role->id)->delete();
        
        return redirect("/roles")->with("success", "Successfull deleted!");
    }
}
