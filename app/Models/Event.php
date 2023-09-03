<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'user_id',
        'title',
        'meeting_with',
        'meeting_type',
        'start_date',
        'end_date',
        'location',
        'reminder',
        'note'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
