<?php

namespace App\Http\Controllers\MessageTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageTemplate\MessageTemplateRequest;
use App\Http\Resources\MessageTemplateResource;
use App\Models\Message_template;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class MessageTemplateController extends Controller
{
    public function index()
    {

        $messageTemplate = Message_template::all();

        return response()->json([
            'date' => $messageTemplate,
            'status' => 'true'
        ]);
    }

    public function store(MessageTemplateRequest $request)
    {

        $user = auth()->user();

        $messageTemplate = new Message_template();
        $messageTemplate->user_id = $request->input('user_id');
        $messageTemplate->title = $request->input('title');
        $messageTemplate->message = $request->input('message');

        // dd($messageTemplate);
        //saya menggunakn $user->id untuk mencari data user, yang dimana
        // yang akan di ambil adalah nilai id
        $messageTemplate->user_id = $user->id;

        $messageTemplate->save();
        return new MessageTemplateResource($messageTemplate);
    }

    function show(Message_template $messageTemplate)
    {

        return response()->json([
            'date' => $messageTemplate,
            'status' => 'true'
        ]);
    }

    function update(MessageTemplateRequest $request, Message_template $messageTemplate)
    {

        $data = $messageTemplate->update($request->validated());

        return response()->json([
            'date' => $data,
            'status' => 'Successs update date'
        ]);
    }

    function destroy(Message_template $messageTemplate)
    {

        $messageTemplate->delete();

        return response()->json([
            'date' => $messageTemplate,
            'status' => 'Success delete date'
        ]);
    }
}
