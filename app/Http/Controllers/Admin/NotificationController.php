<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function read(Notification $notification)
    {
        // Pastikan hanya penerima yang boleh membuka
        if ($notification->recipient_type !== auth()->user()->role || $notification->recipient_id != auth()->id()) {
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

    public function index(Request $request)
    {
        $notifications = Notification::where('recipient_type', auth()->user()->role)
            ->where('recipient_id', auth()->id())
            ->latest();

        // Search
        if ($request->filled('search')) {
            $notifications->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        // Filter
        if ($request->status == 'unread') {
            $notifications->where('is_read', false);
        }

        if ($request->status == 'read') {
            $notifications->where('is_read', true);
        }

        $notifications = $notifications->paginate(10);

        return view('admin.notifications', compact('notifications'));
    }
}
