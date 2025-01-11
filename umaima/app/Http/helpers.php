<?php
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

 function check(string $permission): bool
    {
       if(!Auth::check()){
        return false;
      }

       // Retrieve permissions from the session.
       $userPermissions = session('user_permissions', []);
    //    dd($userPermissions);
      return in_array($permission, $userPermissions)?true:false;

      // Check if the permission exists in the stored permissions array.
       return in_array($permission, $userPermissions);
    }


if (!function_exists('apiResponse')) {
    function apiResponse(bool $success, string $message, $data = null, int $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
    if (!function_exists('logAction')) {
        function logAction($action, $details = null)
        {
            // Get the current authenticated user's ID
            $user = Auth::check() ? Auth::id() : null;
    
            // Create a log entry in the logs table
            Log::create([
                'user_id' => $user,
                'action' => $action,
                'details' => $details,
                'ip_address' => Request::ip(),
            ]);
        }
    }
}

