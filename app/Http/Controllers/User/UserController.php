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
    function show(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $full_name = $user->first_name . ' ' . $user->last_name;
        // $responseData = $data;

        // $first_name = $data['first_name'];
        // $last_name = $data['last_name'];
        // $full_name = $first_name . ' ' . $last_name;
        $responseData = $data;
        $user = User::create($data);
        // return new UserResource($user);
        return response()->json([
            'success' => true,
            'message' => 'Show User Success',
            'data' => array_merge(['full_name' => $full_name], $user->toArray())
        ]);
        // dd(auth()->user());
        // return response()->json([
        //     'data' => auth()->user(),
        //     'status' => 'true'
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