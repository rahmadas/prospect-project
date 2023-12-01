<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Contact;
use App\Models\Contact_message;
use App\Models\Message;
use App\Models\Message_template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;
        $messages = Message::orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $messages->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('message_template_id', 'like', '%' . $query . '%')
                    ->orWhere('message', 'like', '%' . $query . '%')
                    ->orWhere('status', 'like', '%' . $query . '%');
            });
        }

        $messages = $messages->paginate($perPage);

        return MessageResource::collection($messages)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreMessageRequest $request, Message $message)
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
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Message $message)
    {
        return (new MessageResource($message))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreMessageRequest $request, Message $message)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $message->update($data);

        return (new MessageResource($message))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy(Message $message)
    {
        $message->delete();

        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ]);
    }
}
