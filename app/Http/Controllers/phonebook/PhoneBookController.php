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

        return response()->json([
            'data' => $phoneBook
        ]);
        // return (new PhoneBookResource($phoneBook))->additional([
        //     'status' => 'Phone book entry created successfully'
        // ], 200);
    }

    public function update(Request $request, PhoneBook $phoneBook)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $phoneBook->update($data);

        return response()->json(['message' => 'Phone book entry updated successfully'], 200);
    }
}
