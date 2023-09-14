<?php

namespace App\Http\Controllers\MessageTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageTemplate\MessageTemplateRequest;
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

        $data = $request->validated();
        $messageTemplate = Message_template::create($data);

        return response()->json([
            'date' => $messageTemplate,
            'status' => 'Successs create  date'
        ]);
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
