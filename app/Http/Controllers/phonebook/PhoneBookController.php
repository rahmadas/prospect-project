<?php

namespace App\Http\Controllers\phonebook;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneBook\StorePhoneBookRequest;
use App\Http\Resources\PhoneBook\PhoneBookResource;
use App\Models\PhoneBook;
use Illuminate\Http\Request;

class PhoneBookController extends Controller
{
    public function store(StorePhoneBookRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $phoneBook = PhoneBook::create($data);

        return (new PhoneBookResource($phoneBook))->additional([
            'status' => 'Phone book entry created successfully'
        ], 200);
    }

    public function update(StorePhoneBookRequest $request, PhoneBook $phonebook)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $phonebook->update($data);

        return (new PhoneBookResource($phonebook))->additional([
            'message' => 'Successfully Index Date',
            'status' => true
        ], 200);
    }
}
