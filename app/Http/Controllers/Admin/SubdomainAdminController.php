<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subdomain;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\Notification;
use App\Mail\PengajuanBaruMail;
use App\Mail\StatusPengajuanMail;
use App\Helpers\ActivityLogHelper;

class SubdomainAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Subdomain::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                    ->orWhere('nama_subdomain', 'like', "%{$search}%")
                    ->orWhere('nama_penanggung_jawab', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subdomains = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengajuan-subdomain', compact('subdomains'));
    }

    public function show(Subdomain $subdomain)
    {
        return view('admin.detail-pengajuan-subdomain', compact('subdomain'));
    }

    public function destroy(Subdomain $subdomain)
    {
        // Hapus file jika ada
        if ($subdomain->karpeg) {
            Storage::disk('local')->delete($subdomain->karpeg);
        }

        if ($subdomain->formulir_subdomain) {
            Storage::disk('local')->delete($subdomain->formulir_subdomain);
        }

        if ($subdomain->surat_penunjukan) {
            Storage::disk('local')->delete($subdomain->surat_penunjukan);
        }

        $subdomain->delete();

        return redirect()->route('admin.subdomain')->with('success', 'Pengajuan subdomain berhasil dihapus.');
    }

    public function updateStatus(Request $request, Subdomain $subdomain)
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

        // Tidak boleh selesai jika Surat belum diupload
        if ($validated['status'] === 'selesai' && !$subdomain->surat_penunjukan) {
            return back()->with('error', 'Surat Penunjukan wajib diupload sebelum status selesai.');
        }

        $subdomain->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        ActivityLogHelper::log(
            aksi: $aksi,
            modul: 'Subdomain',
            nomorTiket: $subdomain->nomor_tiket,
            detail: 'Status pengajuan berubah menjadi "' . $statusLabel . '".'
        );

        // ====================================
        // Notifikasi User
        // ====================================

        $title = '';
        $message = '';

        switch ($validated['status']) {
            case 'baru':
                $title = 'Pengajuan Sedang Diperiksa';
                $message = 'Pengajuan ' . $subdomain->nomor_tiket . ' sedang diperiksa Administrator.';
                break;

            case 'tunda':
                $title = 'Menunggu Persetujuan';
                $message = 'Pengajuan ' . $subdomain->nomor_tiket . ' sedang menunggu persetujuan Pimpinan.';
                break;

            case 'diproses':
                $title = 'Pengajuan Diproses';
                $message = 'Pengajuan ' . $subdomain->nomor_tiket . ' sedang diproses Administrator.';
                break;

            case 'selesai':
                $title = 'Pengajuan Selesai';
                $message = 'Pengajuan ' . $subdomain->nomor_tiket . ' telah selesai.';
                break;

            case 'tutup':
                $title = 'Pengajuan Ditolak';
                $message = 'Pengajuan ' . $subdomain->nomor_tiket . ' ditolak.';
                break;
        }

        Notification::create([
            'recipient_type' => 'user',

            'recipient_id' => $subdomain->user_id,

            'title' => $title,

            'message' => $message,

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

                'status' => $statusLabel,

                'tanggal' => now(),

                'url' => route('subdomain.show', $subdomain->id),
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

                    'title' => 'Persetujuan Subdomain',

                    'message' => 'Pengajuan ' . $subdomain->nomor_tiket . ' menunggu persetujuan.',

                    'type' => 'subdomain',

                    'reference_type' => 'subdomain',

                    'reference_id' => $subdomain->id,

                    'url' => route('pimpinan.approval-show', $subdomain->id),
                ]);

                // Kirim Email
                Mail::to($pimpinan->email)->send(
                    new PengajuanBaruMail([
                        'role' => 'Pimpinan',

                        'jenis_layanan' => 'Subdomain',

                        'nomor_tiket' => $subdomain->nomor_tiket,

                        'instansi' => $subdomain->nama_instansi,

                        'nama' => $subdomain->nama_penanggung_jawab,

                        'status' => 'Menunggu Persetujuan',

                        'tanggal' => $subdomain->created_at,

                        'url' => route('pimpinan.approval-show', $subdomain->id),
                    ]),
                );
            }
        }

        return redirect()->route('admin.subdomain')->with('success', 'Status berhasil diperbarui.');
    }

    public function viewKarpeg(Subdomain $subdomain)
    {
        abort_unless(auth()->id() === $subdomain->user_id || in_array(auth()->user()->role, ['admin', 'superadmin', 'pimpinan']), 403);

        return Storage::disk('local')->response($subdomain->karpeg);
    }

    public function viewFormulir(Subdomain $subdomain)
    {
        if (empty($subdomain->formulir_subdomain)) {
            return back()->with('error', 'Formulir subdomain belum diupload.');
        }

        if (!Storage::disk('local')->exists($subdomain->formulir_subdomain)) {
            return back()->with('error', 'File formulir tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($subdomain->formulir_subdomain));
    }

    public function resetFormulir(Subdomain $subdomain)
    {
        try {
            if ($subdomain->status === 'selesai' || $subdomain->status === 'tutup') {
                return back()->with('error', 'Formulir tidak dapat diubah karena pengajuan sudah selesai atau ditutup.');
            }

            if ($subdomain->formulir_subdomain) {
                Storage::disk('local')->delete($subdomain->formulir_subdomain);
            }

            $subdomain->update([
                'formulir_subdomain' => null,
                'catatan_admin' => 'Formulir tidak jelas atau tidak sesuai. Silakan upload ulang formulir yang telah ditandatangani.',
            ]);

            return back()->with('success', 'Permintaan upload ulang formulir berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses permintaan upload ulang.');
        }
    }

    public function deleteFormulir(Subdomain $subdomain)
    {
        try {
            if ($subdomain->formulir_subdomain) {
                Storage::disk('local')->delete($subdomain->formulir_subdomain);
            }

            $subdomain->update([
                'formulir_subdomain' => null,
            ]);

            return back()->with('success', 'Formulir berhasil dihapus. Pemohon dapat mengupload ulang dokumen.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus formulir.');
        }
    }

    public function cetakSk(Subdomain $subdomain)
    {
        try {
            if ($subdomain->status !== 'diproses') {
                return back()->with('error', 'Surat Penunjukan hanya dapat dicetak setelah pengajuan disetujui pimpinan.');
            }

            $pdf = Pdf::loadView('admin.cetak-surat-subdomain', compact('subdomain'));

            return $pdf->stream('Surat-Penunjukan-' . $subdomain->nomor_tiket . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencetak Surat Penunjukan.');
        }
    }

    public function uploadSkPenunjukan(Request $request, Subdomain $subdomain)
    {
        $request->validate([
            'surat_penunjukan' => 'required|file|mimes:pdf|max:5120',
        ]);

        try {
            if ($subdomain->surat_penunjukan) {
                Storage::disk('local')->delete($subdomain->surat_penunjukan);
            }

            $path = $request->file('surat_penunjukan')->store('subdomain/surat-penunjukan', 'local');

            $subdomain->update([
                'surat_penunjukan' => $path,
            ]);

            return back()->with('success', 'Surat Penunjukan berhasil diupload.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadSkPenunjukan(Subdomain $subdomain)
    {
        if (!$subdomain->surat_penunjukan) {
            abort(404);
        }

        $path = Storage::disk('local')->path($subdomain->surat_penunjukan);

        return response()->file($path, [
            'Content-Disposition' => 'inline',
        ]);
    }

    public function suratLama(Subdomain $subdomain)
    {
        abort_unless($subdomain->surat_penunjukan_lama, 404);

        $path = Storage::disk('local')->path($subdomain->surat_penunjukan_lama);

        return response()->file($path, [
            'Content-Disposition' => 'inline',
        ]);
    }

    //sementara
    public function approve(Request $request, Subdomain $subdomain)
    {
        $request->validate([
            'catatan_pimpinan' => 'nullable|string|max:1000',
        ]);

        try {
            $subdomain->update([
                'status' => 'diproses',
                'catatan_pimpinan' => $request->catatan_pimpinan,
            ]);

            return redirect()
                ->route('admin.approval-list')
                ->with('success', 'Pengajuan ' . $subdomain->nomor_tiket . ' berhasil disetujui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyetujui pengajuan.');
        }
    }

    public function approvalShow(Subdomain $subdomain)
    {
        return view('admin.detail-persetujuan-pimpinan', compact('subdomain'));
    }

    public function approvalList()
    {
        $subdomain = Subdomain::where('status', 'tunda')->latest()->first();

        if (!$subdomain) {
            return redirect()->route('admin.subdomain')->with('error', 'Tidak ada pengajuan yang menunggu persetujuan.');
        }

        return view('admin.persetujuan-pimpinan', compact('subdomain'));
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

        try {
            $subdomain->update([
                'status' => 'tutup',
                'catatan_pimpinan' => $request->catatan_pimpinan,
            ]);

            return redirect()
                ->route('admin.approval-list')
                ->with('success', 'Pengajuan ' . $subdomain->nomor_tiket . ' berhasil ditolak.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menolak pengajuan.');
        }
    }
}
