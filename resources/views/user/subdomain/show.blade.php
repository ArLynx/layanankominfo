@extends('user.layouts.app')

@section('content')

    <main class="flex-grow w-full mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
        <div class="w-full max-w-[1700px] mx-auto px-4">

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-2xl font-bold mb-6">
                    Detail Pengajuan Subdomain
                </h2>


                {{-- ================= INFORMASI PENGAJUAN ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">

                            confirmation_number

                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">

                            Informasi Pengajuan

                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <p class="text-sm text-gray-500">
                                Nomor Tiket
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->nomor_tiket }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Status Pengajuan
                            </p>

                            <p class="font-semibold">

                                @switch($subdomain->status)
                                    @case('terbuka')
                                        Pengajuan
                                    @break

                                    @case('baru')
                                        Pemeriksaan Dokumen
                                    @break

                                    @case('tunda')
                                        Persetujuan Pimpinan
                                    @break

                                    @case('diproses')
                                        Proses Pembuatan
                                    @break

                                    @case('selesai')
                                        Selesai
                                    @break

                                    @case('tutup')
                                        Pengajuan Dibatalkan
                                    @break
                                @endswitch

                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Jenis Layanan
                            </p>

                            <p class="font-semibold">

                                @switch($subdomain->jenis_layanan)
                                    @case('baru')
                                        Pengajuan Subdomain Baru
                                    @break

                                    @case('ubah_penanggung')
                                        Perubahan Penanggung Jawab
                                    @break

                                    @case('ubah_subdomain')
                                        Perubahan Nama Subdomain
                                    @break

                                    @case('nonaktif')
                                        Penonaktifan Subdomain
                                    @break
                                @endswitch

                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Tanggal Pengajuan
                            </p>

                            <p class="font-semibold">

                                {{ $subdomain->created_at->locale('id')->translatedFormat('d F Y') }}

                            </p>

                        </div>

                    </div>

                </div>

                {{-- ================= DATA SUBDOMAIN ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">

                            dns

                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">

                            Data Subdomain

                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- Nama Subdomain --}}
                        @if ($subdomain->jenis_layanan == 'ubah_subdomain')
                            <div>
                                <p class="text-sm text-gray-500">
                                    Nama Subdomain Lama
                                </p>
                                <p class="font-semibold">
                                    {{ $subdomain->nama_subdomain }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    Nama Subdomain Baru
                                </p>
                                <p class="font-semibold">
                                    {{ $subdomain->nama_subdomain_baru }}
                                </p>
                            </div>
                        @else
                            <div class="md:col-span-2">

                                <p class="text-sm text-gray-500">
                                    Nama Subdomain
                                </p>
                                <p class="font-semibold">
                                    {{ $subdomain->nama_subdomain }}
                                </p>

                            </div>
                        @endif

                        {{-- Deskripsi Website --}}
                        @php
                            $judulDeskripsi = match ($subdomain->jenis_layanan) {
                                'ubah_penanggung' => 'Alasan Perubahan Penanggung Jawab',
                                'ubah_subdomain' => 'Alasan Perubahan Nama Subdomain',
                                'nonaktif' => 'Alasan Penonaktifan Subdomain',
                                default => 'Deskripsi Website',
                            };
                        @endphp

                        <div class="md:col-span-2">

                            <p class="text-sm text-gray-500 mb-2">
                                {{ $judulDeskripsi }}
                            </p>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-4">

                                <p class="text-gray-800 whitespace-pre-line break-words leading-7">

                                    {{ $subdomain->deskripsi_website }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================= DATA PENANGGUNG JAWAB ================= --}}

                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">

                            badge

                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">

                            @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                                Data Penanggung Jawab Lama
                            @else
                                Data Penanggung Jawab
                            @endif

                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- Nama --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Nama Penanggung Jawab
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->nama_penanggung_jawab }}
                            </p>

                        </div>

                        {{-- NIP --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                NIP
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->nip_penanggung_jawab }}
                            </p>

                        </div>

                        {{-- Jabatan --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Jabatan
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->jabatan }}
                            </p>

                        </div>

                        {{-- Pangkat --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Pangkat / Golongan
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->pangkat_gol }}
                            </p>

                        </div>

                        {{-- No HP --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Nomor HP
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->no_hp }}
                            </p>

                        </div>

                        {{-- Email --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Email
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->email }}
                            </p>

                        </div>

                        {{-- Instansi --}}
                        <div class="md:col-span-2">

                            <p class="text-sm text-gray-500">
                                Instansi / Unit Kerja
                            </p>

                            <p class="font-semibold">
                                {{ $subdomain->nama_instansi }}
                            </p>

                        </div>

                    </div>

                </div>

                @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                    <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                        <div class="flex items-center gap-3 mb-6">

                            <span class="material-symbols-outlined text-3xl text-on-surface">

                                manage_accounts

                            </span>

                            <h3 class="text-xl font-semibold text-on-surface">

                                Data Penanggung Jawab Baru

                            </h3>

                        </div>



                        <div class="grid md:grid-cols-2 gap-6">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Nama Penanggung Jawab Baru
                                </p>

                                <p class="font-semibold">
                                    {{ $subdomain->nama_penanggung_jawab_baru }}
                                </p>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    NIP
                                </p>

                                <p class="font-semibold">
                                    {{ $subdomain->nip_penanggung_jawab_baru }}
                                </p>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    Jabatan
                                </p>

                                <p class="font-semibold">
                                    {{ $subdomain->jabatan_baru }}
                                </p>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    Pangkat / Golongan
                                </p>

                                <p class="font-semibold">
                                    {{ $subdomain->pangkat_gol_baru }}
                                </p>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    Nomor HP
                                </p>

                                <p class="font-semibold">
                                    {{ $subdomain->no_hp_baru }}
                                </p>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    Email
                                </p>

                                <p class="font-semibold">
                                    {{ $subdomain->email_baru }}
                                </p>

                            </div>

                        </div>

                    </div>
                @endif

                {{-- ================= DATA PIMPINAN ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">

                            account_balance

                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">

                            Data Pimpinan

                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <p class="text-sm text-gray-500">
                                Nama Pimpinan
                            </p>

                            <p class="font-semibold">

                                {{ $subdomain->nama_kadis }}

                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Jabatan
                            </p>

                            <p class="font-semibold">

                                {{ $subdomain->jabatan_kadis }}

                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                NIP
                            </p>

                            <p class="font-semibold">

                                {{ $subdomain->nip_kadis }}

                            </p>

                        </div>

                    </div>

                </div>

                {{-- ================= CATATAN ADMIN ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">

                            sticky_note_2

                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">

                            Catatan Admin

                        </h3>

                    </div>

                    @if ($subdomain->catatan_admin)
                        <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-5">

                            <div class="flex gap-3">

                                <span class="material-symbols-outlined text-yellow-600">

                                    info

                                </span>

                                <div>

                                    <p class="font-semibold text-yellow-800">

                                        Informasi dari Admin

                                    </p>

                                    <p class="mt-2 text-yellow-700 whitespace-pre-line">

                                        {{ $subdomain->catatan_admin }}

                                    </p>

                                </div>

                            </div>

                        </div>
                    @else
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">

                            <p class="text-gray-500 italic">

                                Belum terdapat catatan dari admin.

                            </p>

                        </div>
                    @endif

                </div>

                <div class="mt-8 rounded-xl border border-amber-300 bg-amber-50 p-6">

                    <div class="flex gap-4">

                        <span class="material-symbols-outlined text-amber-600 text-5xl">

                            fact_check

                        </span>

                        <div class="flex-1">

                            <h3 class="text-xl font-bold text-amber-800">

                                Periksa Kembali Data Pengajuan

                            </h3>

                            <p class="mt-2 text-amber-700 leading-relaxed">

                                Sebelum mencetak formulir, pastikan seluruh data pengajuan telah sesuai.

                                Formulir yang dicetak akan digunakan sebagai dokumen resmi
                                dan harus ditandatangani oleh pimpinan.

                            </p>

                            <div class="mt-5 rounded-lg bg-white border border-amber-200 p-5">

                                <p class="font-semibold text-red-600">

                                    Pastikan data berikut sudah benar:

                                </p>

                                <ul class="mt-3 space-y-2 text-sm text-gray-700">

                                    <li>✔ Nama Subdomain</li>

                                    @if ($subdomain->jenis_layanan == 'ubah_subdomain')
                                        <li>✔ Nama Subdomain Baru</li>
                                    @endif

                                    <li>✔ Jenis Layanan</li>

                                    <li>✔ Nama Penanggung Jawab</li>

                                    @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                                        <li>✔ Data Penanggung Jawab Baru</li>
                                    @endif

                                    <li>✔ NIP Penanggung Jawab</li>

                                    <li>✔ Jabatan Penanggung Jawab</li>

                                    <li>✔ Pangkat / Golongan</li>

                                    <li>✔ Nomor HP</li>

                                    <li>✔ Email</li>

                                    <li>✔ Nama Instansi</li>

                                    <li>✔ Nama, NIP dan Jabatan Pimpinan</li>

                                </ul>

                            </div>

                            <div class="mt-5 rounded-lg border border-red-300 bg-red-50 p-4">

                                <p class="text-red-700 text-sm">

                                    <strong>Perhatian:</strong>

                                    Setelah formulir dicetak, ditandatangani,
                                    dan diunggah kembali ke sistem,
                                    data pengajuan tidak dapat diubah lagi.

                                </p>

                            </div>

                            <div class="flex flex-wrap gap-3 mt-8">
                                @if (!$subdomain->formulir_subdomain)
                                    <a href="{{ route('subdomain.edit', $subdomain) }}"
                                        class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium transition">
                                        <span class="material-symbols-outlined text-xl">
                                            edit_square
                                        </span>
                                        Edit Data
                                    </a>
                                @endif
                                <button type="button" onclick="openCetakModal()"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-primary hover:bg-primary-hover text-white font-medium transition">
                                    <span class="material-symbols-outlined">
                                        print
                                    </span>
                                    Cetak Formulir
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ========================================================= --}}
                {{-- MODAL KONFIRMASI CETAK FORMULIR --}}
                {{-- ========================================================= --}}

                <div id="modalCetak" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-5">

                    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl">

                        {{-- Header --}}
                        <div class="border-b px-6 py-5 flex items-center gap-3">

                            <span class="material-symbols-outlined text-amber-500 text-4xl">

                                warning

                            </span>

                            <div>

                                <h3 class="text-xl font-bold">

                                    Konfirmasi Cetak Formulir

                                </h3>

                                <p class="text-sm text-gray-500">

                                    Mohon pastikan seluruh data sudah benar.

                                </p>

                            </div>

                        </div>

                        {{-- Body --}}
                        <div class="p-6">

                            <div class="rounded-xl bg-blue-50 border border-blue-200 p-4">

                                <p class="font-semibold text-blue-800 mb-3">

                                    Ringkasan Pengajuan

                                </p>

                                <div class="space-y-2 text-sm">

                                    <div class="flex justify-between">

                                        <span>Nomor Tiket</span>

                                        <strong>{{ $subdomain->nomor_tiket }}</strong>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>Nama Subdomain</span>

                                        <strong>{{ $subdomain->nama_subdomain }}</strong>

                                    </div>

                                    @if ($subdomain->jenis_layanan == 'ubah_subdomain')
                                        <div class="flex justify-between">

                                            <span>Nama Subdomain Baru</span>

                                            <strong>{{ $subdomain->nama_subdomain_baru }}</strong>

                                        </div>
                                    @endif

                                    <div class="flex justify-between">

                                        <span>Penanggung Jawab</span>

                                        <strong>{{ $subdomain->nama_penanggung_jawab }}</strong>

                                    </div>

                                    @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                                        <div class="flex justify-between">

                                            <span>Penanggung Jawab Baru</span>

                                            <strong>{{ $subdomain->nama_penanggung_jawab_baru }}</strong>

                                        </div>
                                    @endif

                                    <div class="flex justify-between">

                                        <span>NIP</span>

                                        <strong>{{ $subdomain->nip_penanggung_jawab }}</strong>

                                    </div>

                                    @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                                        <div class="flex justify-between">

                                            <span>NIP Baru</span>

                                            <strong>{{ $subdomain->nip_penanggung_jawab_baru }}</strong>

                                        </div>
                                    @endif

                                </div>

                            </div>

                            <div class="mt-5 rounded-xl border border-red-300 bg-red-50 p-4">

                                <p class="text-red-700 text-sm leading-relaxed">

                                    <strong>Perhatian!</strong>

                                    Setelah formulir dicetak,
                                    ditandatangani,
                                    kemudian diupload kembali ke sistem,

                                    <strong>data pengajuan tidak dapat diubah lagi.</strong>

                                </p>

                            </div>

                            <label class="flex items-start gap-3 mt-5">

                                <input id="checkCetak" type="checkbox" class="mt-1 h-5 w-5">

                                <span class="text-sm">

                                    Saya telah memeriksa seluruh data pengajuan dan
                                    bertanggung jawab atas kebenaran data yang saya isi.

                                </span>

                            </label>

                        </div>

                        {{-- Footer --}}
                        <div class="border-t px-6 py-4 flex justify-end gap-3">

                            <button onclick="closeCetakModal()" class="px-5 py-2 rounded-lg border">

                                Batal

                            </button>

                            <a id="btnCetak" href="{{ route('subdomain.cetak', $subdomain) }}" target="_blank"
                                onclick="closeCetakModal()"
                                class="px-5 py-2 rounded-lg bg-primary text-white opacity-50 pointer-events-none">

                                Ya, Cetak Formulir

                            </a>

                        </div>

                    </div>

                </div>

                <br>

                <div class="mb-4 rounded-lg border border-amber-300 bg-amber-50 p-4">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-amber-600">
                            info
                        </span>

                        <div>

                            <p class="font-semibold text-amber-800">
                                Petunjuk Upload
                            </p>

                            <ul class="mt-2 text-sm text-amber-700 list-disc list-inside space-y-1">
                                <li>Cetak formulir yang telah diunduh.</li>
                                <li>Mintakan tanda tangan pimpinan.</li>
                                <li>Scan formulir dalam format PDF.</li>
                                <li>Upload formulir yang telah ditandatangani.</li>
                                @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                                    <li class="text-red-600 font-medium">
                                        Upload Surat Penunjukan Penanggung Jawab sebelumnya sebagai dokumen pendukung.
                                    </li>
                                @endif
                            </ul>

                        </div>

                    </div>

                </div>

                @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                    <div class="mb-6 rounded-xl border border-blue-300 bg-blue-50 p-5">

                        <div class="flex items-start gap-3">

                            <span class="material-symbols-outlined text-blue-600 text-3xl">
                                description
                            </span>

                            <div>

                                <h3 class="font-semibold text-blue-800">
                                    Persyaratan Tambahan
                                </h3>

                                <p class="mt-2 text-sm text-blue-700 leading-relaxed">

                                    Untuk layanan <strong>Perubahan Penanggung Jawab</strong>,
                                    pemohon wajib mengunggah
                                    <strong>Surat Penunjukan Penanggung Jawab sebelumnya</strong>
                                    sebagai dokumen pendukung perubahan penanggung jawab subdomain.

                                </p>

                            </div>

                        </div>

                    </div>
                @endif


                @if (!$subdomain->formulir_subdomain)
                    <div class="mt-8 bg-white rounded-xl shadow p-6">

                        <div class="flex items-center gap-3 mb-5">

                            <span class="material-symbols-outlined text-primary text-3xl">
                                upload_file
                            </span>

                            <div>

                                <h3 class="text-xl font-semibold">

                                    Upload Formulir

                                </h3>

                                <p class="text-sm text-gray-500">

                                    Upload formulir yang telah dicetak dan ditandatangani oleh pimpinan.( max 5MB )

                                </p>

                            </div>

                        </div>

                        <form action="{{ route('subdomain.upload-formulir', $subdomain) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <input type="file" name="formulir_subdomain" accept=".pdf"
                                class="block w-full rounded-lg border border-gray-300 p-3">

                            @error('formulir_subdomain')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                            <button class="mt-5 bg-primary text-white px-6 py-3 rounded-lg hover:opacity-90">

                                Upload Formulir

                            </button>

                        </form>

                    </div>
                @endif

                @if ($subdomain->formulir_subdomain)
                    <div class="mt-8 bg-green-50 border border-green-300 rounded-xl p-6">

                        <div class="flex items-start gap-4">

                            <span class="material-symbols-outlined text-green-600 text-5xl">

                                verified

                            </span>

                            <div>

                                <h3 class="font-bold text-lg text-green-700">

                                    Formulir Berhasil Diupload

                                </h3>

                                <p class="mt-2 text-green-700">

                                    Formulir yang telah ditandatangani berhasil diupload.

                                    Pengajuan Anda akan diproses oleh Admin Diskominfo.

                                </p>

                                <a href="{{ route('subdomain.download-formulir', $subdomain) }}" target="_blank"
                                    class="inline-flex items-center gap-2 mt-5 px-5 py-3 bg-green-600 text-white rounded-lg">

                                    <span class="material-symbols-outlined">

                                        download

                                    </span>

                                    Download Formulir

                                </a>

                            </div>

                        </div>

                    </div>
                @endif


                @if ($subdomain->jenis_layanan == 'ubah_penanggung' && !$subdomain->surat_penunjukan_lama)
                    <div class="mt-8 bg-white rounded-xl shadow p-6">

                        <div class="flex items-center gap-3 mb-5">

                            <span class="material-symbols-outlined text-primary text-3xl">
                                description
                            </span>

                            <div>

                                <h3 class="text-xl font-semibold">
                                    Upload Surat Penunjukan Sebelumnya
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Upload Surat Penunjukan Penanggung Jawab sebelumnya
                                    yang masih berlaku sebagai dokumen pendukung.( Mak 5 MB )
                                </p>

                            </div>

                        </div>

                        <form action="{{ route('subdomain.upload-surat-lama', $subdomain) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <input type="file" name="surat_penunjukan_lama" accept=".pdf"
                                class="block w-full rounded-lg border border-gray-300 p-3">

                            @error('surat_penunjukan_lama')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                            <button class="mt-5 bg-primary text-white px-6 py-3 rounded-lg hover:opacity-90">

                                Upload Surat Penunjukan

                            </button>

                        </form>

                    </div>
                @endif

                @if ($subdomain->jenis_layanan == 'ubah_penanggung' && $subdomain->surat_penunjukan_lama)
                    <div class="mt-8 bg-green-50 border border-green-300 rounded-xl p-6">

                        <div class="flex items-start gap-4">

                            <span class="material-symbols-outlined text-green-600 text-5xl">
                                verified
                            </span>

                            <div>

                                <h3 class="font-bold text-lg text-green-700">

                                    Surat Penunjukan Sebelumnya Berhasil Diupload

                                </h3>

                                <p class="mt-2 text-green-700">

                                    Surat Penunjukan sebelumnya berhasil diupload
                                    dan siap diverifikasi oleh Admin Diskominfo.

                                </p>

                                <a href="{{ route('subdomain.download-surat-lama', $subdomain) }}" target="_blank"
                                    class="inline-flex items-center gap-2 mt-5 px-5 py-3 bg-green-600 text-white rounded-lg">

                                    <span class="material-symbols-outlined">
                                        download
                                    </span>

                                    Download Surat Penunjukan

                                </a>

                            </div>

                        </div>

                    </div>
                @endif

                @if ($subdomain->surat_penunjukan)
                    <div class="mt-8 bg-blue-50 border border-blue-300 rounded-xl p-6">

                        <div class="flex items-start gap-4">

                            <span class="material-symbols-outlined text-blue-600 text-5xl">

                                description

                            </span>

                            <div>

                                <h3 class="font-bold text-lg text-blue-700">

                                    Surat Penunjukan Telah Tersedia

                                </h3>

                                <p class="mt-2 text-blue-700">

                                    Surat penunjukan telah diterbitkan oleh Diskominfo
                                    dan dapat diunduh melalui tombol berikut.

                                </p>

                                <a href="{{ route('subdomain.download-sk-penunjukan', $subdomain) }}" target="_blank"
                                    class="inline-flex items-center gap-2 mt-5 px-5 py-3 bg-blue-600 text-white rounded-lg">

                                    <span class="material-symbols-outlined">

                                        download

                                    </span>

                                    Download Surat Penunjukan

                                </a>

                            </div>

                        </div>

                    </div>
                @endif

            </div>
        </div>
    </main>


    <script>
        function openCetakModal() {

            const modal = document.getElementById('modalCetak');

            modal.classList.remove('hidden');

            modal.classList.add('flex');

        }

        function closeCetakModal() {

            const modal = document.getElementById('modalCetak');

            modal.classList.remove('flex');

            modal.classList.add('hidden');

        }

        document.addEventListener('DOMContentLoaded', function() {

            const checkbox = document.getElementById('checkCetak');

            const tombol = document.getElementById('btnCetak');

            checkbox.addEventListener('change', function() {

                if (this.checked) {

                    tombol.classList.remove('opacity-50');
                    tombol.classList.remove('pointer-events-none');

                } else {

                    tombol.classList.add('opacity-50');
                    tombol.classList.add('pointer-events-none');

                }

            });

        });
    </script>
@endsection
