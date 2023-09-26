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
        // return parent::toArray($request);
        //   $user = $this->user;
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'contact_id' => $this->contact_id,
            // 'user_first_name' => $this->user->first_name,
            // 'user_last_name' => $this->user->last_name,
            'message_template_id' => $this->message_template_id,
            'message' => $this->message,
            'status' => $this->status

        ];
    }
}
