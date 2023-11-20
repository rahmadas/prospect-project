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
            'message' => 'Successfully Index Date',
            'status' => true
        ], 200);
    }

    public function store(StoreTutorialRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        // Handle Thumbnail
        if ($request->file('thumbnail')) {
            $uploadedThumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . str_replace(' ', '_', $uploadedThumbnail->getClientOriginalName());
            $thumbnailPath = $uploadedThumbnail->storeAs('public/thumbnails', $thumbnailName);
            $data['thumbnail'] = 'public/thumbnails/' . $thumbnailName;
        } else {
            $data['thumbnail'] = 'public/thumbnails/default_thumbnail.jpg';
        }

        // Handle Video
        if ($request->file('video_source')) {
            $data['type'] = '2';
            $uploadedVideo = $request->file('video_source');
            $videoName = time() . '_' . str_replace(' ', '_', $uploadedVideo->getClientOriginalName());
            $videoPath = $uploadedVideo->storeAs('public/videos', $videoName);
            $data['video_source'] = 'public/videos/' . $videoName;
        } else {
            $data['type'] = '1';
            $data['video_source'] = null;
        }

        // Create tutorialtes
        $tutorial = Tutorial::create($data);

        // Generate URLs for thumbnail and video (if exists)
        $data['thumbnail'] = 'public/thumbnails/' . $thumbnailName;
        $videoUrl = $tutorial->type == '2' ? asset(str_replace('public/', 'storage/', $tutorial->video_source)) : null;

        return (new TutorialResource($tutorial))->additional([
            'message' => 'Successfully Create Date',
            'status' => true,
        ], 200);
    }

    function show(Tutorial $tutorial)
    {
        return (new TutorialResource($tutorial))->additional([
            'message' => 'Successfully Show Date',
            'status' => true
        ], 200);
    }

    function update(StoreTutorialRequest $request, Tutorial $tutorial)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        // Handle Thumbnail
        if ($request->file('thumbnail')) {
            $uploadedThumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . str_replace(' ', '_', $uploadedThumbnail->getClientOriginalName());
            $thumbnailPath = $uploadedThumbnail->storeAs('public/thumbnails', $thumbnailName);
            $data['thumbnail'] = 'public/thumbnails/' . $thumbnailName;
        } else {
            $data['thumbnail'] = 'public/thumbnails/default_thumbnail.jpg';
        }

        // Handle Video
        if ($request->file('video_source')) {
            $data['type'] = '2';
            $uploadedVideo = $request->file('video_source');
            $videoName = time() . '_' . str_replace(' ', '_', $uploadedVideo->getClientOriginalName());
            $videoPath = $uploadedVideo->storeAs('public/videos', $videoName);
            $data['video_source'] = 'public/videos/' . $videoName;
        } else {
            $data['type'] = '1';
            $data['video_source'] = null;
        }

        $tutorial->update($data);

        // Generate URLs for thumbnail and video (if exists)
        $data['thumbnail'] = 'public/thumbnails/' . $thumbnailName;
        $videoUrl = $tutorial->type == '2' ? asset(str_replace('public/', 'storage/', $tutorial->video_source)) : null;


        return (new TutorialResource($tutorial))->additional([
            'message' => 'Successfully Update Date',
            'status' => true
        ], 200);
    }

    function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();

        return response()->json([
            'message' => 'Successfully Delete Date',
            'status' => true
        ], 200);
    }
}
