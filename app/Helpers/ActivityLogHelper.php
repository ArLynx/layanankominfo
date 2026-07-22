<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogHelper
{
    public static function log(
        string $aksi,
        string $modul,
        ?string $nomorTiket = null,
        ?string $detail = null
    ): void {

        // Admin / Pimpinan / Super Admin
        if (auth('admin')->check()) {

            $admin = auth('admin')->user();

            ActivityLog::create([
                'actor_type'   => 'admin',
                'actor_id'     => $admin->id,
                'role'         => $admin->role,
                'aksi'         => $aksi,
                'modul'        => $modul,
                'nomor_tiket'  => $nomorTiket,
                'detail'       => $detail,
                'ip_address'   => request()->ip(),
            ]);

            return;
        }

        // User Pemohon
        if (auth()->check()) {

            $user = auth()->user();

            ActivityLog::create([
                'actor_type'   => 'user',
                'actor_id'     => $user->id,
                'role'         => 'user',
                'aksi'         => $aksi,
                'modul'        => $modul,
                'nomor_tiket'  => $nomorTiket,
                'detail'       => $detail,
                'ip_address'   => request()->ip(),
            ]);
        }
    }
}