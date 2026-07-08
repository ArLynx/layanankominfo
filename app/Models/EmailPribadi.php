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
    'nama_instansi',

    'dokumen_akun',
    'email_sent_at',

    'email',
    'no_hp',

    'nama_akun',
    'nama_akun_baru',

    'jenis_layanan',
    'pengajuan',

    'nama_kadis',
    'jabatan_kadis', 
    'nip_kadis',

    'karpeg',
    'formulir_email',

    'status',
    'nomor_tiket',

    'catatan_admin',
    'catatan_pimpinan',

    ];

    protected $casts = [
    'email_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
