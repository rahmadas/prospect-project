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
        $contacts = Contact::orderBy('user_id', 'asc');

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

    function getContactByCategory($categoryId)
    {
        $contacts = DB::table('contacts')
            ->select('contacts.id', DB::raw("CONCAT(contacts.first_name, ' ', contacts.last_name) as full_name"), 'categories.id as category_id', 'categories.name as category_name')
            ->join('contact_categories', 'contacts.id', '=', 'contact_categories.contact_id')
            ->join('categories', 'contact_categories.category_id', '=', 'categories.id')
            ->where('contact_categories.category_id', $categoryId)
            ->get();

        return (ContactByCategoryResource::collection($contacts))->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ]);
    }
}
