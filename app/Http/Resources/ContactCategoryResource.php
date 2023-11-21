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
            'contact_id' => $this->id,
            'contact_name' => $this->contact_first_name,
            'contact_category_id' => $this->contact_category_id,
            'category_name' => $this->category_name,
        ];
    }
}