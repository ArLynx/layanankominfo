<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestApplication;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function index()
    {
        $applications = RequestApplication::with('user')
                        ->whereIn('status', ['terbuka', 'proses', 'ditunda'])
                        ->latest()
                        ->get();

        $pendingCount = $applications->count();
        $application = $applications->first();

        return view('admin.proses', compact('applications', 'pendingCount', 'application'));
    }

    public function subdomainRequests()
    {
        $applications = RequestApplication::where('type', 'subdomain')
                        ->latest()
                        ->paginate(10);

        $totalRequests = RequestApplication::where('type', 'subdomain')->count();
        $pendingVerification = RequestApplication::where('type', 'subdomain')->where('status', 'pending')->count();
        $activeSubdomains = RequestApplication::where('type', 'subdomain')->where('status', 'approved')->count();

        return view('admin.subdomain_requests', compact('applications', 'totalRequests', 'pendingVerification', 'activeSubdomains'));
    }

    public function emailRequests()
    {
        $applications = RequestApplication::where('type', 'email')
                        ->latest()
                        ->paginate(10);

        $totalRequests = RequestApplication::where('type', 'email')->count();
        $pendingVerification = RequestApplication::where('type', 'email')->where('status', 'pending')->count();
        $activeEmails = RequestApplication::where('type', 'email')->where('status', 'approved')->count();

        return view('admin.email_requests', compact('applications', 'totalRequests', 'pendingVerification', 'activeEmails'));
    }

    public function history()
    {
        $applications = RequestApplication::latest()->paginate(10);

        return view('admin.history', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terbuka,proses,ditunda,selesai,tutup,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $application = RequestApplication::findOrFail($id);
        
        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        $message = match($request->status) {
            'terbuka' => 'Status permohonan diatur ke Terbuka.',
            'proses' => 'Permohonan sekarang sedang diproses.',
            'ditunda' => 'Permohonan telah ditunda.',
            'selesai' => 'Permohonan telah terselesaikan.',
            'tutup' => 'Permohonan telah ditutup.',
            'rejected' => 'Permohonan telah ditolak.',
            default => 'Status berhasil diperbarui.',
        };

        return redirect()->back()->with('success', $message);
    }
}
