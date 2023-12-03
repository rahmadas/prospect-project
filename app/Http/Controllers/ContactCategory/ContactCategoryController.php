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
    public function getContactCategoryByCategory($categoryId)
    {
        $contacts = DB::table('contacts')
            ->select(
                'contacts.id',
                'contacts.first_name',
                'contacts.last_name',
                'contacts.phone_number',
                'contacts.home_number',
                'contacts.work_number',
                'contacts.email',
                'contact_categories.id as contact_category_id',
                'categories.name as category_name'
            )
            ->join('contact_categories', 'contacts.id', '=', 'contact_categories.contact_id')
            ->join('categories', 'contact_categories.category_id', '=', 'categories.id')
            ->where('contact_categories.category_id', $categoryId)
            ->get();


        return (ContactCategoryResource::collection($contacts))->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ]);
    }
}