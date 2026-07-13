<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // FILTER
        // ==========================================

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;
        $jenis = $request->jenis;

        // ==========================================
        // CARD RINGKASAN
        // ==========================================

        $subdomain = Subdomain::query();

        if ($tanggalAwal) {
            $subdomain->whereDate('created_at', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $subdomain->whereDate('created_at', '<=', $tanggalAkhir);
        }

        $emailSatker = EmailSatker::query();

        if ($tanggalAwal) {
            $emailSatker->whereDate('created_at', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $emailSatker->whereDate('created_at', '<=', $tanggalAkhir);
        }

        $emailPribadi = EmailPribadi::query();

        if ($tanggalAwal) {
            $emailPribadi->whereDate('created_at', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $emailPribadi->whereDate('created_at', '<=', $tanggalAkhir);
        }

        // ==========================================
        // TAB RINGKASAN
        // ==========================================

        switch ($jenis) {
            case 'subdomain':
                $emailSatker->whereRaw('1=0');
                $emailPribadi->whereRaw('1=0');
                break;

            case 'email_satker':
                $subdomain->whereRaw('1=0');
                $emailPribadi->whereRaw('1=0');
                break;

            case 'email_pribadi':
                $subdomain->whereRaw('1=0');
                $emailSatker->whereRaw('1=0');
                break;
        }

        // ==========================
        // CARD
        // ==========================

        $totalPengajuan = (clone $subdomain)->count() + (clone $emailSatker)->count() + (clone $emailPribadi)->count();

        $totalSelesai = (clone $subdomain)->where('status', 'selesai')->count() + (clone $emailSatker)->where('status', 'selesai')->count() + (clone $emailPribadi)->where('status', 'selesai')->count();

        $totalDiproses = (clone $subdomain)->where('status', 'diproses')->count() + (clone $emailSatker)->where('status', 'diproses')->count() + (clone $emailPribadi)->where('status', 'diproses')->count();

        $totalDitolak = (clone $subdomain)->where('status', 'tutup')->count() + (clone $emailSatker)->where('status', 'tutup')->count() + (clone $emailPribadi)->where('status', 'tutup')->count();

        // ==========================
        // REKAP JENIS
        // ==========================

        $rekapJenis = [
            'subdomain' => (clone $subdomain)->count(),

            'email_satker' => (clone $emailSatker)->count(),

            'email_pribadi' => (clone $emailPribadi)->count(),
        ];

        $totalJenis = array_sum($rekapJenis);

        $rekapStatus = [
            'terbuka' => (clone $subdomain)->where('status', 'terbuka')->count() + (clone $emailSatker)->where('status', 'terbuka')->count() + (clone $emailPribadi)->where('status', 'terbuka')->count(),

            'baru' => (clone $subdomain)->where('status', 'baru')->count() + (clone $emailSatker)->where('status', 'baru')->count() + (clone $emailPribadi)->where('status', 'baru')->count(),

            'tunda' => (clone $subdomain)->where('status', 'tunda')->count() + (clone $emailSatker)->where('status', 'tunda')->count() + (clone $emailPribadi)->where('status', 'tunda')->count(),

            'diproses' => (clone $subdomain)->where('status', 'diproses')->count() + (clone $emailSatker)->where('status', 'diproses')->count() + (clone $emailPribadi)->where('status', 'diproses')->count(),

            'selesai' => (clone $subdomain)->where('status', 'selesai')->count() + (clone $emailSatker)->where('status', 'selesai')->count() + (clone $emailPribadi)->where('status', 'selesai')->count(),

            'tutup' => (clone $subdomain)->where('status', 'tutup')->count() + (clone $emailSatker)->where('status', 'tutup')->count() + (clone $emailPribadi)->where('status', 'tutup')->count(),
        ];

        $totalStatus = array_sum($rekapStatus);

        // ==========================================
        // CHART
        // ==========================================

        $chartJenis = [
            'Subdomain' => $rekapJenis['subdomain'],
            'Email Satker' => $rekapJenis['email_satker'],
            'Email Pribadi' => $rekapJenis['email_pribadi'],
        ];

        $chartStatus = [
            'Pengajuan' => $rekapStatus['terbuka'],
            'Pemeriksaan Dokumen' => $rekapStatus['baru'],
            'Diproses' => $rekapStatus['diproses'],
            'Persetujuan' => $rekapStatus['tunda'],
            'Selesai' => $rekapStatus['selesai'],
            'Ditolak' => $rekapStatus['tutup'],
        ];

        return view('admin.laporan', compact('totalPengajuan', 'totalSelesai', 'totalDiproses', 'totalDitolak', 'rekapJenis', 'rekapStatus', 'totalJenis', 'totalStatus', 'chartJenis', 'chartStatus'));
    }

    public function exportPdf(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;
        $jenis = $request->jenis;

        // ==========================
        // QUERY
        // ==========================

        $subdomain = Subdomain::query();
        $emailSatker = EmailSatker::query();
        $emailPribadi = EmailPribadi::query();

        if ($tanggalAwal) {
            $subdomain->whereDate('created_at', '>=', $tanggalAwal);
            $emailSatker->whereDate('created_at', '>=', $tanggalAwal);
            $emailPribadi->whereDate('created_at', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $subdomain->whereDate('created_at', '<=', $tanggalAkhir);
            $emailSatker->whereDate('created_at', '<=', $tanggalAkhir);
            $emailPribadi->whereDate('created_at', '<=', $tanggalAkhir);
        }

        switch ($jenis) {
            case 'subdomain':
                $emailSatker->whereRaw('1=0');
                $emailPribadi->whereRaw('1=0');
                break;

            case 'email_satker':
                $subdomain->whereRaw('1=0');
                $emailPribadi->whereRaw('1=0');
                break;

            case 'email_pribadi':
                $subdomain->whereRaw('1=0');
                $emailSatker->whereRaw('1=0');
                break;
        }

        // ==========================
        // DATA
        // ==========================

        $totalPengajuan = (clone $subdomain)->count() + (clone $emailSatker)->count() + (clone $emailPribadi)->count();

        $totalSelesai = (clone $subdomain)->where('status', 'selesai')->count() + (clone $emailSatker)->where('status', 'selesai')->count() + (clone $emailPribadi)->where('status', 'selesai')->count();

        $totalDiproses = (clone $subdomain)->where('status', 'diproses')->count() + (clone $emailSatker)->where('status', 'diproses')->count() + (clone $emailPribadi)->where('status', 'diproses')->count();

        $totalDitolak = (clone $subdomain)->where('status', 'tutup')->count() + (clone $emailSatker)->where('status', 'tutup')->count() + (clone $emailPribadi)->where('status', 'tutup')->count();

        $rekapJenis = [
            'Subdomain' => (clone $subdomain)->count(),
            'Email Satker' => (clone $emailSatker)->count(),
            'Email Pribadi' => (clone $emailPribadi)->count(),
        ];

        $rekapStatus = [
            'Pengajuan' => (clone $subdomain)->where('status', 'terbuka')->count() + (clone $emailSatker)->where('status', 'terbuka')->count() + (clone $emailPribadi)->where('status', 'terbuka')->count(),

            'Pemeriksaan Dokumen' => (clone $subdomain)->where('status', 'baru')->count() + (clone $emailSatker)->where('status', 'baru')->count() + (clone $emailPribadi)->where('status', 'baru')->count(),

            'Persetujuan Pimpinan' => (clone $subdomain)->where('status', 'tunda')->count() + (clone $emailSatker)->where('status', 'tunda')->count() + (clone $emailPribadi)->where('status', 'tunda')->count(),

            'Proses Pembuatan' => (clone $subdomain)->where('status', 'diproses')->count() + (clone $emailSatker)->where('status', 'diproses')->count() + (clone $emailPribadi)->where('status', 'diproses')->count(),

            'Selesai' => (clone $subdomain)->where('status', 'selesai')->count() + (clone $emailSatker)->where('status', 'selesai')->count() + (clone $emailPribadi)->where('status', 'selesai')->count(),

            'Ditolak' => (clone $subdomain)->where('status', 'tutup')->count() + (clone $emailSatker)->where('status', 'tutup')->count() + (clone $emailPribadi)->where('status', 'tutup')->count(),
        ];

        $pdf = Pdf::loadView('admin.pdf-laporan', compact('tanggalAwal', 'tanggalAkhir', 'jenis', 'totalPengajuan', 'totalSelesai', 'totalDiproses', 'totalDitolak', 'rekapJenis', 'rekapStatus'));

        $pdf->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $namaFile = 'Laporan_Pelayanan_';

        if ($tanggalAwal && $tanggalAkhir) {
            $namaFile .= date('d-m-Y', strtotime($tanggalAwal)) . '_sampai_' . date('d-m-Y', strtotime($tanggalAkhir));
        } else {
            $namaFile .= date('d-m-Y');
        }

        return $pdf->download($namaFile . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $namaFile = 'Laporan_Pelayanan_';

        if ($tanggalAwal && $tanggalAkhir) {
            $namaFile .= date('d-m-Y', strtotime($tanggalAwal)) . '_sampai_' . date('d-m-Y', strtotime($tanggalAkhir));
        } else {
            $namaFile .= date('d-m-Y');
        }

        return Excel::download(new \App\Exports\LaporanExport($request), $namaFile . '.xlsx');
    }
}
