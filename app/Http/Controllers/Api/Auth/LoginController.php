<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function login(LoginRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            $userFullName = $user->first_name . ' ' . $user->last_name;
            $token = $user->createToken('auth_token')->plainTextToken;

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Login Success',
            //     'data' => [
            //         'data' => $user,
            //         'token' => $token
            //     ]
            // ]);
            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => $user,
                'user_full_name' => $userFullName,
                'token' => $token
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Username and Password Didn't Match"
            ]);
        }
    }
}
