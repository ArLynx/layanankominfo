<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\User;

class ActivityLog extends Model
{
    protected $fillable = [
        'actor_type',
        'actor_id',
        'role',
        'aksi',
        'modul',
        'nomor_tiket',
        'detail',
        'ip_address',
    ];

    /**
     * Relasi ke tabel admins
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'actor_id');
    }

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Nama aktor
     */
    public function getActorNameAttribute()
    {
        if ($this->actor_type === 'admin') {
            return $this->admin?->name ?? '-';
        }

        return $this->user?->name ?? '-';
    }
}