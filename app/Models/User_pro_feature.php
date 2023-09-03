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

    public function user() {
        return $this->belongsToMany(User::class);
    }
    
    public function pro_feature() {
        return $this->belongsToMany(Pro_feature::class);
    }

}
