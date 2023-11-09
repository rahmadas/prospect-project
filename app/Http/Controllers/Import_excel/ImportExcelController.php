<?php

namespace App\Http\Controllers\Import_excel;

use App\Http\Controllers\Controller;
use App\Imports\ContactImport;
use App\Models\Category;
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

    public function import_excel(Request $request, $category)
    {
        $this->excel->import(new ContactImport($category), request()->file('file'));
        return redirect()->back()->with('success', 'Contacts imported successfully!');
    }
}
