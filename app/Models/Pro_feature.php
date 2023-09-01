<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pro_feature extends Model
{
    use HasFactory;
    protected $table = 'pro_features';
    protected $fillable = [
        'name',
        'description'
    ]; 
}
