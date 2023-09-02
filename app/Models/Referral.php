<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;
    protected $table = 'referrals';
    protected $fillable = [

        'user_id',
        'invited_id',
        'date'
    ];

    public function user() 
    {
        return $this->belongsTo(Users::class);
    }

    public function invited() {
        return $this->hasOne(User::class);
    }
}
