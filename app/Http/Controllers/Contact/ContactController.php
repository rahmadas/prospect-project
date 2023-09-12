<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use PSpell\Config;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::all();
        return response()->json([
            'data' => $contact,
            'status' => 'true'
        ]);
    }

    public function store(StoreContactRequest $request)
    {
        //
        $data = $request->validated();

        $contact = Contact::create($data);

        return response()->json([
            'data' => $contact,
            'status' => 'true'
        ]);
    }

    function show(Contact $contact)
    { 
        // Contact::find($contact);
        return response()->json([
            'data' => $contact,
            'status' => 'true'
        ]);
    }

    function update(StoreContactRequest $request, Contact $contact)
    {
        // $contact = Contact::query()
        // ->where("id","=",$contact)
        // ->first();

        // $payload = $request->validated();
        // $contact->update($payload);

        $data = $contact->update($request->validated());
        return response()->json([
            'data' => $data,
            'status' => 'true'
        ]);
    }

    function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([
            'status' => true
        ]);
    }
}
