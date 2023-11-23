<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
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
            'contact_id' => $this->id,
            'contact_name' => $this->contact_name,
            'contact_message_id' => $this->contact_message_id,
            'message_name' => $this->message_name
        ];
    }
}
