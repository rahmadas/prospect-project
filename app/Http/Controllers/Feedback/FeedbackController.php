<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\StoreFeedbackRequest;
use App\Http\Resources\Feedback\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::orderBy('user_id', 'asc')->get();
        return FeedbackResource::collection($feedback);
    }

    public function store(StoreFeedbackRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $feedback = Feedback::create($data);

        return (new FeedbackResource($feedback))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Feedback $feedback)
    {
        return (new FeedbackResource($feedback))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreFeedbackRequest $request, Feedback $feedback)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $feedback->update($data);

        return (new FeedbackResource($feedback))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return response()->json([
            'status' => 'Seccessfully Delete Date'
        ], 200);
    }
}
