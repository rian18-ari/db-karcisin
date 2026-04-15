<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'title' => 'login',
                'message' => 'invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'title' => 'login',
            'data' => [
                'token' => $token,
                'user' => $user
            ],
            'message' => 'success'
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'email_verified_at' => date('Y-m-d H:i:s'),
            
        ]);

        $user = User::create($request->all());

        return response()->json([
            'title' => 'register',
            'data' => $user,
            'message' => 'success'
        ], 200);
    }
}
