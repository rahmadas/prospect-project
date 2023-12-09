<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactByCategoryResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_first_name' => $this->first_name,
            'user_last_name' => $this->last_name,
            'contact_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'phone_number' => $this->phone_number,
            'home_number' => $this->home_number,
            'work_number' => $this->work_number,
            'email' => $this->email,
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
        ];
    }
}