<?php

namespace App\Http\Controllers\Import_excel;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ImportExcelController extends Controller
{
    public function index()
    {
        $importExcel = Contact::all();
        return response()->json([
            'data' => $importExcel,
            'message' => 'Success index Data',
            'status' => true
        ]);
    }

    public function importExcel()
    {
        return Excel::download(new ContactExport, 'contact.xlsx');
    }
}
