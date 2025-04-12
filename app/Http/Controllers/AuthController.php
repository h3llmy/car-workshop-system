<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $role = Role::firstOrCreate(['name' => 'car owner']);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'register success',
            'data' => [
                'token' => $token,
            ]
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'message' => 'login success',
            'data' => [
                'token' => $token
            ],
        ]);
    }

    public function user()
    {
        $user = auth()->user()->load('roles');
        return response()->json([
            'message' => 'get user success',
            'data' => $user
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
