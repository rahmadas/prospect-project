<?php

namespace App\Http\Controllers\MessageTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageTemplate\MessageTemplateRequest;
use App\Http\Requests\MessageTemplate\StoreMessageTemplateRequest;
use App\Http\Resources\MessageTemplateResource;
use App\Models\Attachment;
use App\Models\Message;
use App\Models\Message_template;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageTemplateController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;
        $messageTemplates = Message_template::where('user_id', auth()->user()->id)->orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $messageTemplates->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('message', 'like', '%' . $query . '%');
            });
        }

        $messageTemplates = $messageTemplates->paginate($perPage);

        return MessageTemplateResource::collection($messageTemplates)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreMessageTemplateRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $message_template = Message_template::create($data);

        // Handle Attachments
        $attachments = [];

        foreach ($request->file('attachments') as $uploadedAttachment) {
            $attachmentType = $uploadedAttachment->getClientOriginalExtension();
            $attachmentName = time() . '_' . str_replace(' ', '_', $uploadedAttachment->getClientOriginalName());
            $attachmentPath = $uploadedAttachment->storeAs('public/attachments/' . $attachmentType, $attachmentName);

            //for group klik link, in the finish
            $data['attachments'] = 'public/attachments/' . $attachmentName;
            $mimeType = $uploadedAttachment->getMimeType();

            if (str_starts_with($mimeType, 'image/')) {
                $type = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $type = 'video';
            } else {
                $type = 'file';
            }

            $attachment = new Attachment([
                'message_template_id' => $message_template->id,
                'file' => asset('storage/attachments/' . $attachmentType . '/' . $attachmentName),
                'type' => $type,
            ]);
            $attachment->save();
            $attachments[] = $attachment;
        }

        return (new MessageTemplateResource($message_template))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Message_template $message_template)
    {
        return (new MessageTemplateResource($message_template))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreMessageTemplateRequest $request, Message_template $message_template)
    {
        // Validasi data permintaan
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;
        $message_template = Message_template::create($data);

        // Handle Attachments
        $attachments = [];

        foreach ($request->file('attachments') as $uploadedAttachment) {
            $attachmentType = $uploadedAttachment->getClientOriginalExtension();
            $attachmentName = time() . '_' . str_replace(' ', '_', $uploadedAttachment->getClientOriginalName());
            $attachmentPath = $uploadedAttachment->storeAs('public/attachments/' . $attachmentType, $attachmentName);

            //for group klik link, in the finish
            $data['attachments'] = 'public/attachments/' . $attachmentName;
            $mimeType = $uploadedAttachment->getMimeType();

            if (str_starts_with($mimeType, 'image/')) {
                $type = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $type = 'video';
            } else {
                $type = 'file';
            }

            $attachment = new Attachment([
                'message_template_id' => $message_template->id,
                'file' => asset('storage/attachments/' . $attachmentType . '/' . $attachmentName),
                'type' => $type,
            ]);
            $attachment->save();
            $attachments[] = $attachment;
        }

        return (new MessageTemplateResource($message_template))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy(Message_template $message_template)
    {
        // Delete the Category record
        $message_template->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }

    public function getCountAttachment(Request $request, $messageTemplateId)
    {
        // Check if both parameters are present
        if (!$messageTemplateId) {
            return response()->json(['error' => 'Both message_template_id and type are required.'], 400);
        }

        $attachmentCounts = DB::table('attachments')
            ->select(
                DB::raw('COALESCE(SUM(CASE WHEN type = "file" THEN 1 ELSE 0 END), 0) as file'),
                DB::raw('COALESCE(SUM(CASE WHEN type = "video" THEN 1 ELSE 0 END), 0) as video'),
                DB::raw('COALESCE(SUM(CASE WHEN type = "image" THEN 1 ELSE 0 END), 0) as image')
            )
            ->where('message_template_id', $messageTemplateId)
            ->where('type')
            ->first(); // Assuming you expect a single result for counts

        $outputCounts = [
            'count_file' => $attachmentCounts->file,
            'count_video' => $attachmentCounts->video,
            'count_image' => $attachmentCounts->image,
        ];

        return response()->json([
            'attachmentCounts' => $outputCounts,
        ]);
    }
}
