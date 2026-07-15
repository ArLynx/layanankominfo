<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function read(Notification $notification)
    {
        // Pastikan hanya penerima yang boleh membuka
        if (
            $notification->recipient_type !== auth()->user()->role ||
            $notification->recipient_id != auth()->id()
        ) {
            abort(403);
        }

        // Tandai sudah dibaca
        if (!$notification->is_read) {

            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        // Redirect ke halaman tujuan
        return redirect($notification->url);
    }
}