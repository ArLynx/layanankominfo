<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailSatker;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class EmailSatkerController extends Controller
{
    public function create()
    {
        return view('user.email-satker.create');
    }

    public function store(Request $request, TicketService $ticketService)
    {
        $validated = $request->validate(
            [
                'nama_instansi' => 'required',

                'nama_akun_dinas' => ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'],

                'nama_akun_dinas_baru' => $request->jenis_layanan == 'ubah_akun' ? ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'] : ['nullable'],

                'nama_penanggung_jawab' => 'required',
                'nip' => 'required|min:18',
                'jabatan' => 'required',
                'pangkat_gol' => 'required',
                'no_hp' => 'required|min:12',
                'email' => 'required|email',

                'nama_penanggung_jawab_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',

                'nip_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|min:18',

                'jabatan_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',

                'pangkat_gol_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',

                'no_hp_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|min:12',

                'email_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|email',

                'jenis_layanan' => 'required|in:baru,reset,reaktivasi,ubah_akun,ubah_penanggung',

                'nama_kadis' => 'required',
                'jabatan_kadis' => 'required',
                'nip_kadis' => 'required|min:18',

                'karpeg' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',

                'terms' => 'accepted',
            ],

            [
                'nama_instansi.required' => 'Nama instansi wajib diisi.',

                'nama_akun_dinas.required' => 'Nama akun email wajib diisi.',

                'nama_akun_dinas.regex' => 'Nama akun email hanya boleh huruf kecil, angka, titik (.), underscore (_) dan tanda hubung (-).',

                'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan terlebih dahulu.',
            ],
        );

        try {
            $akunEmail = strtolower(trim($validated['nama_akun_dinas'])) . '@murungrayakab.go.id';

            $akunEmailBaru = null;

            if ($validated['jenis_layanan'] === 'ubah_akun' && !empty($validated['nama_akun_dinas_baru'])) {
                $akunEmailBaru = strtolower(trim($validated['nama_akun_dinas_baru'])) . '@murungrayakab.go.id';
            }

            $akunList = array_filter([$akunEmail, $akunEmailBaru]);

            $exists = EmailSatker::where(function ($query) use ($akunList) {
                foreach ($akunList as $akun) {
                    $query->orWhere('nama_akun_dinas', $akun)->orWhere('nama_akun_dinas_baru', $akun);
                }
            })
                ->whereNotIn('status', ['selesai', 'tutup'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nama_akun_dinas' => 'Pengajuan email dengan nama akun tersebut masih dalam proses. Silakan tunggu hingga pengajuan sebelumnya selesai.',
                    ]);
            }

            $pathKarpeg = $request->file('karpeg')->store('email-satker/karpeg', 'local');

            $isUbahPenanggung = $request->jenis_layanan === 'ubah_penanggung';

            $isUbahAkun = $request->jenis_layanan === 'ubah_akun';

            $emailSatker = EmailSatker::create([
                'user_id' => Auth::id(),

                // Data Instansi
                'nama_instansi' => $validated['nama_instansi'],

                // Data Akun
                'nama_akun_dinas' => $akunEmail,

                'nama_akun_dinas_baru' => $isUbahAkun ? $akunEmailBaru : null,

                // Data Penanggung Jawab
                'nama_penanggung_jawab' => $validated['nama_penanggung_jawab'],
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'],
                'pangkat_gol' => $validated['pangkat_gol'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],

                // Data Penanggung Jawab Baru
                'nama_penanggung_jawab_baru' => $isUbahPenanggung ? $validated['nama_penanggung_jawab_baru'] : null,

                'nip_baru' => $isUbahPenanggung ? $validated['nip_baru'] : null,

                'jabatan_baru' => $isUbahPenanggung ? $validated['jabatan_baru'] : null,

                'pangkat_gol_baru' => $isUbahPenanggung ? $validated['pangkat_gol_baru'] : null,

                'email_baru' => $isUbahPenanggung ? $validated['email_baru'] : null,

                'no_hp_baru' => $isUbahPenanggung ? $validated['no_hp_baru'] : null,

                // Jenis Layanan
                'jenis_layanan' => $validated['jenis_layanan'],

                // Kepala Instansi
                'nama_kadis' => $validated['nama_kadis'],
                'jabatan_kadis' => $validated['jabatan_kadis'],
                'nip_kadis' => $validated['nip_kadis'],

                // Dokumen
                'karpeg' => $pathKarpeg,

                // Status
                'status' => 'terbuka',

                // Nomor Tiket
                'nomor_tiket' => $ticketService->generateEmailSatkerTicket(),
            ]);

            return redirect()->route('email-satker.success', $emailSatker->id);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function success(EmailSatker $emailSatker)
    {
        if ($emailSatker->user_id != auth()->id()) {
            abort(403);
        }

        return view('user.pengajuan.success', compact('emailSatker'));
    }

    public function show(EmailSatker $emailSatker)
    {
        if ($emailSatker->user_id != auth()->id()) {
            abort(403);
        }

        return view('user.email-satker.show', compact('emailSatker'));
    }

    public function edit(EmailSatker $emailSatker)
    {
        if ($emailSatker->user_id != auth()->id()) {
            abort(403);
        }

        if ($emailSatker->formulir_email) {
            return redirect()->route('email-satker.show', $emailSatker)->with('error', 'Pengajuan tidak dapat diubah karena formulir telah diupload.');
        }

        return view('user.email-satker.edit', compact('emailSatker'));
    }

    public function update(Request $request, EmailSatker $emailSatker)
    {
        if ($emailSatker->user_id != Auth::id()) {
            abort(403);
        }

        // Tidak boleh edit jika formulir sudah diupload
        if ($emailSatker->formulir_email) {
            return redirect()->route('email-satker.show', $emailSatker)->with('error', 'Pengajuan tidak dapat diubah karena formulir telah diupload.');
        }

        $validated = $request->validate([
            'nama_instansi' => 'required',

            'nama_akun_dinas' => ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'],

            'nama_akun_dinas_baru' => $request->jenis_layanan == 'ubah_akun' ? ['required', 'regex:/^(?!.*@)[a-z0-9._-]+$/'] : ['nullable'],

            'nama_penanggung_jawab' => 'required',
            'nip' => 'required|digits:18',
            'jabatan' => 'required',
            'pangkat_gol' => 'required',
            'no_hp' => 'required|digits_between:10,15',
            'email' => 'required|email',

            'nama_penanggung_jawab_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
            'nip_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|digits:18',
            'jabatan_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
            'pangkat_gol_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
            'no_hp_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|digits_between:10,15',
            'email_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|email',

            'jenis_layanan' => 'required|in:baru,reset,reaktivasi,ubah_akun,ubah_penanggung',

            'nama_kadis' => 'required',
            'jabatan_kadis' => 'required',
            'nip_kadis' => 'required|digits:18',

            // nullable karena edit
            'karpeg' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $akunEmail = strtolower(trim($validated['nama_akun_dinas'])) . '@murungrayakab.go.id';

            $akunEmailBaru = null;

            if ($validated['jenis_layanan'] === 'ubah_akun' && !empty($validated['nama_akun_dinas_baru'])) {
                $akunEmailBaru = strtolower(trim($validated['nama_akun_dinas_baru'])) . '@murungrayakab.go.id';
            }

            // cek duplikat kecuali data sendiri
            $akunList = array_filter([$akunEmail, $akunEmailBaru]);

            $exists = EmailSatker::where(function ($query) use ($akunList) {
                foreach ($akunList as $akun) {
                    $query->orWhere('nama_akun_dinas', $akun)->orWhere('nama_akun_dinas_baru', $akun);
                }
            })
                ->where('id', '!=', $emailSatker->id)
                ->whereNotIn('status', ['selesai', 'tutup'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nama_akun_dinas' => 'Pengajuan email dengan nama akun tersebut masih dalam proses. Silakan tunggu hingga pengajuan sebelumnya selesai.',
                    ]);
            }

            // Upload KARPEG baru jika ada
            if ($request->hasFile('karpeg')) {
                if ($emailSatker->karpeg && Storage::disk('local')->exists($emailSatker->karpeg)) {
                    Storage::disk('local')->delete($emailSatker->karpeg);
                }

                $emailSatker->karpeg = $request->file('karpeg')->store('email-satker/karpeg', 'local');
            }

            $isUbahPenanggung = $validated['jenis_layanan'] === 'ubah_penanggung';

            $isUbahAkun = $validated['jenis_layanan'] === 'ubah_akun';

            $emailSatker->update([
                'nama_instansi' => $validated['nama_instansi'],

                'nama_akun_dinas' => $akunEmail,

                'nama_akun_dinas_baru' => $isUbahAkun ? $akunEmailBaru : null,

                'nama_penanggung_jawab' => $validated['nama_penanggung_jawab'],
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'],
                'pangkat_gol' => $validated['pangkat_gol'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],

                'nama_penanggung_jawab_baru' => $isUbahPenanggung ? $validated['nama_penanggung_jawab_baru'] : null,
                'nip_baru' => $isUbahPenanggung ? $validated['nip_baru'] : null,
                'jabatan_baru' => $isUbahPenanggung ? $validated['jabatan_baru'] : null,
                'pangkat_gol_baru' => $isUbahPenanggung ? $validated['pangkat_gol_baru'] : null,
                'email_baru' => $isUbahPenanggung ? $validated['email_baru'] : null,
                'no_hp_baru' => $isUbahPenanggung ? $validated['no_hp_baru'] : null,

                'jenis_layanan' => $validated['jenis_layanan'],

                'nama_kadis' => $validated['nama_kadis'],
                'jabatan_kadis' => $validated['jabatan_kadis'],
                'nip_kadis' => $validated['nip_kadis'],

                'karpeg' => $validated['karpeg'] ?? $emailSatker->karpeg,
            ]);

            return redirect()->route('email-satker.show', $emailSatker)->with('success', 'Data pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function cetak(EmailSatker $emailSatker)
    {
        if ($emailSatker->user_id != auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.email-satker.cetak', compact('emailSatker'));

        return $pdf->stream('Formulir-Email-Satker-' . $emailSatker->nomor_tiket . '.pdf');
    }

    public function uploadFormulir(Request $request, EmailSatker $emailSatker)
    {
        $request->validate([
            'formulir_email' => 'required|mimes:pdf|max:5120',
        ]);

        $file = $request->file('formulir_email')->store('email-satker/formulir', 'local');

        $emailSatker->update([
            'formulir_email' => $file,

            'status' => 'baru',
        ]);

        return back()->with('success', 'Formulir berhasil diupload.');
    }

    public function downloadFormulir(EmailSatker $emailSatker)
    {
        if ($emailSatker->user_id != auth()->id()) {
            abort(403);
        }

        $path = Storage::disk('local')->path($emailSatker->formulir_email);

        return response()->file($path, [
            'Content-Disposition' => 'inline',
        ]);
    }
}
