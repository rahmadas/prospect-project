<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Contact_category;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use PSpell\Config;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('user_id', 'asc')->get();
        return ContactResource::collection($contacts);

        // $user = auth()->user();
        // $contacts = Contact::where('user_id', $user->id)->get();    

        // return ContactResource::collection($contacts);

        // $contact = Contact::all();
        // return response()->json([
        //     'data' => $contact,
        //     'status' => 'true'
        // ]);
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

        // $data = $request->validated();
        // $data['user_id'] = auth()->user()->id;
        // $contact = Contact::create($data);

        // $firstName = $user->first_name;
        // $lastName = $user->last_name;
        // $phoneNumber = $user->phone_number;
        // $homeNumber = $user->home_number;
        // $workNumber = $user->work_number;
        // $email = $user->email;

        // $contact->with('user');

        // return response()->json([
        //     'data' => [
        //         'user_id' => $data['user_id'],
        //         'user_first_name' => $firstName,
        //         'user_last_name' => $lastName,
        //         'user_phone_number' => $phoneNumber,
        //         'user_home_number' => $homeNumber,
        //         'user_work_number' => $workNumber,
        //         'user_email' => $email,
        //     ],
        //     'message' => 'Successs create date',
        //     'status' => true
        // ]);
    }

    function show(Contact $contact)
    {
        return (new ContactResource($contact))->additional([
            'status' => true
        ], 200);
        // return response()->json([
        //     'data' => $contact,
        //     'status' => 'true'
        // ]);
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

        // $data = $contact->update($request->validated());
        // return response()->json([
        //     'data' => $data,
        //     'status' => 'true'
        // ]);
    }

    function destroy(Contact $contact)
    {

        // karena di dalam methode update sudah ada di model Contact
        // tidak perlu membuat syntax
        // $category = Category::findOrFail($category);

        // Delete the Category record
        $contact->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
        // $contact->delete();
        // return response()->json([
        //     'status' => true
        // ]);
    }
}
