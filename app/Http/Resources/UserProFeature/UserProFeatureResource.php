<?php

namespace App\Http\Resources\UserProFeature;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProFeatureResource extends JsonResource
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
            'pro_feature_id' => $this->pro_feature_id
        ];
    }
}
