<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailSatker extends Model
{
    protected $table = 'email_satkers';

    protected $fillable = [
        'user_id',
        'nama_instansi',
        'nama_akun_dinas',
        'nama_penanggung_jawab',
        'nip',
        'jabatan',
        'email_pribadi',
        'no_hp',
        'jenis_layanan',
        'nama_kadis',
        'nip_kadis',
        'karpeg',
        'formulir_email',
        'status',
        'catatan_admin',
        'nomor_tiket',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
