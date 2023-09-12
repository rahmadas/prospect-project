<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageRequest;
use App\Models\Message;
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
        $message = Message::create($data);

        return response()->json([
            'data' => $data,
            'status' => 'true'
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
