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
    // public function index()
    // {
    //     $user = User::orderBy('first_name', 'asc');
    //     return UserResource::collection($user);
    // }

    // public function store(StoreUserRequest $request)
    // {
    //     $data = $request->validated();
    //     $data['user_id'] = auth()->user()->id;

    //     $user = User::create($data);
    //     $userProFeature = User_pro_feature::create([
    //         'pro_feature_id' => $data['pro_feature_id'],
    //         'user_id' => $user->id,
    //     ]);

    //     return (new UserResource($user))->additional([
    //         'status' => 'Successfully Create Date'
    //     ], 200);
    // }

    function show()
    {
        // dd(auth()->user());
        return response()->json([
            'data' => auth()->user(),
            'status' => 'true'
        ]);
    }

    // function update(StoreUserRequest $request, User $user)
    // {
    //     $data = $request->validated();
    //     $data['user_id'] = auth()->user()->id;
    //     $user->update($data);

    //     return (new UserResource($user))->additional([
    //         'status' => 'Successfully Update Date'
    //     ]);
    // }

    // function delete(User $user)
    // {
    //     $user->delete();

    //     return response()->json([
    //         'message' => 'Successfully deleted date'
    //     ]);
    // }
}
