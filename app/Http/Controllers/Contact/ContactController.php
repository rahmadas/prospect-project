<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Contact_category;
use App\Models\Contact_message;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use PSpell\Config;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('user_id', 'asc')->get();
        return ContactResource::collection($contacts);
    }

    public function store(StoreContactRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $contact = Contact::create($data);
        // $contactMessage = Contact_message::create([
        //     'contact_id' => $contact->id,
        //     'message_id' => $data['message_id']
        // ]);


        return (new ContactResource($contact))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Contact $contact)
    {
        return (new ContactResource($contact))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreContactRequest $request, Contact $contact)
    {
        // karena di dalam methode update sudah ada 
        // di dalam model Contact
        // $category = Category::findOrFail($category);

        // Validate the request data
        $data = $request->validated();

        // Update the user_id to the authenticated user's ID
        $data['user_id'] = auth()->user()->id;

        // Update the Category record with the new data
        $contact->update($data);

        return (new ContactResource($contact))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Contact $contact)
    {

        // karena di dalam methode update sudah ada di model Contact
        // tidak perlu membuat syntax
        // mencoba menemukan catatan dengan ID-nya untuk Anda, dan Anda tidak perlu menggunakan file 
        // $category = Category::findOrFail($category);

        // Delete the Category record
        $contact->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'successfully deleted date'
        ], 200);
    }
}
