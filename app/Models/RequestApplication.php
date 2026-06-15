<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestApplication extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'details',
        'reason',
        'document_path',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
