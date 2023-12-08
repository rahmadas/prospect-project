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
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;

        $query = $request->input('query', '');

        $proFeatures = Pro_feature::select('pro_features.*')
            ->join('user_pro_features', 'pro_features.id', '=', 'user_pro_features.pro_feature_id')
            ->where('user_pro_features.user_id', auth()->user()->id)
            ->orderBy('pro_features.name', 'asc');

        if (!empty($query)) {
            $proFeatures->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('pro_features.name', 'like', '%' . $query . '%')
                    ->orWhere('pro_features.description', 'like', '%' . $query . '%');
            });
        }

        $proFeatures = $proFeatures->paginate($perPage);
        return ProFeatureResource::collection($proFeatures)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function Store(StoreProFeatureRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $pro_feature = Pro_feature::create($data);
        return (new ProFeatureResource($pro_feature))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Pro_feature $pro_feature)
    {
        return (new ProFeatureResource($pro_feature))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ]);
    }

    function update(StoreProFeatureRequest $request, Pro_feature $pro_feature)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $pro_feature->update($data);

        return (new ProFeatureResource($pro_feature))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy(Pro_feature $pro_feature)
    {
        // $pro_feature = Pro_feature::findOrFail($pro_feature);
        $pro_feature->delete();

        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }
}
