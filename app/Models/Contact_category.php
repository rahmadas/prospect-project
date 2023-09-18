<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_category extends Model
{
    use HasFactory;
    protected $table = 'contact_categories';
    protected $fillable = [
        'category_id',
        'contact_id'
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function contact()
    {
        return $this->belongsToMany(Contact::class);
    }
}
