<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $table = 'attachments';
    protected $fillable = [
        'message_template_id',
        'file',
        'type'
    ];

    public function message_template()
    {
        return $this->belongsTo(Message_template::class);
    }
}
