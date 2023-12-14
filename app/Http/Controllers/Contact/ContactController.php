<?php

namespace App\Http\Controllers\Contact;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactByCategoryResource;
use App\Http\Resources\ContactResource;
use App\Imports\ContactImport;
use App\Jobs\ProcessContact;
use App\Models\Contact;
use App\Models\Contact_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactsImport;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Symfony\Component\CssSelector\Node\ElementNode;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil nilai per_page dari query parameter, default 3 jika tidak ada
        $perPage = $request->perPage;

        // Mengambil query parameter "query" untuk pencarian jika diberikan
        $query = $request->$perPage;

        // Query data Contact berdasarkan kondisi
        $contacts = Contact::where('user_id', auth()->user()->id)->orderBy('user_id', 'asc');

        // Mengambil query parameter "query" untuk pencarian jika diberikan
        $query = $request->input('query', '');

        if (!empty($query)) {
            $contacts->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhere('phone_number', 'like', '%' . $query . '%')
                    ->orWhere('home_number', 'like', '%' . $query . '%')
                    ->orWhere('work_number', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            });
        }

        // Paginasi hasil query dengan custom "per_page"
        $contacts = $contacts->paginate($perPage);

        // Buat koleksi ContactResource
        return ContactResource::collection($contacts)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $contact = Contact::create($data);

        // Pemicuan job setelah menyimpan kontak
        ProcessContact::dispatch($contact);

        $contactCategory = Contact_category::create([
            'category_id' => $data['category_id'],
            'contact_id' => $contact->id
        ]);

        return (new ContactResource($contact))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Contact $contact)
    {
        return (new ContactResource($contact))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreContactRequest $request, Contact $contact)
    {
        // Validate the request data
        $data = $request->validated();

        // Update the user_id to the authenticated user's ID
        $data['user_id'] = auth()->user()->id;

        // Update the Category record with the new data
        $contact->update($data);

        return (new ContactResource($contact))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function getContactByCategory(Request $request, $categoryId)
    {
        $perPage = $request->perPage;
        $query = $request->input('query', '');

        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'status' => false
            ], 404);
        }

        // Retrieve contacts for the specified category
        $contacts = Contact::where('category_id', $categoryId);

        if (!empty($query)) {
            $contacts->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $query . '%'])
                    ->orWhereRaw('email LIKE ?', ['%' . $query . '%'])
                    ->orWhereRaw('contact_id LIKE ?', ['%' . $query . '%']);
            });
        }

        // Paginate the contacts
        $contacts = $contacts->paginate($perPage);

        // Check if there are no items in the paginated result
        if ($contacts->isEmpty()) {
            return response()->json([
                'message' => 'Data not found',
                'status' => false
            ]);
        }

        return (ContactByCategoryResource::collection($contacts))->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ]);
    }
}
