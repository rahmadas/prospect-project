<?php

namespace App\Http\Controllers\MessageTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageTemplate\MessageTemplateRequest;
use App\Http\Resources\MessageTemplateResource;
use App\Models\Message;
use App\Models\Message_template;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class MessageTemplateController extends Controller
{
    public function index()
    {
        $message_template = Message_template::orderBy('user_id', 'asc')->get();
        return MessageTemplateResource::collection($message_template);

        // $messageTemplate = Message_template::all();

        // return response()->json([
        //     'date' => $messageTemplate,
        //     'status' => 'true'
        // ]);
    }

    public function store(MessageTemplateRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $message_template = Message_template::create($data);
        // $message_template = Message_template::create([
        //     'message' => $data['message'],
        //     // 'contact_id' => $contact->id
        // ]);

        return (new MessageTemplateResource($message_template))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Message_template $message_template)
    {
        return (new MessageTemplateResource($message_template))->additional([
            'status' => true
        ], 200);

        // return response()->json([
        //     'date' => $messageTemplate,
        //     'status' => 'true'
        // ]);
    }

    function update(MessageTemplateRequest $request, Message_template $message_template)
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

        // return response()->json([
        //     'date' => $data,
        //     'status' => 'Successs update date'
        // ]);
    }

    function destroy(Message_template $message_template)
    {
        // Delete the Category record
        $message_template->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);

        // $messageTemplate->delete();

        // return response()->json([
        //     'date' => $messageTemplate,
        //     'status' => 'Success delete date'
        // ]);
    }
}
