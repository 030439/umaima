<?php
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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

