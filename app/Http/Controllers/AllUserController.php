<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AllUser;
use Illuminate\Http\Request;

class AllUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allUsers = AllUser::all();
        return response()->json(['data' => $allUsers], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:all_users',
            'password' => 'required|min:6',
        ]);

        $user = AllUser::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['data' => $user], 201);
    }
}
