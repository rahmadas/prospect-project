<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Contact_category;
use GuzzleHttp\Psr7\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('user_id', 'asc')->paginate(3);
        // $contacts = Contact::orderBy('user_id', 'asc')->get();
        // return ContactResource::collection($contacts);

        //Buat koleksi ContactResource
        $contactCollection = ContactResource::collection($contacts);

        //Buat data paginasi kustom
        $pagination = [
            'total' => $contactCollection->total(),
            'per_page' => $contactCollection->perPage(),
            'current_page' => $contactCollection->currentPage(),
            'last_page' => $contactCollection->lastPage(),
            'next_page_url' => $contactCollection->nextPageUrl(),
            'prev_page_url' => $contactCollection->previousPageUrl(),
        ];

        //Menggabungkan data paginasi dengan data kontak dalam respons JSON
        $responseData = [
            'data' => $contactCollection,
            'pagination' => $pagination,
        ];
        return response()->json($responseData);
    }

    public function store(StoreContactRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $contact = Contact::create($data);

        $contactCategory = Contact_category::create([
            'category_id' => $data['category_id'],
            'contact_id' => $contact->id
        ]);

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
        // Delete the Category record
        $contact->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'successfully deleted date'
        ], 200);
    }
}
