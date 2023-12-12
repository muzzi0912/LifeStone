<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Validation has passed at this point
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Use your custom success response helper
        return wt_api_json_success(['user' => $user], null, 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        // Validation has passed at this point
        if (!auth()->attempt($request->only('email', 'password'))) {
            // Use your custom error response helper
            return wt_api_json_error('Invalid credentials', 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Use your custom success response helper
        return wt_api_json_success(['user' => $user, 'access_token' => $token], null, 'Login successful');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return wt_api_json_error('User not found', 404);
        }

        $data = $request->validated();

        // Update user data
        $user->update($data);

        // Use your custom success response helper
        return wt_api_json_success(['user' => $user], null, 'User updated successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        // Use your custom success response helper
        return wt_api_json_success(null, null, 'Logout successful');
    }
}