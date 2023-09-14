<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'data' => $category,
            'status' => 'true'
        ]);
    }

    public function store(CategoryRequest $request)
    {

        // Mengambil data yang divalidasi dari request
        $data = $request->validated();
        // Menambahkan user_id pengguna yang sedang masuk
        $data['user_id'] = auth()->user()->id;

        // operasi menyisipkan data
        $category = Category::create($data);

        // Mengambil first_name dan last_name pengguna yang sedang masuk
        $user = auth()->user();
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //membuat relasi user
        // $category->load('user');
        $category->with('user');

        // Membuat artikel baru dan mengaitkannya dengan pengguna (penulis)
        // $category = new Category([
        //     'user_first_name' => $data['user_id'],
        //     // 'user_last_name' => $data[''],
        //     'user_id' => $user, // Mengaitkan artikel dengan ID pengguna yang saat ini login
        // ]);

        // untuk mengembalikan data dalam format json
        return response()->json([
            'data' => new CategoryResource($category),
            'user_first_name' => $firstName,
            'user_last_name' => $lastName,
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
