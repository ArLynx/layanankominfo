<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Admin;
use App\Models\User;

class NotificationHelper
{
    /**
     * Kirim notifikasi ke semua Admin
     */
    public static function sendToAdmins(
        string $title,
        string $message,
        string $type,
        ?string $url = null,
        ?string $referenceType = null,
        ?int $referenceId = null
    ): void {

        $admins = Admin::all();

        foreach ($admins as $admin) {

            Notification::create([

                'recipient_type' => 'admin',
                'recipient_id' => $admin->id,

                'title' => $title,
                'message' => $message,

                'type' => $type,

                'reference_type' => $referenceType,
                'reference_id' => $referenceId,

                'url' => $url,

                'is_read' => false,

            ]);
        }
    }

    /**
     * Kirim notifikasi ke semua Superadmin
     */
    public static function sendToSuperAdmins(
        string $title,
        string $message,
        string $type,
        ?string $url = null,
        ?string $referenceType = null,
        ?int $referenceId = null
    ): void {

        $superAdmins = Admin::where('role', 'superadmin')->get();

        foreach ($superAdmins as $superAdmin) {

            Notification::create([

                'recipient_type' => 'superadmin',
                'recipient_id' => $superAdmin->id,

                'title' => $title,
                'message' => $message,

                'type' => $type,

                'reference_type' => $referenceType,
                'reference_id' => $referenceId,

                'url' => $url,

                'is_read' => false,

            ]);
        }
    }

    /**
     * Kirim notifikasi ke semua Pimpinan
     */
    public static function sendToPimpinan(
        string $title,
        string $message,
        string $type,
        ?string $url = null,
        ?string $referenceType = null,
        ?int $referenceId = null
    ): void {

        $pimpinans = User::where('role', 'pimpinan')->get();

        foreach ($pimpinans as $pimpinan) {

            Notification::create([

                'recipient_type' => 'pimpinan',
                'recipient_id' => $pimpinan->id,

                'title' => $title,
                'message' => $message,

                'type' => $type,

                'reference_type' => $referenceType,
                'reference_id' => $referenceId,

                'url' => $url,

                'is_read' => false,

            ]);
        }
    }
}