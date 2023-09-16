<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactResource;
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
        $user = auth()->user();

        $contact = new Contact();
        $contact->user_id = $request->input('user_id');
        $contact->first_name = $request->input('first_name');
        $contact->last_name = $request->input('last_name');
        $contact->phone_number = $request->input('phone_number');
        $contact->home_number = $request->input('home_number');
        $contact->work_number = $request->input('work_number');
        $contact->email = $request->input('email');


        $contact->user_id = $user->id;

        $contact->save();
        return new ContactResource($contact);

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
        return response()->json([
            'data' => $contact,
            'status' => 'true'
        ]);
    }

    function update(StoreContactRequest $request, Contact $contact)
    {

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
