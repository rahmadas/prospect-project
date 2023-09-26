<?php

namespace App\Http\Controllers\ProFeature;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProFeature\StoreProFeatureRequest;
use App\Http\Requests\UserProFeature\StoreUserProFeatureRequest;
use App\Http\Resources\ProFeature\ProFeatureResource;
use App\Models\Category;
use App\Models\Pro_feature;
use Illuminate\Http\Request;

class ProFeatureController extends Controller
{
    public function index()
    {

        $pro_feature = Pro_feature::orderBy('name', 'desc')->get();
        return ProFeatureResource::collection($pro_feature);
    }

    public function Store(StoreProFeatureRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $pro_feature = Pro_feature::create($data);
        return (new ProFeatureResource($pro_feature))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Pro_feature $pro_feature)
    {
        return new ProFeatureResource($pro_feature);
    }

    function update(StoreProFeatureRequest $request, Pro_feature $pro_feature)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $pro_feature->update($data);

        return (new ProFeatureResource($pro_feature))->additional([
            'status' => 'Seccessfully Update Date'
        ], 200);
    }

    function destroy(Pro_feature $pro_feature)
    {
        // $pro_feature = Pro_feature::findOrFail($pro_feature);
        $pro_feature->delete();

        return response()->json([
            'status' => 'Successfuly Delete Date'
        ], 200);
    }
}
