<?php

namespace App\Http\Controllers\ContactCategory;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCategory\ContactCategoryRequest;
use App\Http\Requests\ContactCategory\StoreContactCategoryRequest;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactCategoryResource;
use App\Models\Contact;
use App\Models\Contact_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactCategoryController extends Controller
{
    public function index()
    {
        $contact_category = DB::table('contact_categories')
            ->select('contact_categories.id', 'contact_id', 'category_id', 'contacts.first_name as contact_first_name', 'categories.name as category_name')
            ->join('contacts', 'contact_categories.contact_id', '=', 'contacts.id')
            ->join('categories', 'contact_categories.category_id', '=', 'categories.id')
            ->orderBy('contact_id', 'asc')
            ->get();

        return (ContactCategoryResource::collection($contact_category))->additional([
            'message' => 'Successfully Index Date',
            'status' => true
        ]);
    }
}
