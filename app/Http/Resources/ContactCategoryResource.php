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
            'contact_id' => $this->contact_id,
            'contact' => [
                'id' => $this->contact_id,
                'first_name' => $this->contact_first_name,
            ],
            'category_id' => $this->category_id,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category_name,
            ],
        ];
    }
}
