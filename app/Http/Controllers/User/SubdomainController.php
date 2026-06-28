<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subdomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SubdomainController extends Controller
{
    // public function index()
    // {
    //     return view('user.subdomain.index');
    // }

    public function create()
    {
        return view('user.subdomain.create');
    }

    public function store(Request $request, TicketService $ticketService)
    {
        $validated = $request->validate(
            [
                'nama_subdomain' => ['required', 'regex:/^(?!-)[a-z0-9-]+(?<!-)$/'],
                'nama_subdomain_baru' => $request->jenis_layanan == 'ubah_subdomain' ? ['required', 'regex:/^(?!-)[a-z0-9-]+(?<!-)$/'] : ['nullable'],
                'deskripsi_website' => 'required',

                'nama_penanggung_jawab' => 'required',
                'nip_penanggung_jawab' => 'required|min:18',
                'jabatan' => 'required',
                'pangkat_gol' => 'required',
                'no_hp' => 'required|min:12',
                'email' => 'required|email',

                'nama_penanggung_jawab_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
                'nip_penanggung_jawab_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|min:18',
                'jabatan_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
                'pangkat_gol_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
                'no_hp_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|min:12',
                'email_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|email',

                'nama_instansi' => 'required',

                'jenis_layanan' => 'required|in:baru,ubah_penanggung,ubah_subdomain,nonaktif',

                'nama_kadis' => 'required',
                'nip_kadis' => 'required|min:18',
                'jabatan_kadis' => 'required',

                'karpeg' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',

                'terms' => 'accepted',
            ],
            [
                'nama_instansi.required' => 'Nama instansi wajib diisi.',
                'nama_subdomain.required' => 'Nama subdomain wajib diisi.',
                'nama_subdomain.regex' => 'Nama subdomain hanya boleh huruf kecil, angka dan tanda hubung (-).',
                'deskripsi_website.required' => 'Deskripsi website wajib diisi.',
                'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan terlebih dahulu.',
            ],
        );

        try {
            $fullSubdomain = strtolower(trim($validated['nama_subdomain'])) . '.murungrayakab.go.id';

            $fullSubdomainBaru = null;

            if ($validated['jenis_layanan'] === 'ubah_subdomain' && !empty($validated['nama_subdomain_baru'])) {
                $fullSubdomainBaru = strtolower(trim($validated['nama_subdomain_baru'])) . '.murungrayakab.go.id';
            }

            $exists = Subdomain::where(function ($query) use ($fullSubdomain, $fullSubdomainBaru) {
                $query->where('nama_subdomain', $fullSubdomain);

                if ($fullSubdomainBaru) {
                    $query->orWhere('nama_subdomain_baru', $fullSubdomainBaru);
                }
            })
                ->whereNotIn('status', ['selesai', 'tutup'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nama_subdomain' => 'Nama subdomain sedang digunakan pada pengajuan lain.',
                    ]);
            }

            // Upload SK Pegawai ke private storage
            $pathKarpeg = $request->file('karpeg')->store('subdomain/karpeg', 'local');

            $isUbahPenanggung = $request->jenis_layanan === 'ubah_penanggung';

            $subdomain = Subdomain::create([
                'user_id' => Auth::id(),

                'nama_subdomain' => $fullSubdomain,
                'nama_subdomain_baru' => $fullSubdomainBaru,
                'deskripsi_website' => $validated['deskripsi_website'],

                'nama_penanggung_jawab' => $validated['nama_penanggung_jawab'],
                'nip_penanggung_jawab' => $validated['nip_penanggung_jawab'],
                'jabatan' => $validated['jabatan'],
                'pangkat_gol' => $validated['pangkat_gol'],
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'],

                'nama_penanggung_jawab_baru' => $isUbahPenanggung ? $validated['nama_penanggung_jawab_baru'] : null,
                'nip_penanggung_jawab_baru' => $isUbahPenanggung ? $validated['nip_penanggung_jawab_baru'] : null,
                'jabatan_baru' => $isUbahPenanggung ? $validated['jabatan_baru'] : null,
                'pangkat_gol_baru' => $isUbahPenanggung ? $validated['pangkat_gol_baru'] : null,
                'no_hp_baru' => $isUbahPenanggung ? $validated['no_hp_baru'] : null,
                'email_baru' => $isUbahPenanggung ? $validated['email_baru'] : null,

                'nama_instansi' => $validated['nama_instansi'],
                'jenis_layanan' => $validated['jenis_layanan'],

                'nama_kadis' => $validated['nama_kadis'],
                'nip_kadis' => $validated['nip_kadis'],
                'jabatan_kadis' => $validated['jabatan_kadis'],

                'karpeg' => $pathKarpeg,

                'status' => 'terbuka',
                'nomor_tiket' => $ticketService->generateSubdomainTicket(),
            ]);

            return redirect()->route('subdomain.success', $subdomain->id);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function success(Subdomain $subdomain)
    {
        if ($subdomain->user_id != auth()->id()) {
            abort(403);
        }

        return view('user.pengajuan.success', compact('subdomain'));
    }

    public function show(Subdomain $subdomain)
    {
        if ($subdomain->user_id != auth()->id()) {
            abort(403);
        }

        return view('user.subdomain.show', compact('subdomain'));
    }

    public function edit(Subdomain $subdomain)
    {
        if ($subdomain->user_id != auth()->id()) {
            abort(403);
        }

        if ($subdomain->formulir_subdomain) {
            return redirect()->route('subdomain.show', $subdomain)->with('error', 'Pengajuan tidak dapat diubah karena formulir telah diupload.');
        }

        return view('user.subdomain.edit', compact('subdomain'));
    }

    public function update(Request $request, Subdomain $subdomain)
    {
        if ($subdomain->user_id != Auth::id()) {
            abort(403);
        }

        // Tidak boleh edit jika formulir sudah diupload
        if ($subdomain->formulir_subdomain) {
            return redirect()->route('subdomain.show', $subdomain)->with('error', 'Pengajuan tidak dapat diubah karena formulir telah diupload.');
        }

        $validated = $request->validate([
            'nama_subdomain' => ['required', 'regex:/^(?!-)[a-z0-9-]+(?<!-)$/'],

            'nama_subdomain_baru' => $request->jenis_layanan == 'ubah_subdomain' ? ['required', 'regex:/^(?!-)[a-z0-9-]+(?<!-)$/'] : ['nullable'],

            'deskripsi_website' => 'required',

            'nama_penanggung_jawab' => 'required',
            'nip_penanggung_jawab' => 'required|digits:18',
            'jabatan' => 'required',
            'pangkat_gol' => 'required',
            'no_hp' => 'required|digits_between:10,15',
            'email' => 'required|email',

            'nama_penanggung_jawab_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
            'nip_penanggung_jawab_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|min:18',
            'jabatan_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
            'pangkat_gol_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung',
            'no_hp_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|min:12',
            'email_baru' => 'nullable|required_if:jenis_layanan,ubah_penanggung|email',
            'nama_instansi' => 'required',
            'jenis_layanan' => 'required|in:baru,ubah_penanggung,ubah_subdomain,nonaktif',
            'nama_kadis' => 'required',
            'nip_kadis' => 'required|min:18',
            'jabatan_kadis' => 'required',

            // nullable karena edit
            'karpeg' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $fullSubdomain = strtolower(trim($validated['nama_subdomain'])) . '.murungrayakab.go.id';

            $fullSubdomainBaru = null;

            if ($validated['jenis_layanan'] === 'ubah_subdomain' && !empty($validated['nama_subdomain_baru'])) {
                $fullSubdomainBaru = strtolower(trim($validated['nama_subdomain_baru'])) . '.murungrayakab.go.id';
            }

            // cek duplikat kecuali data sendiri
            $exists = Subdomain::where(function ($query) use ($fullSubdomain, $fullSubdomainBaru) {
                $query->where('nama_subdomain', $fullSubdomain);

                if ($fullSubdomainBaru) {
                    $query->orWhere('nama_subdomain_baru', $fullSubdomainBaru);
                }
            })
                ->where('id', '!=', $subdomain->id)
                ->whereNotIn('status', ['selesai', 'tutup'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nama_subdomain' => 'Nama subdomain sedang digunakan pada pengajuan lain.',
                    ]);
            }

            // upload karpeg baru jika ada
            if ($request->hasFile('karpeg')) {
                if ($subdomain->karpeg && Storage::disk('local')->exists($subdomain->karpeg)) {
                    Storage::disk('local')->delete($subdomain->karpeg);
                }

                $subdomain->karpeg = $request->file('karpeg')->store('subdomain/karpeg', 'local');
            }

            $isUbahPenanggung = $validated['jenis_layanan'] === 'ubah_penanggung';

            $subdomain->update([
                'nama_subdomain' => $fullSubdomain,
                'nama_subdomain_baru' => $fullSubdomainBaru,

                'deskripsi_website' => $validated['deskripsi_website'],

                'nama_penanggung_jawab' => $validated['nama_penanggung_jawab'],
                'nip_penanggung_jawab' => $validated['nip_penanggung_jawab'],
                'jabatan' => $validated['jabatan'],
                'pangkat_gol' => $validated['pangkat_gol'],
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'],

                'nama_penanggung_jawab_baru' => $isUbahPenanggung ? $validated['nama_penanggung_jawab_baru'] : null,
                'nip_penanggung_jawab_baru' => $isUbahPenanggung ? $validated['nip_penanggung_jawab_baru'] : null,
                'jabatan_baru' => $isUbahPenanggung ? $validated['jabatan_baru'] : null,
                'pangkat_gol_baru' => $isUbahPenanggung ? $validated['pangkat_gol_baru'] : null,
                'no_hp_baru' => $isUbahPenanggung ? $validated['no_hp_baru'] : null,
                'email_baru' => $isUbahPenanggung ? $validated['email_baru'] : null,

                'nama_instansi' => $validated['nama_instansi'],
                'jenis_layanan' => $validated['jenis_layanan'],

                'nama_kadis' => $validated['nama_kadis'],
                'nip_kadis' => $validated['nip_kadis'],
                'jabatan_kadis' => $validated['jabatan_kadis'],

                'karpeg' => $validated['karpeg'] ?? $subdomain->karpeg,
            ]);

            return redirect()->route('subdomain.show', $subdomain)->with('success', 'Data pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function cetak(Subdomain $subdomain)
    {
        if ($subdomain->user_id != auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.subdomain.cetak', compact('subdomain'));

        return $pdf->stream('Formulir-Subdomain-' . $subdomain->nomor_tiket . '.pdf');
    }

    public function uploadFormulir(Request $request, Subdomain $subdomain)
    {
        $request->validate([
            'formulir_subdomain' => 'required|mimes:pdf|max:5120',
        ]);

        $file = $request->file('formulir_subdomain')->store('subdomain/formulir', 'local');

        $subdomain->update([
            'formulir_subdomain' => $file,
            'status' => 'baru',
        ]);

        return back()->with('success', 'Formulir berhasil diupload');
    }

    public function downloadFormulir(Subdomain $subdomain)
    {
        if ($subdomain->user_id != auth()->id()) {
            abort(403);
        }

        $path = Storage::disk('local')->path($subdomain->formulir_subdomain);

        return response()->file($path, [
            'Content-Disposition' => 'inline',
        ]);
    }

    public function downloadSkPenunjukan(Subdomain $subdomain)
    {
        abort_if(!$subdomain->surat_penunjukan, 404);

        $path = Storage::disk('local')->path($subdomain->surat_penunjukan);

        if (!file_exists($path)) {
            abort(404, 'File Surat Penunjukan tidak ditemukan.');
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline',
        ]);
    }
}
