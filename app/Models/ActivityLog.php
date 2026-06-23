<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'aksi', 'modul', 'nomor_tiket', 'ip_address', 'detail'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
