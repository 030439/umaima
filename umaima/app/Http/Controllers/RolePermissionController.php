<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    
    public function index()
    {
        // $roles = Role::all();
        // $permissions = Permission::all();
        // $users = User::all();
        return view('roles.index');
        return view('permissions.index', compact('roles', 'permissions', 'users'));
    }

    // public function storeRole(Request $request)
    // {
    //     $request->validate(['name' => 'required|unique:roles,name']);
    //     Role::create(['name' => $request->name]);
    //     return back()->with('success', 'Role created successfully.');
    // }

    public function permissions()
    {
        // $roles = Role::all();
        // $permissions = Permission::all();
        // $users = User::all();
        return view('permissions.index');
        return view('permissions.index', compact('roles', 'permissions', 'users'));
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permission created successfully.');
    }

    // public function assignRole(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'role' => 'required|exists:roles,name',
    //     ]);
    //     $user = User::findOrFail($request->user_id);
    //     $user->assignRole($request->role);
    //     return back()->with('success', 'Role assigned to user successfully.');
    // }
}
