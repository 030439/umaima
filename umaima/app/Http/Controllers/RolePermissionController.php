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
   protected $role;
    public function __construct(PermissionsService $permissionsService,Role $role)
    {
        $this->permissionsService = $permissionsService;
        $this->role=$role;
    }

    public function index()
    {
        $this->authorize('role_read', $this->role);
        return view('roles.index');
    }

    public function storeRole()
    {
        $this->authorize('role_create', $this->role);
        $role = $this->permissionsService->createRoleWithPermissions();
        return $role;
    }

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
