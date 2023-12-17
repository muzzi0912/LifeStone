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
            'is_verified' => $request->is_verified, // Assuming 'is_verified' is part of your request
        ]);

        return wt_api_json_success(['user' => $user], null, 'User registered successfully');
    }
}
