<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Imports\ContactImport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name'];
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'referral_code',
        'password',
        'status',
        'expired_at',
        'foto_profile'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function User_pro_feature()
    {
        return $this->hasMany(User_pro_feature::class);
    }

    public function referral()
    {
        return $this->hasMany(Referral::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function message_template()
    {
        return $this->belongsTo(Message_template::class);
    }

    public function phone_book()
    {
        return $this->hasMany(PhoneBook::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
