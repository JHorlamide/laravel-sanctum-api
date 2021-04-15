<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /* Register a new user */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /* Login User */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('status', 'Invalid login details');
        }

        return 'Your are login in!';
    }

    /* Logout */
    public function logout(Request $request)
    {
//        if (auth()->user()->tokens()->delete()) {
//            return [
//                'message' => 'Logged out'
//            ];
//        }
//
//        return 'Could not perform request!';


        if ($request->user()) {
            $request->user()->tokens()->delete();
            return [
                'message' => 'Logged out'
            ];
        }

        return 'Could not perform request!.';
    }
}
