<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'user_id',
        'title',
        'note',
        'due_date',
        'due_time',
        'priority',
        'reminder',
        'status',
        'relate_to'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
