<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'title' => 'users data',
            'data' => User::all(),
            'message' => 'success'
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'title' => 'users data',
            'data' => $request->user(),
            'message' => 'success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create($request->all());

        return response()->json([
            'title' => 'users data',
            'data' => $user,
            'message' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return response()->json([
            'title' => 'users data',
            'data' => $user,
            'message' => 'success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $user->update($request->all());

        return response()->json([
            'title' => 'users data',
            'data' => $user,
            'message' => 'success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            'title' => 'users data',
            'data' => $user,
            'message' => 'success'
        ], 200);
    }
}
