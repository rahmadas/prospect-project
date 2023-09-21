<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
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

    public function store(UserRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $user = User::create($data);
        $userProFeature = UserResource::create([
            'pro_feature_id' => $data['pro_feature_id'],
            'user_id' => $user->id
        ]);


        return (new UserResource($user))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }
}