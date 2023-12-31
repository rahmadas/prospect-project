<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Contact_category;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->perPage;
        $categories = Category::where('user_id', auth()->user()->id)->orderBy('user_id', 'asc');

        // get query parameter for search
        $query = $request->input('query', '');

        if (!empty($query)) {
            $categories->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            });
        }

        $categories = $categories->paginate($perPage);

        return CategoryResource::collection($categories)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {

        // Mengambil data yang divalidasi dari request
        $data = $request->validated();
        // Menambahkan user_id pengguna yang sedang masuk
        $data['user_id'] = auth()->user()->id;

        //     // operasi menyisipkan data
        $category = Category::create($data);
        return (new CategoryResource($category))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Category $category)
    {
        return (new CategoryResource($category))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreCategoryRequest $request, $category)
    {
        $category = Category::findOrFail($category);

        // Validate the request data
        $data = $request->validated();

        // Update the user_id to the authenticated user's ID
        $data['user_id'] = auth()->user()->id;

        // Update the Category record with the new data
        $category->update($data);

        return (new CategoryResource($category))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy($category)
    {

        // karena di dalam methode update tidak ada model Contact
        // Find the Category record by its ID
        $category = Category::findOrFail($category);

        // Delete the Category record
        $category->delete();

        // Return a response indicating success or appropriate error handling
        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }
}
