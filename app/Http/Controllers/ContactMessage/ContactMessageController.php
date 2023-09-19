<?php

namespace App\Http\Controllers\ContactMessage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessage\ContactMessageRequest;
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
            'date' => $contactMessage,
            'status' => 'true'
        ]);
    }

    public function store(ContactMessageRequest $request)
    {
        // Mengambil data yang divalidasi dari request
        $data = $request->validated();
        // Menambahkan user_id pengguna yang sedang masuk
        $data['user_id'] = auth()->user()->id;

        //     // operasi menyisipkan data
        $contact_message = Contact::create($data);

        return new ContactMessageResource($contact_message);
    }

    function show(Contact_message $contactMessage)
    {

        return response()->json([
            'date' => $contactMessage,
            'status' => 'true'
        ]);
    }

    function update(ContactMessageRequest $request, Contact_message $contactMessage)
    {

        $data = $contactMessage->update($request->validated());

        return response()->json([
            'date' => $data,
            'status' => 'Success update date'
        ]);
    }

    function destroy(Contact_message $contactMessage)
    {

        $contactMessage->delete;

        return response()->json([
            'date' => $contactMessage,
            'status' => 'Success Delete date'
        ]);
    }
}
