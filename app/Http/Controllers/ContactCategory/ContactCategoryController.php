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
    public function getContactCategoryByCategory(Request $request, $categoryId)
    {
        $perPage = $request->perPage;
        // $query = $request->input('query', '');

        $category = Contact_category::find($categoryId);

        $contact_categories = DB::table('contact_categories')
            ->select(
                'contact_categories.id as id',
                'contacts.id as contact_id',
                'contacts.first_name',
                'contacts.last_name',
                'contacts.phone_number',
                'contacts.home_number',
                'contacts.work_number',
                'contacts.email',
                'categories.id as cotegory_id',
                'categories.name as category_name'
            )
            ->join('categories', 'contact_categories.category_id', '=', 'categories.id')
            ->join('contacts', 'contact_categories.contact_id', '=', 'contacts.id')
            ->where('categories.id', $categoryId)
            ->get();

        $contact_categories = Contact::where('category_id', $categoryId);

        // if (!empty($query)) {
        //     $contact_categories->where(function ($queryBuilder) use ($query) {
        //         $queryBuilder->where('first_name', 'like', '%' . $query . '%')
        //             ->orWhere('last_name', 'like', '%' . $query . '%')
        //             ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $query . '%'])
        //             ->orWhere('email', 'like', '%' . $query . '%');
        //     });
        // }

        // Paginate the contacts
        $contact_categories = $contact_categories->paginate($perPage);

        // // Check if there are no items in the paginated result
        // if ($contact_categories->isEmpty()) {
        //     return response()->json([
        //         'message' => 'Data not found',
        //         'status' => false
        //     ]);
        // }

        return response()->json([
            'status' => true,
            'message' => 'Successfully Index Data',
            'data' => $contact_categories,
        ]);
    }
}
