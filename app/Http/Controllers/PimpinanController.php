<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PimpinanController extends Controller
{
    public function index()
    {
        $subdomains = Subdomain::with('user')
            ->whereIn('status', ['terbuka', 'baru', 'tunda', 'diproses', 'selesai', 'tutup'])
            ->latest()
            ->get();

        $stats = [
            'total' => Subdomain::count(),
            'terbuka' => Subdomain::where('status', 'terbuka')->count(),
            'baru' => Subdomain::where('status', 'baru')->count(),
            'tunda' => Subdomain::where('status', 'tunda')->count(),
            'diproses' => Subdomain::where('status', 'diproses')->count(),
            'selesai' => Subdomain::where('status', 'selesai')->count(),
            'tutup' => Subdomain::where('status', 'tutup')->count(),
        ];

        return view('pimpinan.dashboard', compact('subdomains', 'stats'));
    }

    public function subdomainList()
    {
        $subdomains = Subdomain::with('user')
            ->latest()
            ->paginate(15);

        return view('pimpinan.subdomain-list', compact('subdomains'));
    }

    public function approvalList()
    {
        $subdomains = Subdomain::with('user')
            ->where('status', 'tunda')
            ->latest()
            ->paginate(15);

        return view('pimpinan.approval-list', compact('subdomains'));
    }

    public function approvalShow(Subdomain $subdomain)
    {
        return view('pimpinan.approval-show', compact('subdomain'));
    }

    public function showDetail(Subdomain $subdomain)
    {
        return view('pimpinan.subdomain-detail', compact('subdomain'));
    }

    public function approve(Request $request, Subdomain $subdomain)
    {
        $request->validate([
            'catatan_pimpinan' => 'nullable|string|max:1000',
        ]);

        $subdomain->update([
            'status' => 'diproses',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        return redirect()->route('pimpinan.approval-list')
            ->with('success', 'Pengajuan subdomain berhasil disetujui.');
    }

    public function reject(Request $request, Subdomain $subdomain)
    {
        $request->validate([
            'catatan_pimpinan' => 'required|string|max:1000',
        ], [
            'catatan_pimpinan.required' => 'Catatan pimpinan wajib diisi saat menolak pengajuan.',
        ]);

        $subdomain->update([
            'status' => 'tutup',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        return redirect()->route('pimpinan.approval-list')
            ->with('success', 'Pengajuan subdomain ditolak.');
    }

    public function viewFormulir(Subdomain $subdomain)
    {
        if (empty($subdomain->formulir_subdomain)) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($subdomain->formulir_subdomain)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($subdomain->formulir_subdomain));
    }
}
