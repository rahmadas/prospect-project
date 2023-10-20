<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
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
    function show(User $user)
    {
        $user = auth()->user();
        return (new UserResource($user))->additional([
            'success' => true,
            'message' => 'Register Success',
        ]);
        // return response()->json([
        //     'data' => auth()->user(),
        //     'status' => 'true',
        //     'data' => $user = auth()->user()
        // ]);
    }

    function update(StoreUserRequest $request, User $user)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;

        $user->update($data);

        return (new UserResource($user))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }
}
