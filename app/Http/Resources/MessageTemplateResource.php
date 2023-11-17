<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageTemplateResource extends JsonResource
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
            'user_id' => $this->user_id,
            // 'message_template_id' => $this->message->message_template_id,
            'user_first_name' => $this->user->first_name,
            'user_last_name' => $this->user->last_name,
            'title' => $this->title,
            'message' => $this->message,
            'attachment' => $this->attachment
        ];
    }
}
