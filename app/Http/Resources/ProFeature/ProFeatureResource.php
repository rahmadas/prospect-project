<?php

namespace App\Http\Resources\ProFeature;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProFeatureResource extends JsonResource
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
            // 'user_first_name' => $this->user->first_name,
            // 'user_last_name' => $this->user->last_name,
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}