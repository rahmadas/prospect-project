<?php

namespace App\Http\Controllers\ContactCategory;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCategory\ContactCategoryRequest;
use App\Http\Requests\ContactRequest;
use App\Models\Contact_category;
use Illuminate\Http\Request;

class ContactCategoryController extends Controller
{
    public function index() {

        $contactCategory = Contact_category::all();
        return response([
            'data' => $contactCategory,
            'status' => 'true'
        ]);
    }

    public function store(ContactCategoryRequest $request) {
        
        $data = $request->validated();
        $contactCategory = Contact_category::create($data);

        return response()->json([
            'data' => $contactCategory,
            'status' => 'true'
        ]);
    }

    function show(ContactCategoryRequest $contactCategory) {
        return response()->json([
            'data' => $contactCategory,
            'status'
        ]);
    }

    function update(ContactCategoryRequest $request, Contact_category $contactCategory) {
        
        $data = $contactCategory->update($request->validated());
        return response()->json([
            'data' => $data,
            'status' => 'true'
        ]); 
    }

    function delete(CategoryController $contactCategory) {
        
        $contactCategory->delete();
        return response()->json([
            'data' => $contactCategory,
            'status' => 'Successs delele date'
        ]);
    }
}
