<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionsService;

class RolePermissionController extends Controller
{
    protected $permissionsService;

    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    public function index()
    {
        // $roles = Role::all();
        // $permissions = Permission::all();
        // $users = User::all();
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Group by the prefix of the permission name (e.g., 'user_management')
            return explode('_', $permission->name)[0];
        });
    
        return view('roles.index',compact('permissions'));
        return view('permissions.index', compact('roles', 'permissions', 'users'));
    }
    public function getPermissions()
    {
        try {
            $permissions = Permission::all();
            return response()->json([
                'status' => 'success',
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
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
        $users = $this->permissionsService->getUsers();
        return response()->json($users);
    }

    public function storePermission()
    {
        $result = $this->permissionsService->createPermission();
        return ($result);
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
