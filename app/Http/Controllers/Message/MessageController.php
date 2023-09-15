<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {

        $message = Message::all();

        return response()->json([
            'data' => $message,
            'status' => 'true'
        ]);
    }

    public function store(MessageRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $message = Message::create($data);

        $user = auth()->user();
        $messageTemplateId = $user->message_template_id;
        $messageField = $user->message;
        $status = $user->status;

        $message->with('user');

        return response()->json([
            'data' => [
                // 'data' => new MessageResource($message)
                'user_id' => $data['user_id'],
                'user_message_template_id' => $messageTemplateId,
                'user_messaeField' => $messageField,
                'user_status' => $status
            ],
            'message' => 'Successs create date',
            'status' => true
        ]);
    }

    function show(Message $message)
    {

        return response([
            'data' => $message,
            'status' => 'true'
        ]);
    }

    function update(MessageRequest $request, Message $message)
    {

        $data = $message->update($request->validated());

        return response()->json([
            'data' => $data,
            'status' => 'Success update'
        ]);
    }

    function destroy(Message $message)
    {

        $message->delete();

        return response([
            'status' => 'Success delete date'
        ]);
    }
}
