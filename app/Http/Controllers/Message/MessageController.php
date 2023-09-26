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
        $data['status'] = 1;

        $message = Message::create($data);
        $contactMessage = Contact_message::create([
            'contact_id' => $data['contact_id'],
            'message_id' => $message->id
        ]);

        return (new MessageResource($message))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Message $message)
    {
        return (new MessageResource($message))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreMessageRequest $request, Message $message)
    {

        $data = $message->update($request->validated());

        return response()->json([
            'data' => $data,
            'status' => 'Successfully Update Date'
        ], 200);
    }
}
