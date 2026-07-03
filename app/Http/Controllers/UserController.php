<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_users'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_users'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create user'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create user'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit user'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit user'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete user'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete user'), except: ['index','create','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('User/users', [
            'Users' => User::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Roles = Role::get();
        return view('User/createuser', compact('Roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(Str::random(16)),
        ]);
            
        $user->assignRole($request->role);

        return redirect("/users")->with("success", "Successfull created!");
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $editUser = User::where('id', $user->id)->first();
        $Roles = Role::get();


        return view('User/edituser', compact('editUser', 'Roles'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \App\Models\User  $user
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id, 'id')],
        ]);
        
        User::where('id', $user->id)->update([
            'name' => $validated['name'],
            'email' => $validated['email']]);
        $user->assignRole($request->role);

        return redirect("/users")->with("success", "Successfull updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
