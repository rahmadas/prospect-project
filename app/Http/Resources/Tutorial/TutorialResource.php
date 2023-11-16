<?php

namespace App\Http\Resources\Tutorial;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Generate URLs for thumbnail and video (if exists)
        $thumbnailUrl = $this->type == '2' && $this->thumbnail
            ? asset(str_replace('public/', 'storage/', $this->thumbnail))
            : null;

        $videoUrl = $this->type == '2' && $this->video_source
            ? asset(str_replace('public/', 'storage/', $this->video_source))
            : null;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'thumbnail_url' => $thumbnailUrl,
            'video_url' => $videoUrl,
        ];
    }
}
