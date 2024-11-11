<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersService;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index()
    {
        return view('users.index');
    }

    public function Listing(){
        $users = $this->usersService->getUsersWithRoles();
        return response()->json($users);
    }
    public function getUser(){
        $user= $this->usersService->getSingleUser();
        return $user;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            logAction('User Login', 'User ID: ' . Auth::id());
            return redirect()->intended('/dashboard'); // Redirect to intended page
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            logAction('User Login', 'User ID: ' . Auth::id());

            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    function logAction($action, $details = null)
    {
        Log::create([
            'user_id' => Auth::id(), // Logged-in user's ID, null if not logged in
            'action' => $action,
            'details' => $details,
            'ip_address' => Request::ip(),
        ]);
    }

    
}
