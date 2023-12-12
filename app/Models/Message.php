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
        'status',
        'name',
        'phone_number',
        'attachment'
    ];

    public function message_template()
    {
        return $this->belongsTo(Message_template::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function contact_message()
    {
        return $this->hasMany(Contact_message::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
