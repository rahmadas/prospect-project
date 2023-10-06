<?php

namespace App\Http\Resources\PhoneBook;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'phone_book_csv' => $this->phone_book_csv,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
        ];
    }
}
