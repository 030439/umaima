<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\UserService;

class RolePermissionController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        return view('permissions.index',['pageName' => 'app-access-permission']);
    }

    public function permissionsList()
    {
        $users = $this->userService->getUsers();
        return response()->json($users);
    }

    public function storePermission()
    {
        $result = $this->userService->createPermission();
        return response()->json($result);
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
