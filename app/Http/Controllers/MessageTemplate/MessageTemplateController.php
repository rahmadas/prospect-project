<?php

namespace App\Http\Controllers\MessageTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageTemplate\MessageTemplateRequest;
use App\Http\Requests\MessageTemplate\StoreMessageTemplateRequest;
use App\Http\Resources\MessageTemplateResource;
use App\Models\Message;
use App\Models\Message_template;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;


class MessageTemplateController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;
        $messageTemplates = Message_template::orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $messageTemplates->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('message', 'like', '%' . $query . '%');
            });
        }

        $messageTemplates = $messageTemplates->paginate($perPage);

        return MessageTemplateResource::collection($messageTemplates)->additional([
            'status' => 'Successfulyy Index Date'
        ], 200);
    }

    public function store(StoreMessageTemplateRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $message_template = Message_template::create($data);

        return (new MessageTemplateResource($message_template))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Message_template $message_template)
    {
        return (new MessageTemplateResource($message_template))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreMessageTemplateRequest $request, Message_template $message_template)
    {

        $data = $message_template->update($request->validated());

        // Validate the request data
        $data = $request->validated();

        // Update the user_id to the authenticated user's ID
        $data['user_id'] = auth()->user()->id;

        // Update the Category record with the new data
        $message_template->update($data);

        return (new MessageTemplateResource($message_template))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Message_template $message_template)
    {
        // Delete the Category record
        $message_template->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
