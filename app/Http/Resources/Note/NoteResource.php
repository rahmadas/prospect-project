<?php

namespace App\Http\Resources\Note;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
            'contact_name' => $this->contact->first_name . ' ' . $this->contact->last_name,
            'phone_number' => $this->contact->phone_number,
            'home_number' => $this->contact->home_number,
            'work_number' => $this->contact->work_number,
            'email' => $this->contact->email,
            'note' => $this->note,
            'date' => $this->date
        ];
    }
}
