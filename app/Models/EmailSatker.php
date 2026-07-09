<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailSatker extends Model
{
    use HasFactory;

    protected $table = 'email_satkers';

        protected $fillable = [

        'user_id',

        'nama_instansi',
        'dokumen_akun',
        'email_sent_at',

        'nama_penanggung_jawab',
        'nip',
        'jabatan',
        'pangkat_gol',
        'email',
        'no_hp',

        'nama_penanggung_jawab_baru',
        'nip_baru',
        'jabatan_baru',
        'pangkat_gol_baru',
        'email_baru',
        'no_hp_baru',

        'nama_akun_dinas',
        'nama_akun_dinas_baru',

        'jenis_layanan',

        'nama_kadis',
        'jabatan_kadis',
        'nip_kadis',

        'karpeg',
        'formulir_email',

        'status',
        'catatan_admin',
        'catatan_pimpinan',

        'nomor_tiket',

    ];

    protected $casts = [
    'email_sent_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
