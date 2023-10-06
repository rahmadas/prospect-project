<?php

namespace App\Http\Controllers\phonebook;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneBook\StorePhoneBookRequest;
use App\Http\Resources\PhoneBook\PhoneBookResource;
use App\Models\PhoneBook;
use Illuminate\Http\Request;

class PhoneBookController extends Controller
{
    public function importPhoneBook(StorePhoneBookRequest $request)
    {
        // // Validasi file yang diunggah
        // $request->validate([
        //     'phone_book_csv' => 'required|file|mimes:csv,txt',
        // ]);

        // Proses impor data buku telepon
        // Contoh: Baca file CSV dan simpan data ke dalam database
        $path = $request->file('phone_book_csv')->getRealPath();

        $data = array_map('str_getcsv', file($path));
        unset($data[0]); // Untuk menghapus header jika ada

        $phoneBook = PhoneBook::create($data);

        return PhoneBookResource::collection($phoneBook)->additional([
            'status' => 'Successfully imported phone book data'
        ], 200);

        // return response()->json([
        //     'status' => 'Successfully imported phone book data'
        // ], 200);
    }
}
