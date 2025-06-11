<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'response',
        'is_from_user',
        'session_id'
    ];

    protected $casts = [
        'is_from_user' => 'boolean',
    ];
} 