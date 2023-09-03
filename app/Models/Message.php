<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = [
        'user_id',
        'message_template_id',
        'message',
        'status'
    ];

    public function contact_message() {
        return $this->hasOne(Contact_massage::class);
    }

    public function message_template() {
        return $this->belongsToMany(Message_template::class);
    }

    public function user() {
        return $this->belongsToMany(User::class);
    }
}
