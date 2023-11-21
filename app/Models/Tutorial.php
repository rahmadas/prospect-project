<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;
    protected $table = 'tutorials';
    protected $fillable = [
        'title',
        'type',
        'description',
        'thumbnail',
        'video_source'
    ];

    // Append these attributes to the model's array form
    protected $appends = ['thumbnail_url', 'video_url'];

    // Accessor to get the full URL for thumbnail
    public function getThumbnailUrlAttribute()
    {
        return $this->attributes['thumbnail']
            ? asset(str_replace('public/', 'storage/', $this->attributes['thumbnail']))
            : null;
    }

    // Accessor to get the full URL for video source
    public function getVideoUrlAttribute()
    {
        return $this->attributes['type'] == '2' && $this->attributes['video_source']
            ? asset(str_replace('public/', 'storage/', $this->attributes['video_source']))
            : null;
    }
}