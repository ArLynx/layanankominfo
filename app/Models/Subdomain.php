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
    'nama_subdomain_baru',
    'deskripsi_website',
    'nama_penanggung_jawab',
    'nama_penanggung_jawab_baru',
    'nip_penanggung_jawab',
    'nip_penanggung_jawab_baru',
    'jabatan',
    'jabatan_baru',
    'pangkat_gol',
    'pangkat_gol_baru',
    'nama_instansi',
    'no_hp',
    'no_hp_baru',
    'email',
    'email_baru',
    'jenis_layanan',
    'nama_kadis',
    'nip_kadis',
    'jabatan_kadis',
    'karpeg',
    'formulir_subdomain',
    'surat_penunjukan',
    'status',
    'nomor_tiket',
    'catatan_admin',
    'catatan_pimpinan',
    'surat_penunjukan_lama',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
