@extends('user.layouts.app')

@section('content')
    <main class="flex-grow w-full mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
        <div class="w-full max-w-[1700px] mx-auto px-4">

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-2xl font-bold mb-6">
                    Detail Pengajuan Email Pribadi
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
                                {{ $emailPribadi->nomor_tiket }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Status Pengajuan
                            </p>

                            <p class="font-semibold">

                                @switch($emailPribadi->status)
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

                                @switch($emailPribadi->jenis_layanan)
                                    @case('baru')
                                        Pengajuan Email Pribadi Baru
                                    @break

                                    @case('reset')
                                        Reset Password
                                    @break

                                    @case('reaktivasi')
                                        Reaktivasi Akun
                                    @break

                                    @case('ubah_akun')
                                        Perubahan Nama Akun Email
                                    @break
                                @endswitch

                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Jenis Pengajuan
                            </p>

                            <p class="font-semibold">

                                {{ $emailPribadi->pengajuan == 'diri_sendiri' ? 'Diri Sendiri' : 'Orang Lain' }}

                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Tanggal Pengajuan
                            </p>

                            <p class="font-semibold">

                                {{ $emailPribadi->created_at->locale('id')->translatedFormat('d F Y') }}

                            </p>

                        </div>

                    </div>

                </div>

                {{-- ================= DATA EMAIL PRIBADI ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">
                            alternate_email
                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">
                            Data Email Pribadi
                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        @if ($emailPribadi->jenis_layanan == 'ubah_akun')
                            <div>

                                <p class="text-sm text-gray-500">
                                    Nama Akun Email Lama
                                </p>

                                <p class="font-semibold">
                                    {{ $emailPribadi->nama_akun }}
                                </p>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    Nama Akun Email Baru
                                </p>

                                <p class="font-semibold">
                                    {{ $emailPribadi->nama_akun_baru }}
                                </p>

                            </div>
                        @else
                            <div class="md:col-span-2">

                                <p class="text-sm text-gray-500">
                                    Nama Akun Email
                                </p>

                                <p class="font-semibold">
                                    {{ $emailPribadi->nama_akun }}
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

                {{-- ================= DATA PEMILIK EMAIL ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">
                            badge
                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">

                            Data Pemilik Email

                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <p class="text-sm text-gray-500">
                                Nama Lengkap
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->nama }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                NIP
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->nip }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Jabatan
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->jabatan }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Pangkat / Golongan
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->pangkat_gol }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Nomor HP
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->no_hp }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Email Alternatif
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->email }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- ================= DATA INSTANSI ================= --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6 mb-8">

                    <div class="flex items-center gap-3 mb-6">

                        <span class="material-symbols-outlined text-3xl text-on-surface">
                            business
                        </span>

                        <h3 class="text-xl font-semibold text-on-surface">
                            Data Instansi
                        </h3>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div class="md:col-span-2">

                            <p class="text-sm text-gray-500">
                                Nama Instansi
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->nama_instansi }}
                            </p>

                        </div>

                    </div>

                </div>

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
                                Nama Kepala Instansi
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->nama_kadis }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                Jabatan
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->jabatan_kadis }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">
                                NIP
                            </p>

                            <p class="font-semibold">
                                {{ $emailPribadi->nip_kadis }}
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

                    @if ($emailPribadi->catatan_admin)
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
                                        {{ $emailPribadi->catatan_admin }}
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

                                    <li>✔ Nama Akun Email</li>

                                    @if ($emailPribadi->jenis_layanan == 'ubah_akun')
                                        <li>✔ Nama Akun Email Baru</li>
                                    @endif

                                    <li>✔ Nama Pemilik Email</li>

                                    <li>✔ NIP</li>

                                    <li>✔ Jabatan</li>

                                    <li>✔ Pangkat / Golongan</li>

                                    <li>✔ Nomor HP</li>

                                    <li>✔ Email Alternatif</li>

                                    <li>✔ Nama Instansi</li>

                                    <li>✔ Nama, Jabatan dan NIP Kepala Instansi</li>

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

                                @if (!$emailPribadi->formulir_email)
                                    <a href="{{ route('email-pribadi.edit', $emailPribadi) }}"
                                        class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium transition">

                                        <span class="material-symbols-outlined">

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

                                        <strong>{{ $emailPribadi->nomor_tiket }}</strong>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>Nama Akun Email</span>

                                        <strong>{{ $emailPribadi->nama_akun }}</strong>

                                    </div>

                                    @if ($emailPribadi->jenis_layanan == 'ubah_akun')
                                        <div class="flex justify-between">

                                            <span>Nama Akun Email Baru</span>

                                            <strong>{{ $emailPribadi->nama_akun_baru }}</strong>

                                        </div>
                                    @endif

                                    <div class="flex justify-between">

                                        <span>Nama Pemilik Email</span>

                                        <strong>{{ $emailPribadi->nama }}</strong>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>NIP</span>

                                        <strong>{{ $emailPribadi->nip }}</strong>

                                    </div>

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

                            <a id="btnCetak" href="{{ route('email-pribadi.cetak', $emailPribadi) }}" target="_blank"
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

                            </ul>

                        </div>

                    </div>

                </div>

                @if (!$emailPribadi->formulir_email)
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
                                    Upload formulir yang telah dicetak dan ditandatangani oleh pimpinan (maks. 5 MB).
                                </p>

                            </div>

                        </div>

                        <form action="{{ route('email-pribadi.upload-formulir', $emailPribadi) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <input type="file" name="formulir_email" accept=".pdf"
                                class="block w-full rounded-lg border border-gray-300 p-3">

                            @error('formulir_email')
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

                @if ($emailPribadi->formulir_email)
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

                                <a href="{{ route('email-pribadi.download-formulir', $emailPribadi) }}" target="_blank"
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

                @if ($emailPribadi->status == 'selesai' && $emailPribadi->email_sent_at)
                    @php

                        $message = '';

                        switch ($emailPribadi->jenis_layanan) {
                            case 'baru':
                                $message =
                                    'Pengajuan Email Pribadi telah selesai diproses. Informasi akun email telah dikirim ke Email Alternatif.';
                                break;

                            case 'reset':
                                $message =
                                    'Password akun email telah berhasil direset. Informasi password baru telah dikirim ke Email Alternatif.';
                                break;

                            case 'reaktivasi':
                                $message =
                                    'Akun email telah berhasil direaktivasi. Informasi akun telah dikirim ke Email Alternatif.';
                                break;

                            case 'ubah_akun':
                                $message =
                                    'Perubahan nama akun email telah selesai diproses. Informasi akun terbaru telah dikirim ke Email Alternatif.';
                                break;
                        }

                    @endphp

                    <div class="mt-8 rounded-xl border border-green-300 bg-green-50 p-6">

                        <div class="flex items-center gap-3 mb-5">

                            <span class="material-symbols-outlined text-green-600 text-4xl">
                                mark_email_read
                            </span>

                            <div>

                                <h3 class="text-xl font-bold text-green-800">
                                    Informasi Akun Email
                                </h3>

                                <p class="text-sm text-green-700">
                                    Informasi akun telah berhasil dikirim.
                                </p>

                            </div>

                        </div>

                        <div class="rounded-lg bg-white border border-green-200 p-5">

                            <p class="text-gray-700 leading-relaxed">

                                {{ $message }}

                            </p>

                            <div class="grid md:grid-cols-3 gap-5 mt-6">

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Email Tujuan
                                    </p>

                                    <p class="font-semibold break-all">
                                        {{ $emailPribadi->email }}
                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Tanggal Pengiriman
                                    </p>

                                    <p class="font-semibold">

                                        {{ $emailPribadi->email_sent_at->translatedFormat('d F Y H:i') }} WIB

                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Status
                                    </p>

                                    <span
                                        class="inline-flex mt-1 items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">

                                        Berhasil Dikirim

                                    </span>

                                </div>

                            </div>

                            <div class="mt-6 border-t pt-5">

                                <div class="flex items-start gap-3">

                                    <span class="material-symbols-outlined text-blue-600">
                                        info
                                    </span>

                                    <div>

                                        <p class="font-semibold text-blue-800">

                                            Informasi Penting

                                        </p>

                                        <ul class="mt-2 list-disc list-inside text-sm text-gray-700 space-y-1">

                                            <li>Silakan periksa folder <strong>Inbox</strong> maupun <strong>Spam</strong>.
                                            </li>

                                            <li>Username dan password hanya dikirim melalui email demi menjaga keamanan
                                                akun.</li>

                                            <li>Dokumen informasi akun tidak dapat diunduh kembali melalui sistem.</li>

                                            <li>Jika email belum diterima dalam beberapa menit, silakan menghubungi
                                                Administrator Diskominfo.</li>

                                        </ul>

                                    </div>

                                </div>

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

            if (!checkbox || !tombol) {
                return;
            }

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
