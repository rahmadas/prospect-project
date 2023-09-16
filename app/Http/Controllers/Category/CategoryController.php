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
        $user = auth()->user();

        $category = new Category();
        $category->user_id = $request->input('user_id');
        $category->name = $request->input('name');

        //saya menggunakn $user->id untuk mencari data user, yang dimana
        // yang akan di ambil adalah nilai id
        $category->user_id = $user->id;

        $category->save();
        return new CategoryResource($category);
    }

    // public function store(CategoryRequest $request)
    // {

    //     // Mengambil data yang divalidasi dari request
    //     $data = $request->validated();
    //     // Menambahkan user_id pengguna yang sedang masuk
    //     $data['user_id'] = auth()->user()->id;
    //     $data['name'];

    //     // operasi menyisipkan data
    //     $category = Category::create($data);

    //     // Mengambil first_name dan last_name pengguna yang sedang masuk
    //     $user = auth()->user();
    //     $firstName = $user->first_name;
    //     $lastName = $user->last_name;

    //     //membuat relasi user
    //     // $category->load('user');
    //     $category->with('user');

    //     // untuk mengembalikan data dalam format json
    //     return response()->json([
    //         'data' => [
    //             'user_id' => $data['user_id'],
    //             'user_nameCategory' => $data['name'],
    //             'user_first_name' => $firstName,
    //             'user_last_name' => $lastName,
    //         ],
    //         'message' => 'Successs create date',
    //         'status' => true
    //     ]);
    // }

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
