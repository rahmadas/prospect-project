<?php

namespace App\Http\Resources\RegisterResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'first_name' => $this->first_name,
            // 'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            // 'email' => $this->email,
            // 'status' => $this->status,
            // 'referral_code' => $this->referral_code,
            // 'password' => $this->password,
            // 'foto_profile' => $this->foto_profile,
            // 'access_token' => $this->access_token,
            // 'password_confirmation' => $this->password_confirmation,
            // 'update_at' => $this->update_at,
            // 'create_at' => $this->create_at,
        ];;
    }
}
