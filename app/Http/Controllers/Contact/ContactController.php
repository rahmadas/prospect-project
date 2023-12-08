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

    function destroy(Contact $contact)
    {
        // Delete the Category record
        $contact->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }

    function getContactByCategory(Request $request, $categoryId)
    {
        $perPage = $request->perPage;
        $query = $request->input('query', '');

        $contactByCategories = Contact::orderBy('user_id', 'asc');

        if (!empty($query)) {
            $contactByCategories->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $query . '%']);
            });
        }

        $contactByCategories = $contactByCategories->paginate($perPage);

        $contacts = $contactByCategories->map(function ($contact) use ($categoryId) {
            $category = Category::find($categoryId);

            return (object)[
                'id' => $contact->id,
                'user_id' => $contact->user_id,
                'user_first_name' => $contact->user->first_name,
                'user_last_name' => $contact->user->last_name,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'phone_number' => $contact->phone_number,
                'home_number' => $contact->home_number,
                'work_number' => $contact->work_number,
                'email' => $contact->email,
                'category_id' => $categoryId, // Assuming you want to set a fixed category ID
                'category_name' => $category ? $category->name : null, // Replace with the actual category name
            ];
        });

        return (ContactByCategoryResource::collection($contacts))->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ]);
    }
}
