<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function show()
    {
        // dd(auth()->user());
        return response()->json([
            'data' => auth()->user(),
            'status' => 'true'
        ]);
    }
}
