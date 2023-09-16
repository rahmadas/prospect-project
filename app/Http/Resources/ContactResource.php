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
        return parent::toArray($request);
        return [
            'user_id' => $this->user_id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'phoneNumber' => $this->phone_number,
            'homeNumber' => $this->home_number,
            'workNumber' => $this->work_number,
            'email' => $this->email,

        ];
    }
}
