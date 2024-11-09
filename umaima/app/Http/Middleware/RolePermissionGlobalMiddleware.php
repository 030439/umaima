<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolePermissionGlobalMiddleware
{
    public function handle($request, Closure $next)
    {
        
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        if (!$this->checkPermission($request)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }


    protected function checkPermission($request)
    {
        if (!Auth::check()) {
            return false;
        }

        $routeName = $request->route()->getName();
        $currentUser = Auth::user();

        // Check dynamic roles and permissions
        foreach ($currentUser->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->name == $routeName) {
                    return true; // User has permission to access the route
                }
            }
        }

        return false; // Access denied if no matching permission found
    }
}