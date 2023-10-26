<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
