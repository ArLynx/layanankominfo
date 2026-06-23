<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailPribadi extends Model
{
    protected $table = 'email_pribadis';

    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'jabatan',
        'pangkat_gol',
        'instansi',
        'email',
        'no_hp',
        'nama_akun',
        'jenis_layanan',
        'pengajuan',
        'nama_kadis',
        'nip_kadis',
        'karpeg',
        'status',
        'catatan_admin',
        'nomor_tiket',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
