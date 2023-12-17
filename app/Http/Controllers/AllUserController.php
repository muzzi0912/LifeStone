<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\AllUser;

use Illuminate\Http\Request;

class AllUserController extends Controller
{
    public function all_users()
    {
        $allUsers = AllUser::all();
        return response()->json(['data' => $allUsers], 200);
    }


    public function userRegister(RegisterRequest $request)
    {
        $user = AllUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => $request->is_verified,
        ]);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return wt_api_json_success(['user' => $user, 'access_token' => $token], null, 'User registered successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return wt_api_json_success(null, null, 'Logout successful');
    }
}