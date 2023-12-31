<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_message extends Model
{
    use HasFactory;
    protected $table = 'contact_messages';
    protected $fillable = [
        'contact_id',
        'message_id'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function contact()
    {
        return $this->belongsToMany(Contact::class);
    }
}
