<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{

    // Register a new user
    public function register(Request $request)
    {
        // Validate incoming request data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
    
        // Create a new user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    
        // Generate access token for the user
        $token = $user->createToken('E-commerceLaravel')->accessToken;
    
        // Return success response with access token
        return response()->json(['token' => $token], 200);
    }

    // Authenticate a user
    public function login(Request $request)
    {
        // Extract user credentials from the request
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Attempt to authenticate the user
        if (auth()->attempt($data)) {
            // If authentication succeeds, generate access token for the user
            $token = auth()->user()->createToken('E-commerceLaravel')->accessToken;
            // Return success response with access token
            return response()->json(['token' => $token], 200);
        } else {
            // If authentication fails, return error response
            return response()->json(['error' => 'User Not Found!'], 401);
        }
    }

    // Get the authenticated user information
    public function userInfo()
    {
        // Get the authenticated user
        $user = auth()->user();
        // Return user information as JSON response
        return response()->json(['user' => $user], 200);
    }
    
}
