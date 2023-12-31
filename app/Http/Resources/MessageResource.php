<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->message_template->attachments);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'user_first_name' => $this->user->first_name,
            // 'user_last_name' => $this->user->last_name,
            'message_template_id' => $this->message_template_id,
            'name_message_template' => $this->name,
            'phone_number_message_template' => $this->phone_number,
            'message' => $this->message,
            'status' => $this->status,
            'attachment' => $this->message_template->attachment
        ];
    }
}
