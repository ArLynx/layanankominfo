<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class PimpinanNotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('recipient_type', 'pimpinan')
            ->where('recipient_id', auth()->id());

        if ($request->filled('search')) {

            $notifications->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');

            });

        }

        if ($request->status == 'unread') {
            $notifications->where('is_read', false);
        }

        if ($request->status == 'read') {
            $notifications->where('is_read', true);
        }

        $notifications = $notifications
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pimpinan.notifications', compact('notifications'));
    }

    public function read(Notification $notification)
    {
        abort_unless(
            $notification->recipient_type === 'pimpinan'
            && $notification->recipient_id == auth()->id(),
            403
        );

        if (!$notification->is_read) {

            $notification->update([

                'is_read' => true,

                'read_at' => now(),

            ]);

        }

        return redirect($notification->url);
    }
}