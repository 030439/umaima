<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolePermissionGlobalMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('web')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!$this->checkPermission($request)) {
            return response()->json(['error' => 'Unauthorized permission'], 403);
        }

        return $next($request);
    }

    protected function checkPermission($request)
    {
        $routeName = $request->route()->getName();
        $currentUser = Auth::guard('web')->user();

        // Check dynamic roles and permissions
        foreach ($currentUser->roles as $role) {
            // dd($role);
            foreach ($role->permissions as $permission) {
                if ($permission->name == $routeName) {
                    return true;
                }
            }
        }

        return false;
    }
}
