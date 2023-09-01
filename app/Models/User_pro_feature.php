<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_pro_feature extends Model
{
    use HasFactory;
    protected $table = 'user_pro_feature';
    protected $fillable = [
        'user_id',
        'pro_feature_id'
    ];
}
