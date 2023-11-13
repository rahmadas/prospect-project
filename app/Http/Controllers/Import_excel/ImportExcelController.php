<?php

namespace App\Http\Controllers\Import_excel;

use App\Http\Controllers\Controller;
use App\Imports\ContactImport;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Contact_category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;


class ImportExcelController extends Controller
{
    public $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    public function index()
    {
        return view('index-excel');
    }

    public function importExcel(Request $request, $category)
    {
        // dd($request->all());
        $data['user_id'] = auth()->user();
        $contact = Contact::create($data);
        $this->excel->import(new ContactImport($category), $request->file('file'));
        return redirect()->back()->with('success', 'Contacts imported successfully!');

        $contactCategory = Contact_category::create([
            'category_id' => $data['category_id'],
            'contact_id' => $contact->id
        ]);
    }
}


// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
// use ZipArchive;

// class ZipController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function __invoke()
//     {
//         $zip = new ZipArchive;

//         $fileName = 'myNewFile.zip';

//         if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
//             $files = File::files(public_path('myFiles'));

//             foreach ($files as $key => $value) {
//                 $relativeNameInZipFile = basename($value);
//                 $zip->addFile($value, $relativeNameInZipFile);
//             }

//             $zip->close();
//         }

//         return response()->download(public_path($fileName));
//     }
// }