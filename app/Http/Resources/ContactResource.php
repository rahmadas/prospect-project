<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'user_first_name' => $this->user->first_name,
            'user_last_name' => $this->user->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'phoneNumber' => $this->phone_number,
            'homeNumber' => $this->home_number,
            'workNumber' => $this->work_number,
            'email' => $this->email,

        ];
    }
}
