<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmailPribadi;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Notification;

use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanBaruMail;

class EmailPribadiController extends Controller
{
    public function create()
    {
        return view('user.email-pribadi.create');
    }

    public function store(Request $request, TicketService $ticketService)
    {
        $validated = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'nip' => 'required|min:18',
                'jabatan' => 'required|string|max:255',
                'pangkat_gol' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_hp' => 'required|min:12',

                'nama_instansi' => 'required|string|max:255',
                'nama_kadis' => 'required|string|max:255',
                'jabatan_kadis' => 'required|string|max:255',
                'nip_kadis' => 'required|min:18',

                'nama_akun' => ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'],
                'nama_akun_baru' => $request->jenis_layanan == 'ubah_akun' ? ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'] : ['nullable'],

                'pengajuan' => 'required|in:diri_sendiri,orang_lain',
                'jenis_layanan' => 'required|in:baru,reset,reaktivasi,ubah_akun',
                'karpeg' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',

                'terms' => 'accepted',
            ],

            [
                'nama.required' => 'Nama wajib diisi.',

                'nip.required' => 'NIP wajib diisi.',

                'nip.digits' => 'NIP harus terdiri dari 18 digit.',

                'jabatan.required' => 'Jabatan wajib diisi.',

                'pangkat_gol.required' => 'Pangkat / Golongan wajib diisi.',

                'email.required' => 'Email alternatif wajib diisi.',

                'email.email' => 'Format email tidak valid.',

                'no_hp.required' => 'Nomor HP wajib diisi.',

                'nama_instansi.required' => 'Nama instansi wajib diisi.',

                'nama_kadis.required' => 'Nama Kepala Instansi wajib diisi.',

                'jabatan_kadis.required' => 'Jabatan Kepala Instansi wajib diisi.',

                'nip_kadis.required' => 'NIP Kepala Instansi wajib diisi.',

                'nama_akun.required' => 'Nama akun email wajib diisi.',

                'nama_akun.regex' => 'Nama akun hanya boleh huruf kecil, angka, titik (.), underscore (_) dan tanda hubung (-).',

                'nama_akun_baru.required' => 'Nama akun baru wajib diisi.',

                'pengajuan.required' => 'Jenis pengajuan wajib dipilih.',

                'jenis_layanan.required' => 'Jenis layanan wajib dipilih.',

                'karpeg.required' => 'Kartu Pegawai wajib diupload.',

                'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
            ],
        );

        try {
            $akunEmail = strtolower(trim($validated['nama_akun'])) . '@murungrayakab.go.id';

            $akunEmailBaru = null;

            if ($validated['jenis_layanan'] === 'ubah_akun' && !empty($validated['nama_akun_baru'])) {
                $akunEmailBaru = strtolower(trim($validated['nama_akun_baru'])) . '@murungrayakab.go.id';
            }

            $akunList = array_filter([$akunEmail, $akunEmailBaru]);

            $exists = EmailPribadi::where(function ($query) use ($akunList) {
                foreach ($akunList as $akun) {
                    $query->orWhere('nama_akun', $akun)->orWhere('nama_akun_baru', $akun);
                }
            })
                ->whereNotIn('status', ['selesai', 'tutup'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nama_akun' => 'Pengajuan dengan nama akun tersebut masih diproses. Silakan tunggu hingga pengajuan sebelumnya selesai.',
                    ]);
            }

            $pathKarpeg = $request->file('karpeg')->store('email-pribadi/karpeg', 'local');

            $isUbahAkun = $validated['jenis_layanan'] === 'ubah_akun';

            $emailPribadi = EmailPribadi::create([
                'user_id' => Auth::id(),

                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'],
                'pangkat_gol' => $validated['pangkat_gol'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],

                'nama_instansi' => $validated['nama_instansi'],
                'nama_kadis' => $validated['nama_kadis'],
                'jabatan_kadis' => $validated['jabatan_kadis'],
                'nip_kadis' => $validated['nip_kadis'],

                'nama_akun' => $akunEmail,
                'nama_akun_baru' => $isUbahAkun ? $akunEmailBaru : null,

                'pengajuan' => $validated['pengajuan'],
                'jenis_layanan' => $validated['jenis_layanan'],
                'karpeg' => $pathKarpeg,
                'status' => 'terbuka',
                'nomor_tiket' => $ticketService->generateEmailPribadiTicket(),
            ]);

            // ===============================
            // Notifikasi & Email Admin
            // ===============================
            $admins = Admin::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                // Simpan Notifikasi
                Notification::create([
                    'recipient_type' => 'admin',
                    'recipient_id' => $admin->id,

                    'title' => 'Pengajuan Email Pribadi Baru',

                    'message' => 'Nomor Tiket: ' . $emailPribadi->nomor_tiket,

                    'type' => 'email_pribadi',

                    'reference_type' => 'email_pribadi',

                    'reference_id' => $emailPribadi->id,

                    'url' => route('admin.email-pribadi.show', $emailPribadi->id),
                ]);

                // Kirim Email
                Mail::to($admin->email)->send(
                    new PengajuanBaruMail([
                        'jenis_layanan' => 'Email Pribadi',

                        'nomor_tiket' => $emailPribadi->nomor_tiket,

                        'instansi' => $emailPribadi->nama_instansi,

                        'nama' => $emailPribadi->nama,

                        'status' => 'Menunggu Pemeriksaan',

                        'tanggal' => $emailPribadi->created_at,

                        'url' => route('admin.email-pribadi.show', $emailPribadi->id),
                    ]),
                );
            }
            
            return redirect()->route('email-pribadi.success', $emailPribadi)->with('success', 'Pengajuan Email Pribadi berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function success(EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != Auth::id()) {
            abort(403);
        }

        return view('user.pengajuan.success', compact('emailPribadi'));
    }

    /**
     * Detail pengajuan Email Pribadi.
     */
    public function show(EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != Auth::id()) {
            abort(403);
        }

        return view('user.email-pribadi.show', compact('emailPribadi'));
    }

    /**
     * Form edit pengajuan Email Pribadi.
     */
    public function edit(EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != Auth::id()) {
            abort(403);
        }

        // Tidak boleh diedit jika formulir sudah diupload
        if ($emailPribadi->formulir_email) {
            return redirect()->route('email-pribadi.show', $emailPribadi)->with('error', 'Pengajuan tidak dapat diubah karena formulir telah diupload.');
        }

        return view('user.email-pribadi.edit', compact('emailPribadi'));
    }
    public function update(Request $request, EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != Auth::id()) {
            abort(403);
        }

        // Tidak boleh edit jika formulir sudah diupload
        if ($emailPribadi->formulir_email) {
            return redirect()->route('email-pribadi.show', $emailPribadi)->with('error', 'Pengajuan tidak dapat diubah karena formulir telah diupload.');
        }

        $validated = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'nip' => 'required|min:18',
                'jabatan' => 'required|string|max:255',
                'pangkat_gol' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_hp' => 'required|min:12',

                'nama_instansi' => 'required|string|max:255',
                'nama_kadis' => 'required|string|max:255',
                'jabatan_kadis' => 'required|string|max:255',
                'nip_kadis' => 'required|dmin:18',

                'nama_akun' => ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'],
                'nama_akun_baru' => $request->jenis_layanan == 'ubah_akun' ? ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'] : ['nullable'],

                'pengajuan' => 'required|in:diri_sendiri,orang_lain',
                'jenis_layanan' => 'required|in:baru,reset,reaktivasi,ubah_akun',
                'karpeg' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ],

            [
                'nama.required' => 'Nama wajib diisi.',

                'nip.required' => 'NIP wajib diisi.',

                'nip.digits' => 'NIP harus terdiri dari 18 digit.',

                'jabatan.required' => 'Jabatan wajib diisi.',

                'pangkat_gol.required' => 'Pangkat / Golongan wajib diisi.',

                'email.required' => 'Email alternatif wajib diisi.',

                'email.email' => 'Format email tidak valid.',

                'no_hp.required' => 'Nomor HP wajib diisi.',

                'nama_instansi.required' => 'Nama instansi wajib diisi.',

                'nama_kadis.required' => 'Nama Kepala Instansi wajib diisi.',

                'jabatan_kadis.required' => 'Jabatan Kepala Instansi wajib diisi.',

                'nip_kadis.required' => 'NIP Kepala Instansi wajib diisi.',

                'nama_akun.required' => 'Nama akun email wajib diisi.',

                'nama_akun.regex' => 'Nama akun hanya boleh huruf kecil, angka, titik (.), underscore (_) dan tanda hubung (-).',

                'nama_akun_baru.required' => 'Nama akun baru wajib diisi.',
            ],
        );

        try {
            $akunEmail = strtolower(trim($validated['nama_akun'])) . '@murungrayakab.go.id';

            $akunEmailBaru = null;

            if ($validated['jenis_layanan'] === 'ubah_akun' && !empty($validated['nama_akun_baru'])) {
                $akunEmailBaru = strtolower(trim($validated['nama_akun_baru'])) . '@murungrayakab.go.id';
            }

            $akunList = array_filter([$akunEmail, $akunEmailBaru]);

            $exists = EmailPribadi::where(function ($query) use ($akunList) {
                foreach ($akunList as $akun) {
                    $query->orWhere('nama_akun', $akun)->orWhere('nama_akun_baru', $akun);
                }
            })
                ->where('id', '!=', $emailPribadi->id)
                ->whereNotIn('status', ['selesai', 'tutup'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nama_akun' => 'Pengajuan dengan nama akun tersebut masih diproses. Silakan gunakan nama akun lain.',
                    ]);
            }

            if ($request->hasFile('karpeg')) {
                if ($emailPribadi->karpeg && Storage::disk('local')->exists($emailPribadi->karpeg)) {
                    Storage::disk('local')->delete($emailPribadi->karpeg);
                }

                $emailPribadi->karpeg = $request->file('karpeg')->store('email-pribadi/karpeg', 'local');
            }

            $isUbahAkun = $validated['jenis_layanan'] === 'ubah_akun';

            $emailPribadi->update([
                'nama' => $validated['nama'],

                'nip' => $validated['nip'],

                'jabatan' => $validated['jabatan'],

                'pangkat_gol' => $validated['pangkat_gol'],

                'email' => $validated['email'],

                'no_hp' => $validated['no_hp'],

                'nama_instansi' => $validated['nama_instansi'],

                'nama_kadis' => $validated['nama_kadis'],

                'jabatan_kadis' => $validated['jabatan_kadis'],

                'nip_kadis' => $validated['nip_kadis'],

                'nama_akun' => $akunEmail,

                'nama_akun_baru' => $isUbahAkun ? $akunEmailBaru : null,

                'pengajuan' => $validated['pengajuan'],

                'jenis_layanan' => $validated['jenis_layanan'],

                'karpeg' => $request->hasFile('karpeg') ? $emailPribadi->karpeg : $emailPribadi->getOriginal('karpeg'),
            ]);

            return redirect()->route('email-pribadi.show', $emailPribadi)->with('success', 'Pengajuan Email Pribadi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengajuan. ' . $e->getMessage());
        }
    }

    public function cetak(EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.email-pribadi.cetak', compact('emailPribadi'));

        return $pdf->stream('Formulir-Email-Pribadi-' . $emailPribadi->nomor_tiket . '.pdf');
    }

    public function uploadFormulir(Request $request, EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'formulir_email' => 'required|mimes:pdf|max:5120',
        ]);

        $file = $request->file('formulir_email')->store('email-pribadi/formulir', 'local');

        $emailPribadi->update([
            'formulir_email' => $file,
            'status' => 'baru',
        ]);

        return back()->with('success', 'Formulir berhasil diupload.');
    }

    public function downloadFormulir(EmailPribadi $emailPribadi)
    {
        if ($emailPribadi->user_id != auth()->id()) {
            abort(403);
        }

        $path = Storage::disk('local')->path($emailPribadi->formulir_email);

        return response()->file($path, [
            'Content-Disposition' => 'inline',
        ]);
    }
}
