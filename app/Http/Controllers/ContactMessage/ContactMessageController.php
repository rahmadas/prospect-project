<?php

namespace App\Http\Controllers\ContactMessage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessage\ContactMessageRequest;
use App\Http\Requests\ContactMessage\StoreContactMessageRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\Contact;
use App\Models\Contact_message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class ContactMessageController extends Controller
{
    public function getContactByMessage($messageId)
    {
        $contact_message = DB::table('contacts')
            ->select('contacts.id', 'contacts.first_name as contact_name', 'contact_messages.id as contact_message_id', 'messages.name as message_name')
            ->join('contact_messages', 'contacts.id', '=', 'contact_messages.contact_id')
            ->join('messages', 'contact_messages.message_id', '=', 'messages.id')
            ->where('contact_messages.message_id', $messageId)
            ->get();

        return (ContactMessageResource::collection($contact_message))->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ]);
    }
}
