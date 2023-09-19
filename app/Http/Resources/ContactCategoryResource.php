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
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'category_id' => $this->category_id,
            // 'user_first_name' => $this->user->first_name,
            // 'user_last_name' => $this->user->last_name,

        ];
    }
}
