<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function register(RegisterRequest $request) {

        $data = $request->validated();
        $data['password'] = bcrypt(($data['password']));
        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;
        // $token = $user->createToken($request->token_name)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register Success',
            'data' => [
                'data' => $user,
                'token' => $token
            ]
            ]);
    } 
}
