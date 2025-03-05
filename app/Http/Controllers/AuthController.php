<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessTokenResult;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        // Validate login credentials
        $credentials = $request->only('email', 'password');

        // Check if the user exists and credentials are valid
        if (auth()->attempt($credentials)) {
            // Create token using Sanctum
            $user = auth()->user();
            $token = $user->createToken('API Token')->plainTextToken;

            // Return the token in the response
            return response()->json(['token' => $token]);
        }

        // If credentials are incorrect
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
