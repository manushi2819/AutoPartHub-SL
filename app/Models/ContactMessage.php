<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'reply_comment',
        'is_replied',
        'replied_at',
    ];

     protected $casts = [
        'is_replied' => 'boolean',
        'replied_at' => 'datetime', 
    ];
}
