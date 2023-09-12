<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $category = Category::all();
        return response()->json([
            'data' => $category,
            'status' => 'true'
        ]);
    }

    public function store(CategoryRequest $request)
    {
        //
        $data = $request->validated();

        $category = Category::create($data);

        return response()->json([
            'data' => $category,
            'status' => 'true'
        ]);
    }

    function show(Category $category)
    { 
        return response()->json([
            'data' => $category,
            'status' => 'true'
        ]);
    }

    function update(CategoryRequest $request, Category $category)
    {
        $data = $category->update($request->validated());
        return response()->json([
            'data' => $data,
            'status' => 'true'
        ]);
    }

    function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => true
        ]);
    }
}
