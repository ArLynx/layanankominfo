<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanBaruMail;
use App\Mail\StatusPengajuanMail;
use App\Helpers\ActivityLogHelper;

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
        $subdomains = Subdomain::with('user')->latest()->paginate(15);

        return view('pimpinan.subdomain-list', compact('subdomains'));
    }

    public function approvalList()
    {
        $subdomains = Subdomain::with('user')->where('status', 'tunda')->latest()->paginate(15);

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

        ActivityLogHelper::log(
            aksi: 'Menyetujui Pengajuan',
            modul: 'Subdomain',
            nomorTiket: $subdomain->nomor_tiket,
            detail: 'Pimpinan menyetujui pengajuan sehingga status berubah menjadi "Sedang Diproses".'
        );

        // ===============================
        // Notifikasi Admin
        // ===============================
        $admins = Admin::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'recipient_type' => 'admin',

                'recipient_id' => $admin->id,

                'title' => 'Persetujuan Subdomain',

                'message' => 'Pengajuan ' . $subdomain->nomor_tiket . ' telah disetujui oleh Pimpinan.',

                'type' => 'subdomain',

                'reference_type' => 'subdomain',

                'reference_id' => $subdomain->id,

                'url' => route('admin.subdomain.show', $subdomain->id),
            ]);

            Mail::to($admin->email)->send(
                new PengajuanBaruMail([
                    'role' => 'Administrator',

                    'jenis_layanan' => 'Subdomain',

                    'nomor_tiket' => $subdomain->nomor_tiket,

                    'instansi' => $subdomain->nama_instansi,

                    'nama' => $subdomain->nama_penanggung_jawab,

                    'status' => 'Disetujui Pimpinan',

                    'tanggal' => now(),

                    'url' => route('admin.subdomain.show', $subdomain->id),
                ]),
            );
        }

        // ====================================
        // Notifikasi User
        // ====================================

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $subdomain->user_id,

            'title' => 'Pengajuan Diproses',

            'message' => 'Pengajuan ' . $subdomain->nomor_tiket . ' telah disetujui oleh Pimpinan dan sedang diproses Administrator.',

            'type' => 'subdomain',

            'reference_type' => 'subdomain',

            'reference_id' => $subdomain->id,

            'url' => route('subdomain.show', $subdomain->id),
        ]);

        Mail::to($subdomain->user->email)->send(
            new StatusPengajuanMail([
                'jenis_layanan' => 'Subdomain',

                'nomor_tiket' => $subdomain->nomor_tiket,

                'instansi' => $subdomain->nama_instansi,

                'nama' => $subdomain->nama_penanggung_jawab,

                'status' => 'Sedang Diproses',

                'tanggal' => now(),

                'url' => route('subdomain.show', $subdomain->id),
            ]),
        );

        return redirect()->route('pimpinan.approval-list')->with('success', 'Pengajuan subdomain berhasil disetujui.');
    }

    public function reject(Request $request, Subdomain $subdomain)
    {
        $request->validate(
            [
                'catatan_pimpinan' => 'required|string|max:1000',
            ],
            [
                'catatan_pimpinan.required' => 'Catatan pimpinan wajib diisi saat menolak pengajuan.',
            ],
        );

        $subdomain->update([
            'status' => 'tutup',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        ActivityLogHelper::log(
            aksi: 'Menolak Pengajuan',
            modul: 'Subdomain',
            nomorTiket: $subdomain->nomor_tiket,
            detail: 'Pimpinan menolak pengajuan. Status berubah menjadi "Ditolak".'
        );

        $admins = Admin::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'recipient_type' => 'admin',

                'recipient_id' => $admin->id,

                'title' => 'Penolakan Subdomain',

                'message' => 'Pengajuan ' . $subdomain->nomor_tiket . ' ditolak oleh Pimpinan.',

                'type' => 'subdomain',

                'reference_type' => 'subdomain',

                'reference_id' => $subdomain->id,

                'url' => route('admin.subdomain.show', $subdomain->id),
            ]);

            Mail::to($admin->email)->send(
                new PengajuanBaruMail([
                    'role' => 'Administrator',

                    'jenis_layanan' => 'Subdomain',

                    'nomor_tiket' => $subdomain->nomor_tiket,

                    'instansi' => $subdomain->nama_instansi,

                    'nama' => $subdomain->nama_penanggung_jawab,

                    'status' => 'Ditolak Pimpinan',

                    'tanggal' => now(),

                    'url' => route('admin.subdomain.show', $subdomain->id),
                ]),
            );
        }

        // ====================================
        // Notifikasi User
        // ====================================

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $subdomain->user_id,

            'title' => 'Pengajuan Ditolak',

            'message' => 'Pengajuan ' . $subdomain->nomor_tiket . ' ditolak oleh Pimpinan.',

            'type' => 'subdomain',

            'reference_type' => 'subdomain',

            'reference_id' => $subdomain->id,

            'url' => route('subdomain.show', $subdomain->id),
        ]);

        Mail::to($subdomain->user->email)->send(
            new StatusPengajuanMail([
                'jenis_layanan' => 'Subdomain',

                'nomor_tiket' => $subdomain->nomor_tiket,

                'instansi' => $subdomain->nama_instansi,

                'nama' => $subdomain->nama_penanggung_jawab,

                'status' => 'Ditolak',

                'tanggal' => now(),

                'url' => route('subdomain.show', $subdomain->id),
            ]),
        );

        return redirect()->route('pimpinan.approval-list')->with('success', 'Pengajuan subdomain ditolak.');
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

    // ===================== EMAIL SATKER =====================

    public function emailSatkerList()
    {
        $emailSatkers = EmailSatker::with('user')->latest()->paginate(15);

        return view('pimpinan.email-satker-list', compact('emailSatkers'));
    }

    public function emailSatkerApprovalList()
    {
        $emailSatkers = EmailSatker::with('user')->where('status', 'tunda')->latest()->paginate(15);

        return view('pimpinan.email-satker-approval-list', compact('emailSatkers'));
    }

    public function emailSatkerDetail(EmailSatker $emailSatker)
    {
        return view('pimpinan.email-satker-detail', compact('emailSatker'));
    }

    public function emailSatkerApprovalShow(EmailSatker $emailSatker)
    {
        return view('pimpinan.email-satker-approval-show', compact('emailSatker'));
    }

    public function emailSatkerApprove(Request $request, EmailSatker $emailSatker)
    {
        $request->validate([
            'catatan_pimpinan' => 'nullable|string|max:1000',
        ]);

        $emailSatker->update([
            'status' => 'diproses',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        ActivityLogHelper::log(
            aksi: 'Menyetujui Pengajuan',
            modul: 'Email Satker',
            nomorTiket: $emailSatker->nomor_tiket,
            detail: 'Pimpinan menyetujui pengajuan sehingga status berubah menjadi "Sedang Diproses".'
        );

        // ===============================
        // Notifikasi & Email Admin
        // ===============================
        $admins = Admin::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'recipient_type' => 'admin',

                'recipient_id' => $admin->id,

                'title' => 'Persetujuan Email Satker',

                'message' => 'Pengajuan ' . $emailSatker->nomor_tiket . ' telah disetujui oleh Pimpinan.',

                'type' => 'email_satker',

                'reference_type' => 'email_satker',

                'reference_id' => $emailSatker->id,

                'url' => route('admin.email-satker.show', $emailSatker->id),
            ]);

            Mail::to($admin->email)->send(
                new PengajuanBaruMail([
                    'role' => 'Administrator',

                    'jenis_layanan' => 'Email Satker',

                    'nomor_tiket' => $emailSatker->nomor_tiket,

                    'instansi' => $emailSatker->nama_instansi,

                    'nama' => $emailSatker->nama_penanggung_jawab,

                    'status' => 'Disetujui Pimpinan',

                    'tanggal' => now(),

                    'url' => route('admin.email-satker.show', $emailSatker->id),
                ]),
            );
        }

        // ====================================
        // Notifikasi User
        // ====================================

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $emailSatker->user_id,

            'title' => 'Pengajuan Diproses',

            'message' => 'Pengajuan ' . $emailSatker->nomor_tiket . ' telah disetujui oleh Pimpinan dan sedang diproses Administrator.',

            'type' => 'email_satker',

            'reference_type' => 'email_satker',

            'reference_id' => $emailSatker->id,

            'url' => route('email-satker.show', $emailSatker->id),
        ]);

        Mail::to($emailSatker->user->email)->send(
            new StatusPengajuanMail([
                'jenis_layanan' => 'Email Satker',

                'nomor_tiket' => $emailSatker->nomor_tiket,

                'instansi' => $emailSatker->nama_instansi,

                'nama' => $emailSatker->nama_penanggung_jawab,

                'status' => 'Sedang Diproses',

                'tanggal' => now(),

                'url' => route('email-satker.show', $emailSatker->id),
            ]),
        );

        return redirect()->route('pimpinan.email-satker.approval-list')->with('success', 'Pengajuan email satuan kerja berhasil disetujui.');
    }

    public function emailSatkerReject(Request $request, EmailSatker $emailSatker)
    {
        $request->validate(
            [
                'catatan_pimpinan' => 'required|string|max:1000',
            ],
            [
                'catatan_pimpinan.required' => 'Catatan pimpinan wajib diisi saat menolak pengajuan.',
            ],
        );

        $emailSatker->update([
            'status' => 'tutup',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        ActivityLogHelper::log(
            aksi: 'Menolak Pengajuan',
            modul: 'Email Satker',
            nomorTiket: $emailSatker->nomor_tiket,
            detail: 'Pimpinan menolak pengajuan. Status berubah menjadi "Ditolak".'
        );

        // ===============================
        // Notifikasi & Email Admin
        // ===============================
        $admins = Admin::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'recipient_type' => 'admin',

                'recipient_id' => $admin->id,

                'title' => 'Penolakan Email Satker',

                'message' => 'Pengajuan ' . $emailSatker->nomor_tiket . ' ditolak oleh Pimpinan.',

                'type' => 'email_satker',

                'reference_type' => 'email_satker',

                'reference_id' => $emailSatker->id,

                'url' => route('admin.email-satker.show', $emailSatker->id),
            ]);

            Mail::to($admin->email)->send(
                new PengajuanBaruMail([
                    'role' => 'Administrator',

                    'jenis_layanan' => 'Email Satker',

                    'nomor_tiket' => $emailSatker->nomor_tiket,

                    'instansi' => $emailSatker->nama_instansi,

                    'nama' => $emailSatker->nama_penanggung_jawab,

                    'status' => 'Ditolak Pimpinan',

                    'tanggal' => now(),

                    'url' => route('admin.email-satker.show', $emailSatker->id),
                ]),
            );
        }

        // ====================================
        // Notifikasi User
        // ====================================

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $emailSatker->user_id,

            'title' => 'Pengajuan Ditolak',

            'message' => 'Pengajuan ' . $emailSatker->nomor_tiket . ' ditolak oleh Pimpinan.',

            'type' => 'email_satker',

            'reference_type' => 'email_satker',

            'reference_id' => $emailSatker->id,

            'url' => route('email-satker.show', $emailSatker->id),
        ]);

        Mail::to($emailSatker->user->email)->send(
            new StatusPengajuanMail([
                'jenis_layanan' => 'Email Satker',

                'nomor_tiket' => $emailSatker->nomor_tiket,

                'instansi' => $emailSatker->nama_instansi,

                'nama' => $emailSatker->nama_penanggung_jawab,

                'status' => 'Ditolak',

                'tanggal' => now(),

                'url' => route('email-satker.show', $emailSatker->id),

                'catatan' => $emailSatker->catatan_pimpinan,
            ]),
        );

        return redirect()->route('pimpinan.email-satker.approval-list')->with('success', 'Pengajuan email satuan kerja ditolak.');
    }

    public function emailSatkerFormulir(EmailSatker $emailSatker)
    {
        if (empty($emailSatker->formulir_email)) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($emailSatker->formulir_email)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($emailSatker->formulir_email));
    }

    // ===================== EMAIL PRIBADI =====================

    public function emailPribadiList()
    {
        $emailPribadis = EmailPribadi::with('user')->latest()->paginate(15);

        return view('pimpinan.email-pribadi-list', compact('emailPribadis'));
    }

    public function emailPribadiApprovalList()
    {
        $emailPribadis = EmailPribadi::with('user')->where('status', 'tunda')->latest()->paginate(15);

        return view('pimpinan.email-pribadi-approval-list', compact('emailPribadis'));
    }

    public function emailPribadiDetail(EmailPribadi $emailPribadi)
    {
        return view('pimpinan.email-pribadi-detail', compact('emailPribadi'));
    }

    public function emailPribadiApprovalShow(EmailPribadi $emailPribadi)
    {
        return view('pimpinan.email-pribadi-approval-show', compact('emailPribadi'));
    }

    public function emailPribadiApprove(Request $request, EmailPribadi $emailPribadi)
    {
        $request->validate([
            'catatan_pimpinan' => 'nullable|string|max:1000',
        ]);

        $emailPribadi->update([
            'status' => 'diproses',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        ActivityLogHelper::log(
            aksi: 'Menyetujui Pengajuan',
            modul: 'Email Pribadi',
            nomorTiket: $emailPribadi->nomor_tiket,
            detail: 'Pimpinan menyetujui pengajuan sehingga status berubah menjadi "Sedang Diproses".'
        );

        // ===============================
        // Notifikasi & Email Admin
        // ===============================
        $admins = Admin::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'recipient_type' => 'admin',

                'recipient_id' => $admin->id,

                'title' => 'Persetujuan Email Pribadi',

                'message' => 'Pengajuan ' . $emailPribadi->nomor_tiket . ' telah disetujui oleh Pimpinan.',

                'type' => 'email_pribadi',

                'reference_type' => 'email_pribadi',

                'reference_id' => $emailPribadi->id,

                'url' => route('admin.email-pribadi.show', $emailPribadi->id),
            ]);

            Mail::to($admin->email)->send(
                new PengajuanBaruMail([
                    'role' => 'Administrator',

                    'jenis_layanan' => 'Email Pribadi',

                    'nomor_tiket' => $emailPribadi->nomor_tiket,

                    'instansi' => $emailPribadi->nama_instansi,

                    'nama' => $emailPribadi->nama,

                    'status' => 'Disetujui Pimpinan',

                    'tanggal' => now(),

                    'url' => route('admin.email-pribadi.show', $emailPribadi->id),
                ]),
            );
        }

        // ====================================
        // Notifikasi User
        // ====================================

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $emailPribadi->user_id,

            'title' => 'Pengajuan Diproses',

            'message' => 'Pengajuan ' . $emailPribadi->nomor_tiket . ' telah disetujui oleh Pimpinan dan sedang diproses Administrator.',

            'type' => 'email_pribadi',

            'reference_type' => 'email_pribadi',

            'reference_id' => $emailPribadi->id,

            'url' => route('email-pribadi.show', $emailPribadi->id),
        ]);

        Mail::to($emailPribadi->user->email)->send(
            new StatusPengajuanMail([
                'jenis_layanan' => 'Email Pribadi',

                'nomor_tiket' => $emailPribadi->nomor_tiket,

                'instansi' => $emailPribadi->nama_instansi,

                'nama' => $emailPribadi->nama,

                'status' => 'Sedang Diproses',

                'tanggal' => now(),

                'url' => route('email-pribadi.show', $emailPribadi->id),
            ]),
        );

        return redirect()->route('pimpinan.email-pribadi.approval-list')->with('success', 'Pengajuan email pribadi berhasil disetujui.');
    }

    public function emailPribadiReject(Request $request, EmailPribadi $emailPribadi)
    {
        $request->validate(
            [
                'catatan_pimpinan' => 'required|string|max:1000',
            ],
            [
                'catatan_pimpinan.required' => 'Catatan pimpinan wajib diisi saat menolak pengajuan.',
            ],
        );

        $emailPribadi->update([
            'status' => 'tutup',
            'catatan_pimpinan' => $request->catatan_pimpinan,
        ]);

        ActivityLogHelper::log(
            aksi: 'Menolak Pengajuan',
            modul: 'Email Pribadi',
            nomorTiket: $emailPribadi->nomor_tiket,
            detail: 'Pimpinan menolak pengajuan. Status berubah menjadi "Ditolak".'
        );

        // ===============================
        // Notifikasi & Email Admin
        // ===============================
        $admins = Admin::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'recipient_type' => 'admin',

                'recipient_id' => $admin->id,

                'title' => 'Penolakan Email Pribadi',

                'message' => 'Pengajuan ' . $emailPribadi->nomor_tiket . ' ditolak oleh Pimpinan.',

                'type' => 'email_pribadi',

                'reference_type' => 'email_pribadi',

                'reference_id' => $emailPribadi->id,

                'url' => route('admin.email-pribadi.show', $emailPribadi->id),
            ]);

            Mail::to($admin->email)->send(
                new PengajuanBaruMail([
                    'role' => 'Administrator',
                    
                    'jenis_layanan' => 'Email Pribadi',

                    'nomor_tiket' => $emailPribadi->nomor_tiket,

                    'instansi' => $emailPribadi->nama_instansi,

                    'nama' => $emailPribadi->nama,

                    'status' => 'Ditolak Pimpinan',

                    'tanggal' => now(),

                    'url' => route('admin.email-pribadi.show', $emailPribadi->id),
                ]),
            );
        }

        // ====================================
        // Notifikasi User
        // ====================================

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $emailPribadi->user_id,

            'title' => 'Pengajuan Ditolak',

            'message' => 'Pengajuan ' . $emailPribadi->nomor_tiket . ' ditolak oleh Pimpinan.',

            'type' => 'email_pribadi',

            'reference_type' => 'email_pribadi',

            'reference_id' => $emailPribadi->id,

            'url' => route('email-pribadi.show', $emailPribadi->id),
        ]);

        Mail::to($emailPribadi->user->email)->send(
            new StatusPengajuanMail([
                'jenis_layanan' => 'Email Pribadi',

                'nomor_tiket' => $emailPribadi->nomor_tiket,

                'instansi' => $emailPribadi->nama_instansi,

                'nama' => $emailPribadi->nama,

                'status' => 'Ditolak',

                'tanggal' => now(),

                'url' => route('email-pribadi.show', $emailPribadi->id),

                'catatan' => $emailPribadi->catatan_pimpinan,
            ]),
        );

        return redirect()->route('pimpinan.email-pribadi.approval-list')->with('success', 'Pengajuan email pribadi ditolak.');
    }

    public function emailPribadiFormulir(EmailPribadi $emailPribadi)
    {
        if (empty($emailPribadi->formulir_email)) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($emailPribadi->formulir_email)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($emailPribadi->formulir_email));
    }
}
