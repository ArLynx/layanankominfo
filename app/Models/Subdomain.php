<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subdomain extends Model
{
    protected $table = 'subdomains';

   protected $fillable = [
    'user_id',
    'nama_subdomain',
    'deskripsi_website',
    'nama_penanggung_jawab',
    'nip_penanggung_jawab',
    'jabatan',
    'pangkat_gol',
    'nama_instansi',
    'no_hp',
    'email',
    'jenis_layanan',
    'nama_kadis',
    'nip_kadis',
    'karpeg',
    'formulir_subdomain',
    'sk_penunjukan',
    'status',
    'nomor_tiket',
    'catatan_admin',
    'catatan_pimpinan',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
