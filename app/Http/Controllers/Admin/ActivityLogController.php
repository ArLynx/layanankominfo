<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with(['admin', 'user'])

            ->when($request->search, function ($q) use ($request) {

                $q->where('aksi', 'like', "%{$request->search}%")
                    ->orWhere('detail', 'like', "%{$request->search}%")
                    ->orWhere('nomor_tiket', 'like', "%{$request->search}%");

            })

            ->when($request->role, function ($q) use ($request) {

                $q->where('role', $request->role);

            })

            ->when($request->modul, function ($q) use ($request) {

                $q->where('modul', $request->modul);

            })

            ->oldest()

            ->paginate(15);

        return view('superadmin.activity-logs', compact('logs'));
    }
}