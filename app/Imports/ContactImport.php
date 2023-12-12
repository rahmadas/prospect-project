<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Contact_category;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;


class ContactImport implements ToCollection
{

    public function __construct(public $category)
    {
        $this->category = $category;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $contact = Contact::create([
                'user_id' => $row[0],
                'first_name' => $row[1],
                'last_name' => $row[2],
                'phone_number' => $row[3],
                'home_number' => $row[4],
                'work_number' => $row[5],
                'email' => $row[6],
            ]);
            $contactCategory = Contact_category::create([
                'category_id' => $this->category,
                'contact_id' => $contact->id,
            ]);
        }
    }
}
