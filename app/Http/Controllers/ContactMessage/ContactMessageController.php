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
    public function index()
    {
        $contact_message = DB::table('contact_messages')
            ->select('contact_messages.id', 'contact_id', 'message_id', 'contacts.first_name as contact_first_name', 'messages.message as message_name')
            ->join('contacts', 'contact_messages.contact_id', '=', 'contacts.id')
            ->join('messages', 'contact_messages.message_id', '=', 'messages.id')
            ->orderBy('contact_id', 'asc')
            ->get();

        return (ContactMessageResource::collection($contact_message))->additional([
            'message' => 'Successfully Index Date',
            'status' => true
        ]);
    }
}
