<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $fillable = [
        'contact_id',
        'note',
        'date'
    ];

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
