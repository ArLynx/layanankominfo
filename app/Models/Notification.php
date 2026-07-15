<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [

        'recipient_type',
        'recipient_id',

        'title',
        'message',

        'type',

        'reference_type',
        'reference_id',

        'url',

        'is_read',

        'read_at',
    ];

    protected $casts = [

        'is_read' => 'boolean',

        'read_at' => 'datetime',

    ];
}
