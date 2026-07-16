<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailPribadi;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

use App\Mail\AccountInformationMail;


class EmailPribadiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailPribadi::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('nama_instansi', 'like', "%{$search}%")
                    ->orWhere('nama_akun', 'like', "%{$search}%")
                    ->orWhere('nama_akun_baru', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $emailPribadis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengajuan-email-pribadi', compact('emailPribadis'));
    }

    public function show(EmailPribadi $emailPribadi)
    {
        return view('admin.detail-pengajuan-email-pribadi', compact('emailPribadi'));
    }

    public function destroy(EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->karpeg) {
            Storage::disk('local')->delete($emailPribadi->karpeg);
        }

        if ($emailPribadi->formulir_email) {
            Storage::disk('local')->delete($emailPribadi->formulir_email);
        }

        if ($emailPribadi->dokumen_akun) {
            Storage::disk('local')->delete($emailPribadi->dokumen_akun);
        }

        $emailPribadi->delete();

        return redirect()->route('admin.email-pribadi')->with('success', 'Pengajuan Email Pribadi berhasil dihapus.');
    }

    public function updateStatus(Request $request, EmailPribadi $emailPribadi)
    {
        $validated = $request->validate([
            'status' => 'required',
            'catatan_admin' => 'nullable|string',
        ]);

        $status = $validated['status'];

        /*
    |--------------------------------------------------------------------------
    | Reset Password, Reaktivasi & Ubah Akun
    | Langsung ke Diproses (tidak melalui Persetujuan Pimpinan)
    |--------------------------------------------------------------------------
    */

        if ($status == 'baru' && in_array($emailPribadi->jenis_layanan, ['reset', 'reaktivasi', 'ubah_akun'])) {
            $status = 'diproses';
        }

        /*
    |--------------------------------------------------------------------------
    | Pengajuan Baru
    | Masuk ke Persetujuan Pimpinan
    |--------------------------------------------------------------------------
    */

        if ($status == 'baru' && $emailPribadi->jenis_layanan == 'baru') {
            $status = 'tunda';
        }

        $emailPribadi->update([
            'status' => $status,
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()->route('admin.email-pribadi.show', $emailPribadi)->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function viewKarpeg(EmailPribadi $emailPribadi)
    {
        abort_unless(auth()->id() === $emailPribadi->user_id || in_array(auth()->user()->role, ['admin', 'superadmin', 'pimpinan']), 403);

        return Storage::disk('local')->response($emailPribadi->karpeg);
    }

    public function viewFormulir(EmailPribadi $emailPribadi)
    {
        if (empty($emailPribadi->formulir_email)) {
            return back()->with('error', 'Formulir Email Pribadi belum diupload.');
        }

        if (!Storage::disk('local')->exists($emailPribadi->formulir_email)) {
            return back()->with('error', 'File formulir tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($emailPribadi->formulir_email));
    }

    public function resetFormulir(EmailPribadi $emailPribadi)
    {
        try {
            if (in_array($emailPribadi->status, ['selesai', 'tutup'])) {
                return back()->with('error', 'Formulir tidak dapat diubah karena pengajuan sudah selesai atau ditutup.');
            }

            if ($emailPribadi->formulir_email) {
                Storage::disk('local')->delete($emailPribadi->formulir_email);
            }

            $emailPribadi->update([
                'formulir_email' => null,
                'catatan_admin' => 'Formulir tidak jelas atau tidak sesuai. Silakan upload ulang formulir yang telah ditandatangani.',
            ]);

            return back()->with('success', 'Permintaan upload ulang formulir berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses permintaan upload ulang.');
        }
    }

    public function deleteFormulir(EmailPribadi $emailPribadi)
    {
        try {
            if ($emailPribadi->formulir_email) {
                Storage::disk('local')->delete($emailPribadi->formulir_email);
            }

            $emailPribadi->update([
                'formulir_email' => null,
            ]);

            return back()->with('success', 'Formulir berhasil dihapus. Pemohon dapat mengupload ulang dokumen.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus formulir.');
        }
    }

    public function cetakFormulir(EmailPribadi $emailPribadi)
    {
        try {
            if ($emailPribadi->status !== 'diproses') {
                return back()->with('error', 'Formulir hanya dapat dicetak setelah pengajuan diproses.');
            }

            $pdf = Pdf::loadView('admin.cetak-formulir-email-pribadi', compact('emailPribadi'));

            return $pdf->stream('Formulir-Email-Pribadi-' . $emailPribadi->nomor_tiket . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencetak formulir.');
        }
    }

    public function sendInformation(Request $request, EmailPribadi $emailPribadi)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        try {
            // Apakah ini kirim ulang?
            $isResend = !empty($emailPribadi->dokumen_akun);

            // Generate PDF
            $pdf = Pdf::loadView('admin.pdf-account-information-email-pribadi', [
                'emailPribadi' => $emailPribadi,
                'username' => $request->username,
                'password' => $request->password,
            ]);

            // Folder arsip
            $folder = 'account-information/email-pribadi';

            if (!Storage::disk('local')->exists($folder)) {
                Storage::disk('local')->makeDirectory($folder);
            }

            // File sementara
            $tempFile = $folder . '/' . $emailPribadi->nomor_tiket . '_temp.pdf';

            // File final
            $finalFile = $folder . '/' . $emailPribadi->nomor_tiket . '.pdf';

            // Simpan PDF sementara
            Storage::disk('local')->put($tempFile, $pdf->output());

            // Kirim email ke Email Pribadi
            Mail::to($emailPribadi->email)->send(new AccountInformationMail($emailPribadi, Storage::disk('local')->path($tempFile), 'emails.account-information-email-pribadi'));

            // Hapus PDF lama jika ada
            if ($emailPribadi->dokumen_akun && Storage::disk('local')->exists($emailPribadi->dokumen_akun)) {
                Storage::disk('local')->delete($emailPribadi->dokumen_akun);
            }

            // Rename temp menjadi final
            Storage::disk('local')->move($tempFile, $finalFile);

            // Update database
            $emailPribadi->update([
                'dokumen_akun' => $finalFile,
                'email_sent_at' => now(),
            ]);

            return back()->with('success', $isResend ? 'Informasi akun berhasil diperbarui dan dikirim ulang.' : 'Informasi akun berhasil dikirim ke Email Pribadi.');
        } catch (\Exception $e) {
            // Hapus file sementara bila ada
            if (isset($tempFile) && Storage::disk('local')->exists($tempFile)) {
                Storage::disk('local')->delete($tempFile);
            }

            return back()->with('error', 'Gagal mengirim informasi akun. ' . $e->getMessage());
        }
    }

    public function previewInformation(EmailPribadi $emailPribadi)
    {
        if (!$emailPribadi->dokumen_akun) {
            return back()->with('error', 'Dokumen Informasi Akun belum tersedia.');
        }

        if (!Storage::disk('local')->exists($emailPribadi->dokumen_akun)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($emailPribadi->dokumen_akun));
    }
}
