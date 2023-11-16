<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\RegisterResource\RegisterResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\UserProFeature\UserProFeatureResource;
use App\Models\User;
use App\Models\User_pro_feature;
use App\Policies\UserProFeaturePolicy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function show(User $user)
    {
        return (new UserResource($user))->additional([
            'message' => 'Successfully Show User',
            'success' => true
        ]);
    }

    function update(StoreUserRequest $request, User $user)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('foto_profiles', $fileName, 'public');
            $data['foto_profile'] = $fileName;
        }

        $user->update($data);

        return (new UserResource($user))->additional([
            'message' => 'Successfully Update User',
            'status' => true
        ], 200);
    }
}
