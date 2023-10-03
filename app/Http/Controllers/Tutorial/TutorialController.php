<?php

namespace App\Http\Controllers\Tutorial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tutorial\StoreTutorialRequest;
use App\Http\Resources\Tutorial\TutorialResource;
use App\Models\Tutorial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

use function Laravel\Prompts\text;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;
        $tutorials = Tutorial::orderBy('type', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $tutorials->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('type', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('video_source', 'like', '%' . $query . '%');
            });
        }

        $tutorials = $tutorials->paginate($perPage);

        return TutorialResource::collection($tutorials)->additional([
            'status' => 'Successfully Index Date'
        ], 200);
    }

    public function store(StoreTutorialRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        // $data['type'];

        if ($request->file('video_source')) {
            // Jika ada file video yang diunggah, set tipe ke 2 (video)
            $data['type'] = 2;
        } else {
            // Jika tidak ada file video yang diunggah, set tipe ke 1 (text)
            $data['type'] = 1;
        }

        $uploadedVideo = $request->file('video_source');
        $videoName = time() . '_' . $uploadedVideo->getClientOriginalName();
        $data['video_source'] = $uploadedVideo->storeAs('public/videos', $videoName);

        $tutorial = Tutorial::create($data);

        return (new TutorialResource($tutorial))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Tutorial $tutorial)
    {
        return (new TutorialResource($tutorial))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreTutorialRequest $request, Tutorial $tutorial)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $uploadedVideo = $request->file('video_source');
        $videoName = time() . '_' . $uploadedVideo->getClientOriginalName();
        $data['video_source'] = $uploadedVideo->storeAs('public/videos', $videoName);

        $tutorial->update($data);

        return (new TutorialResource($tutorial))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();

        return response()->json([
            'message' => 'successfully deleted date'
        ], 200);
    }
}
