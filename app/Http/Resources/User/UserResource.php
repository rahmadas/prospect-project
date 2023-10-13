<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userFullName = $this->first_name . ' ' . $this->last_name;
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_full_name' => $userFullName,
            // 'user_full_name' => $this->first_name,
            // 'user_last_name' => $this->last_name,
        ];
    }
}