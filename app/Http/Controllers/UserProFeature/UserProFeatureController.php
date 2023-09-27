<?php

namespace App\Http\Controllers\UserProFeature;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProFeature\UserProFeatureResource;
use App\Models\User_pro_feature;
use Illuminate\Http\Request;

class UserProFeatureController extends Controller
{
    public function index()
    {
        $user_pro_feature = User_pro_feature::orderBy('user_id', 'asc')->get();
        return UserProFeatureResource::collection($user_pro_feature);
    }
}
