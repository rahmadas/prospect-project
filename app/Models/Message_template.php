<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_template extends Model
{
    use HasFactory;
    protected $table = 'message_templates';
    protected $fillable = [
        'user_id',
        'title',
        'message'
    ]; 

    public function message() {
        return $this->hasMany(Message::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
