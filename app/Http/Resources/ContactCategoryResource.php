<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contact_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'phone_number' => $this->phone_number,
            'home_number' => $this->home_number,
            'work_number' => $this->work_number,
            'email' => $this->email,
            'contact_category_id' => $this->contact_category->contact_category_id,
            'category_name' => $this->category_name,
        ];
    }
}