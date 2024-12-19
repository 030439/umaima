<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator; // Add this line

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


    public function saveUser(Request $request)
    {
        try {
            $data = $request->input('user');
            $data['status'] = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);
            // Validate request data
            $validatedData = Validator::make($data, [
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
                'status' => ['required', 'boolean'],
            ]);  
            if ($validatedData->fails()) {
                $errors = $validatedData->errors();
                // Handle duplicate email error specifically
                if ($errors->has('email') && strpos($errors->first('email'), 'unique') !== false) {
                    return response()->json([
                        'message' => "he email has already been taken",
                        'success' => false
                    ]);
                }  
                return response()->json([
                    'message' => $errors->all(),
                    'success' => false
                ]);
            }
            // Create a new user with mapped data
            $user = User::create([
                'fname' => $data['firstName'],
                'lname' => $data['lastName'],
                'username' => $data['username'],
                'status' => $data['status'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            // Fire registered event and assign role
            event(new Registered($user));
            $user->assignRole($data['role']);
            // Success response
            return response()->json([
                'message' => 'User created successfully!',
                'success' => true
            ]);    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
                'success' => false
            ]);
        } 
        // catch (\Exception $e) {
        //     return response()->json([
        //         'message' => "An error occurred while creating the user.",
        //         'success' => false
        //     ]);
        // }
    }
    

}
