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
            $token = $user->createToken('auth_token')->plainTextToken;
            $responseData['access_token'] = $token;

            $first_name = $user->first_name;
            $last_name = $user->last_name;
            $full_name = $first_name . ' ' . $last_name;

            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => array_merge(['full_name' => $full_name], $user->toArray(), $responseData)
            ]);
        } elseif (User::where('email', $request->email)->exists()) {
            // Autentikasi gagal karena kata sandi salah
            $errors = ['password' => 'Password yang Anda masukkan salah!'];
        } else {
            // Autentikasi gagal karena email tidak terdaftar
            $errors = ['email' => 'Email yang Anda masukkan tidak terdaftar!'];
        }

        return response()->json([
            "message" => "The given data was invalid.",
            'errors' => $errors
        ], 422); // Kode status 422 untuk unprocessable entity
    }
}
