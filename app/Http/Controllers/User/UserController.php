<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\UserProFeature\UserProFeatureResource;
use App\Models\User;
use App\Models\User_pro_feature;
use App\Policies\UserProFeaturePolicy;
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
