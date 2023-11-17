<?php

namespace App\Http\Controllers\ContactMessage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessage\ContactMessageRequest;
use App\Http\Requests\ContactMessage\StoreContactMessageRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\Contact;
use App\Models\Contact_message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class ContactMessageController extends Controller
{
    public function index()
    {
        $contactMessage = Contact_message::all();
        return response()->json([
            'message' => 'Successfully Index Date',
            'status' => true
        ]);
    }
}
