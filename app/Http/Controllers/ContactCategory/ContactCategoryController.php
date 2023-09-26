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

class ContactCategoryController extends Controller
{
    public function index()
    {
        $contact_category = Contact_category::orderBy('contact_id', 'asc')->get();
        return ContactCategoryResource::collection($contact_category);
    }
}
