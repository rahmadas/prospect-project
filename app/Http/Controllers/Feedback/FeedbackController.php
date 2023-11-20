<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\StoreFeedbackRequest;
use App\Http\Resources\Feedback\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;
        $feedbacks = Feedback::orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $feedbacks->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('feedback_message', 'like', '%' . $query . '%');
            });
        }

        $feedbacks = $feedbacks->paginate($perPage);

        return FeedbackResource::collection($feedbacks)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreFeedbackRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $feedback = Feedback::create($data);

        return (new FeedbackResource($feedback))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Feedback $feedback)
    {
        return (new FeedbackResource($feedback))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreFeedbackRequest $request, Feedback $feedback)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $feedback->update($data);

        return (new FeedbackResource($feedback))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }
}