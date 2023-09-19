<?php

namespace App\Http\Controllers\ContactCategory;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCategory\ContactCategoryRequest;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactCategoryResource;
use App\Models\Contact;
use App\Models\Contact_category;
use Illuminate\Http\Request;

class ContactCategoryController extends Controller
{
    public function index()
    {
        $contact_category = Contact_category::orderBy('contact_id', 'asc')->get();
        return ContactCategoryResource::collection($contact_category);
        // return response([
        //     'data' => $contactCategory,
        //     'status' => 'true'
        // ]);
    }

    public function store(ContactCategoryRequest $request)
    {
        // Mengambil data yang divalidasi dari request
        $data = $request->validated();
        // Menambahkan user_id pengguna yang sedang masuk
        $data['user_id'] = auth()->user()->id;

        //     // operasi menyisipkan data
        $contact_category = Contact_category::create($data);

        return (new ContactCategoryResource($contact_category))->additional([
            'status' => 'Successfully Create Date'
        ], 200);

        // $data = $request->validated();
        // $contactCategory = Contact_category::create($data);

        // return response()->json([
        //     'data' => $contactCategory,
        //     'message' => 'Successs create date',
        //     'status' => true
        // ]);
    }

    function show(ContactCategoryRequest $contact_category)
    {
        return (new ContactCategoryResource($contact_category))->additional([
            'status' => true
        ], 200);

        // return response()->json([
        //     'data' => $contactCategory,
        //     'status'
        // ]);
    }

    function update(ContactCategoryRequest $request, Contact_category $contactCategory)
    {

        $data = $contactCategory->update($request->validated());
        return response()->json([
            'data' => $data,
            'status' => 'true'
        ]);
    }

    function delete(CategoryController $contactCategory)
    {

        $contactCategory->delete();
        return response()->json([
            'data' => $contactCategory,
            'status' => 'Successs delele date'
        ]);
    }
}
