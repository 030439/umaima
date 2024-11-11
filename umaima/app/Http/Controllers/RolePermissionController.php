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
        return view('roles.index');
    }

    public function storeRole()
    {
        $role = $this->permissionsService->createRoleWithPermissions();
        return $role;
    }

    public function permissions()
    {
        return view('permissions.index',['pageName' => 'app-access-permission']);
    }

    public function permissionsList()
    {
        $all = $this->permissionsService->getAll();
        return response()->json($all);
    }

    public function storePermission()
    {
        $result = $this->permissionsService->createPermission();
        return ($result);
    }
    public function getRoles()
    {
        $roles = Role::all(['id', 'name']); // Fetch roles with only id and name
        return response()->json($roles);
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
