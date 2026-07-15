<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if (!in_array($role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized access');
        }

        if ($role === 'superadmin') {

            // ==========================================
            // KARTU STATISTIK
            // ==========================================

            $totalAdmin = Admin::where('role', 'admin')->count();

            $totalPimpinan = Admin::where('role', 'pimpinan')->count();

            $totalUser = User::count();

            $totalAkun = Admin::count() + User::count();

            // ==========================================
            // CHART DISTRIBUSI ROLE
            // ==========================================

            $chartRole = [
                'Admin' => $totalAdmin,
                'Pimpinan' => $totalPimpinan,
                'User' => User::where('role', 'user')->count(),
            ];

            // ==========================================
            // CHART STATUS AKUN
            // ==========================================

            $totalAktif =
                Admin::where('status', 'active')->count()
                + User::where('status', 'active')->count();

            $totalNonaktif =
                Admin::where('status', 'inactive')->count()
                + User::where('status', 'inactive')->count();

            $chartStatus = [
                'Aktif' => $totalAktif,
                'Nonaktif' => $totalNonaktif,
            ];

            // ==========================================
            // ADMIN TERBARU
            // ==========================================

            $adminTerbaru = Admin::latest()
                ->take(5)
                ->get();

            // ==========================================
            // USER TERBARU
            // ==========================================

            $userTerbaru = User::latest()
                ->take(5)
                ->get();

           return view('superadmin.dashboard', compact(
                'totalAkun',
                'totalAdmin',
                'totalPimpinan',
                'totalUser',

                'chartRole',
                'chartStatus',
                
                'adminTerbaru',
                'userTerbaru',
           ));
        }

        // ==========================================
        // DASHBOARD ADMIN
        // ==========================================

        // Total Pengajuan
        $totalPengajuan =
            Subdomain::count()
            + EmailSatker::count()
            + EmailPribadi::count();

        // Pengajuan Hari Ini
        $totalHariIni =
            Subdomain::whereDate('created_at', today())->count()
            + EmailSatker::whereDate('created_at', today())->count()
            + EmailPribadi::whereDate('created_at', today())->count();

        // Sedang Diproses
        $totalDiproses =
            Subdomain::where('status', 'diproses')->count()
            + EmailSatker::where('status', 'diproses')->count()
            + EmailPribadi::where('status', 'diproses')->count();

        // Selesai
        $totalSelesai =
            Subdomain::where('status', 'selesai')->count()
            + EmailSatker::where('status', 'selesai')->count()
            + EmailPribadi::where('status', 'selesai')->count();

        // ==========================================
        // CHART
        // ==========================================

        // Jenis Layanan
        $chartJenis = [
            'Subdomain'      => Subdomain::count(),
            'Email Satker'   => EmailSatker::count(),
            'Email Pribadi'  => EmailPribadi::count(),
        ];

        // Status Pengajuan
        $chartStatus = [
            'Pengajuan' => Subdomain::where('status', 'terbuka')->count()
                            + EmailSatker::where('status', 'terbuka')->count()
                            + EmailPribadi::where('status', 'terbuka')->count(),

            'Pemeriksaan' => Subdomain::where('status', 'baru')->count()
                            + EmailSatker::where('status', 'baru')->count()
                            + EmailPribadi::where('status', 'baru')->count(),

            'Persetujuan' => Subdomain::where('status', 'tunda')->count()
                            + EmailSatker::where('status', 'tunda')->count()
                            + EmailPribadi::where('status', 'tunda')->count(),

            'Diproses' => Subdomain::where('status', 'diproses')->count()
                            + EmailSatker::where('status', 'diproses')->count()
                            + EmailPribadi::where('status', 'diproses')->count(),

            'Selesai' => Subdomain::where('status', 'selesai')->count()
                            + EmailSatker::where('status', 'selesai')->count()
                            + EmailPribadi::where('status', 'selesai')->count(),

            'Ditolak' => Subdomain::where('status', 'tutup')->count()
                            + EmailSatker::where('status', 'tutup')->count()
                            + EmailPribadi::where('status', 'tutup')->count(),
        ];

        // ==========================================
        // PENGAJUAN TERBARU
        // ==========================================

        $pengajuanTerbaru = collect();

        // Subdomain
        foreach (Subdomain::latest()->take(5)->get() as $item) {
            $pengajuanTerbaru->push([
                'nomor_tiket' => $item->nomor_tiket,
                'jenis' => 'Subdomain',
                'pemohon' => $item->nama_penanggung_jawab,
                'status' => $item->status,
                'tanggal' => $item->created_at,
            ]);
        }

        // Email Satker
        foreach (EmailSatker::latest()->take(5)->get() as $item) {
            $pengajuanTerbaru->push([
                'nomor_tiket' => $item->nomor_tiket,
                'jenis' => 'Email Satker',
                'pemohon' => $item->nama_penanggung_jawab,
                'status' => $item->status,
                'tanggal' => $item->created_at,
            ]);
        }

        // Email Pribadi
        foreach (EmailPribadi::latest()->take(5)->get() as $item) {
            $pengajuanTerbaru->push([
                'nomor_tiket' => $item->nomor_tiket,
                'jenis' => 'Email Pribadi',
                'pemohon' => $item->nama,
                'status' => $item->status,
                'tanggal' => $item->created_at,
            ]);
        }

        $pengajuanTerbaru = $pengajuanTerbaru
            ->sortByDesc('tanggal')
            ->take(5);

        return view('admin.dashboard', compact(
            'totalPengajuan',
            'totalHariIni',
            'totalDiproses',
            'totalSelesai',

            'chartJenis',
            'chartStatus',

            'pengajuanTerbaru',
        ));
    }
}
