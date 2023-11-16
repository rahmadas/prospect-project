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
}
