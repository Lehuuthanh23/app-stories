<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        Log::info('Vao them');
        $validatedData = $request->validate([
            'user_id' => 'required|string|unique:users',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:100|unique:users',
            'age' => 'required|int',
        ]);
        Log::info('Validated Data:', $validatedData);
        $user = User::create([
            'user_id' => $validatedData['user_id'],
            'username' => $validatedData['username'],
            'password' => bcrypt($request->password),
            'email' => $validatedData['email'],
            'age' => $validatedData['age']
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'sometimes|required|string|max:50|unique:users,username',
            'password' => 'sometimes|required|string|min:6',
            'email' => 'sometimes|required|string|email|max:100|unique:users,email',
            'age' => 'sometimes|required|int|age',
        ]);
        Log::info('Validated Data:', $validatedData);
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('authToken')->accessToken;
    //         return response()->json(['token' => $token], 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    // }
}