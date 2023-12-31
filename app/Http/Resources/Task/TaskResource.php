<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'user_first_name' => $this->user->first_name,
            'user_last_name' => $this->user->last_name,
            'title' => $this->title,
            'note' => $this->note,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'priority' => $this->priority,
            'reminder' => $this->reminder,
            'status' => $this->status,
            'contact_id' => $this->contact->id,
            'first_name' => $this->contact->first_name,
            'last_name' => $this->contact->last_name,
            'full_name' => $this->contact->first_name . ' ' . $this->contact->last_name,
            'phone_number' => $this->contact->phone_number,
            'home_number' => $this->contact->home_number,
            'work_number' => $this->contact->work_number,
            'email' => $this->contact->email,
        ];
    }
}
