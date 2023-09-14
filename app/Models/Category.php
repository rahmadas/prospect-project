<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function contact_category()
    {
        return $this->hasMany(Contact_category::class);
    }

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    // public function getUsers()
    // {
    //     return $this->user;
    // }

    // Route::get('/user/{id}', function (string $id) {
    //     return new CategoryResource(User::findOrFail($id));
    // });
}
