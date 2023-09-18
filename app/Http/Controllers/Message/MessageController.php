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
        $user = auth()->user();

        $message = new Message();
        $message->user_id = $request->input('user_id');
        $message->message_template_id = $request->input('message_template_id');
        $message->message = $request->input('message');
        $message->status = $request->input('status');

        // dd($message);
        //saya menggunakn $user->id untuk mencari data user, yang dimana
        // yang akan di ambil adalah nilai id
        $message->user_id = $user->id;

        $message->save();
        return new MessageResource($message);
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
