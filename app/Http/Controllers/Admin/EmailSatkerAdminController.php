<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSatker;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountInformationMail;
use App\Models\Admin;
use App\Models\Notification;
use App\Mail\PengajuanBaruMail;
use App\Mail\StatusPengajuanMail;
use App\Helpers\ActivityLogHelper;

class EmailSatkerAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailSatker::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                    ->orWhere('nama_penanggung_jawab', 'like', "%{$search}%")
                    ->orWhere('nama_akun_dinas', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $emailSatkers = $query->oldest()->paginate(10)->withQueryString();

        return view('admin.pengajuan-email-satker', compact('emailSatkers'));
    }

    public function show(EmailSatker $emailSatker)
    {
        return view('admin.detail-pengajuan-email-satker', compact('emailSatker'));
    }

    public function destroy(EmailSatker $emailSatker)
    {
        if ($emailSatker->karpeg) {
            Storage::disk('local')->delete($emailSatker->karpeg);
        }

        if ($emailSatker->formulir_email) {
            Storage::disk('local')->delete($emailSatker->formulir_email);
        }

        $emailSatker->delete();

        return redirect()->route('admin.email-satker')->with('success', 'Pengajuan Email Satuan Kerja berhasil dihapus.');
    }

    public function updateStatus(Request $request, EmailSatker $emailSatker)
    {
        $validated = $request->validate([
            'status' => 'required',
            'catatan_admin' => 'nullable|string',
        ]);

         $statusLabel = match ($validated['status']) {
            'terbuka' => 'Pengajuan Baru',

            'baru' => 'Menunggu Pemeriksaan',

            'tunda' => 'Menunggu Persetujuan Pimpinan',

            'diproses' => 'Sedang Diproses',

            'selesai' => 'Selesai',

            'tutup' => 'Ditolak',

            default => ucfirst($validated['status']),
        };

        $aksi = match ($validated['status']) {
            'terbuka'  => 'Membuat Pengajuan',
            'baru'     => 'Melakukan Pemeriksaan Pengajuan',
            'tunda'    => 'Mengajukan Persetujuan ke Pimpinan',
            'diproses' => 'Memproses Pengajuan',
            'selesai'  => 'Menyelesaikan Pengajuan',
            'tutup'    => 'Menolak Pengajuan',
            default    => 'Mengubah Status Pengajuan',
        };

        $status = $validated['status'];

        /*
        |--------------------------------------------------------------------------
        | Otomatis lewati Persetujuan Pimpinan
        |--------------------------------------------------------------------------
        */

        if ($status == 'baru' && in_array($emailSatker->jenis_layanan, ['reset', 'reaktivasi', 'ubah_akun'])) {
            $status = 'diproses';
        }

        // /*
        // |--------------------------------------------------------------------------
        // | Pengajuan Baru & Ubah Penanggung
        // |--------------------------------------------------------------------------
        // */

        // if ($status == 'baru' && in_array($emailSatker->jenis_layanan, ['baru', 'ubah_penanggung'])) {
        //     $status = 'tunda';
        // }

        $emailSatker->update([
            'status' => $status,
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        // ====================================
        // Notifikasi User
        // ====================================

       ActivityLogHelper::log(
            aksi: $aksi,
            modul: 'Email Satker',
            nomorTiket: $emailSatker->nomor_tiket,
            detail: 'Status pengajuan diubah menjadi "' . $statusLabel . '".'
        );

        $title = '';
        $message = '';

        switch ($validated['status']) {
            case 'baru':
                $title = 'Pengajuan Sedang Diperiksa';
                $message = 'Pengajuan ' . $emailSatker->nomor_tiket . ' sedang diperiksa Administrator.';
                break;

            case 'tunda':
                $title = 'Menunggu Persetujuan';
                $message = 'Pengajuan ' . $emailSatker->nomor_tiket . ' sedang menunggu persetujuan Pimpinan.';
                break;

            case 'diproses':
                $title = 'Pengajuan Diproses';
                $message = 'Pengajuan ' . $emailSatker->nomor_tiket . ' sedang diproses Administrator.';
                break;

            case 'selesai':
                $title = 'Pengajuan Selesai';
                $message = 'Pengajuan ' . $emailSatker->nomor_tiket . ' telah selesai.';
                break;

            case 'tutup':
                $title = 'Pengajuan Ditolak';
                $message = 'Pengajuan ' . $emailSatker->nomor_tiket . ' ditolak.';
                break;
        }

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $emailSatker->user_id,

            'title' => $title,

            'message' => $message,

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

                'status' => $statusLabel,

                'tanggal' => now(),

                'url' => route('email-satker.show', $emailSatker->id),
            ]),
        );

        // ===============================
        // Notifikasi Pimpinan
        // ===============================
        if ($validated['status'] === 'tunda') {
            $pimpinans = Admin::where('role', 'pimpinan')->get();

            foreach ($pimpinans as $pimpinan) {
                Notification::create([
                    'recipient_type' => 'pimpinan',

                    'recipient_id' => $pimpinan->id,

                    'title' => 'Persetujuan Email Satker',

                    'message' => 'Pengajuan ' . $emailSatker->nomor_tiket . ' menunggu persetujuan.',

                    'type' => 'email_satker',

                    'reference_type' => 'email_satker',

                    'reference_id' => $emailSatker->id,

                    'url' => route('pimpinan.email-satker.approval-show', $emailSatker->id),
                ]);

                // Kirim Email
                Mail::to($pimpinan->email)->send(
                    new PengajuanBaruMail([
                        'role' => 'Pimpinan',

                        'jenis_layanan' => 'Email Satker',

                        'nomor_tiket' => $emailSatker->nomor_tiket,

                        'instansi' => $emailSatker->nama_instansi,

                        'nama' => $emailSatker->nama_penanggung_jawab,

                        'status' => 'Menunggu Persetujuan',

                        'tanggal' => $emailSatker->created_at,

                        'url' => route('pimpinan.email-satker.approval-show', $emailSatker->id),
                    ]),
                );
            }
        }

        return redirect()->route('admin.email-satker.show', $emailSatker)->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function viewKarpeg(EmailSatker $emailSatker)
    {
        abort_unless(auth()->id() === $emailSatker->user_id || in_array(auth()->user()->role, ['admin', 'superadmin', 'pimpinan']), 403);

        return Storage::disk('local')->response($emailSatker->karpeg);
    }

    public function viewFormulir(EmailSatker $emailSatker)
    {
        if (empty($emailSatker->formulir_email)) {
            return back()->with('error', 'Formulir Email Satuan Kerja belum diupload.');
        }

        if (!Storage::disk('local')->exists($emailSatker->formulir_email)) {
            return back()->with('error', 'File formulir tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($emailSatker->formulir_email));
    }

    public function resetFormulir(EmailSatker $emailSatker)
    {
        try {
            if (in_array($emailSatker->status, ['selesai', 'tutup'])) {
                return back()->with('error', 'Formulir tidak dapat diubah karena pengajuan sudah selesai atau ditutup.');
            }

            if ($emailSatker->formulir_email) {
                Storage::disk('local')->delete($emailSatker->formulir_email);
            }

            $emailSatker->update([
                'formulir_email' => null,
                'catatan_admin' => 'Formulir tidak jelas atau tidak sesuai. Silakan upload ulang formulir yang telah ditandatangani.',
            ]);

            return back()->with('success', 'Permintaan upload ulang formulir berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses permintaan upload ulang.');
        }
    }

    public function deleteFormulir(EmailSatker $emailSatker)
    {
        try {
            if ($emailSatker->formulir_email) {
                Storage::disk('local')->delete($emailSatker->formulir_email);
            }

            $emailSatker->update([
                'formulir_email' => null,
            ]);

            return back()->with('success', 'Formulir berhasil dihapus. Pemohon dapat mengupload ulang dokumen.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus formulir.');
        }
    }

    public function cetakFormulir(EmailSatker $emailSatker)
    {
        try {
            if ($emailSatker->status !== 'diproses') {
                return back()->with('error', 'Formulir hanya dapat dicetak setelah pengajuan diproses.');
            }

            $pdf = Pdf::loadView('admin.cetak-formulir-email-satker', compact('emailSatker'));

            return $pdf->stream('Formulir-Email-Satker-' . $emailSatker->nomor_tiket . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencetak formulir.');
        }
    }

    public function sendInformation(Request $request, EmailSatker $emailSatker)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        try {
            // Apakah ini kirim ulang?
            $isResend = !empty($emailSatker->dokumen_akun);

            // Generate PDF
            $pdf = Pdf::loadView('admin.pdf-account-information', [
                'emailSatker' => $emailSatker,
                'username' => $request->username,
                'password' => $request->password,
            ]);

            // Folder arsip
            $folder = 'account-information/email-satker';

            if (!Storage::disk('local')->exists($folder)) {
                Storage::disk('local')->makeDirectory($folder);
            }

            // File sementara
            $tempFile = $folder . '/' . $emailSatker->nomor_tiket . '_temp.pdf';

            // File final
            $finalFile = $folder . '/' . $emailSatker->nomor_tiket . '.pdf';

            // Simpan PDF sementara
            Storage::disk('local')->put($tempFile, $pdf->output());

            // Tentukan email tujuan
            $recipient = $emailSatker->jenis_layanan == 'ubah_penanggung' ? $emailSatker->email_baru : $emailSatker->email;

            // Kirim email
            Mail::to($recipient)->send(new AccountInformationMail($emailSatker, Storage::disk('local')->path($tempFile), 'emails.account-information'));

            // Kalau email berhasil

            // Hapus PDF lama
            if ($emailSatker->dokumen_akun && Storage::disk('local')->exists($emailSatker->dokumen_akun)) {
                Storage::disk('local')->delete($emailSatker->dokumen_akun);
            }

            // Rename temp menjadi final
            Storage::disk('local')->move($tempFile, $finalFile);

            // Update database
            $emailSatker->update([
                'dokumen_akun' => $finalFile,

                'email_sent_at' => now(),
            ]);

            return back()->with('success', $isResend ? 'Informasi akun berhasil diperbarui dan dikirim ulang.' : 'Informasi akun berhasil dikirim ke Email Penanggung Jawab.');
        } catch (\Exception $e) {
            // Hapus file sementara bila ada
            if (isset($tempFile) && Storage::disk('local')->exists($tempFile)) {
                Storage::disk('local')->delete($tempFile);
            }

            return back()->with('error', 'Gagal mengirim informasi akun. ' . $e->getMessage());
        }
    }

    public function previewInformation(EmailSatker $emailSatker)
    {
        if (!$emailSatker->dokumen_akun) {
            return back()->with('error', 'Dokumen Informasi Akun belum tersedia.');
        }

        if (!Storage::disk('local')->exists($emailSatker->dokumen_akun)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($emailSatker->dokumen_akun));
    }
}
