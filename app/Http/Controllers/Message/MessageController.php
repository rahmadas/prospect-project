<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Contact_message;
use App\Models\Message;
use App\Models\Message_template;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('user_id', 'asc')->get();
        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $message = Message::create($data);

        return (new MessageResource($message))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Message $message)
    {

        return response([
            'data' => $message,
            'status' => 'true'
        ]);
    }

    function update(StoreMessageRequest $request, Message $message)
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
