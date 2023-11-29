<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'home_number',
        'work_number',
        'email'
    ];

    // public function contactCategories()
    // {
    //     return $this->belongsToMany(ContactCategory::class, 'contact_contact_category');
    // }

    public function contact_category()
    {
        return $this->belongsToMany(Contact_category::class);
    }

    public function note()
    {
        return $this->hasMany(Note::class);
    }

    public function contact_message()
    {
        return $this->hasMany(Contact_massage::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
