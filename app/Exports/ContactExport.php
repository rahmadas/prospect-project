<?php

namespace App\Exports;

use App\Models\Contact;
use App\Models\Contact_category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactExport implements FromCollection
{

    public function __construct(public $category)
    {
        // $this->category = $category;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        // return $this->category;
    }
}