<x-admin-layout title="Detail Pengajuan Email Satuan Kerja">

    <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>

            <h2 class="text-headline-lg font-headline-lg text-on-surface">

                Pengajuan Email Satuan Kerja

            </h2>

            <p class="text-body-md font-body-md text-on-surface-variant mt-1">

                Daftar pengajuan layanan Email Satuan Kerja yang masuk.

            </p>

        </div>

    </header>

    {{-- Header --}}
    <div class="bg-surface rounded-xl border border-outline-variant p-6">

        <div class="flex items-start justify-between">

            <div>

                <div class="flex items-center gap-2 mb-2">

                    <h1 class="text-2xl font-bold">

                        {{ $emailSatker->nomor_tiket }}

                    </h1>

                    @switch($emailSatker->status)
                        @case('terbuka')
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full border border-blue-200">
                                Pengajuan
                            </span>
                        @break

                        @case('baru')
                            <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full border border-gray-200">
                                Pemeriksaan Dokumen
                            </span>
                        @break

                        @case('tunda')
                            <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full border border-orange-200">
                                Persetujuan Pimpinan
                            </span>
                        @break

                        @case('diproses')
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full border border-yellow-200">
                                Proses Pembuatan
                            </span>
                        @break

                        @case('selesai')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full border border-green-200">
                                Selesai
                            </span>
                        @break

                        @case('tutup')
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full border border-red-200">
                                Pengajuan Dibatalkan
                            </span>
                        @break
                    @endswitch

                </div>

                <p class="text-on-surface-variant">

                    @switch($emailSatker->jenis_layanan)
                        @case('baru')
                            Permohonan Email Satuan Kerja Baru
                        @break

                        @case('reset')
                            Permohonan Reset Password
                        @break

                        @case('reaktivasi')
                            Permohonan Reaktivasi Akun
                        @break

                        @case('ubah_akun')
                            Permohonan Perubahan Nama Akun Email
                        @break

                        @case('ubah_penanggung')
                            Permohonan Perubahan Penanggung Jawab
                        @break

                        @default
                            -
                    @endswitch

                </p>

            </div>

            <button class="text-outline hover:text-on-surface">

                <span class="material-symbols-outlined">

                    more_vert

                </span>

            </button>

        </div>

    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">

            {{ session('success') }}

        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">

            {{ session('error') }}

        </div>
    @endif

    {{-- card timeline --}}

    @php
        $steps = [
            'terbuka' => 1,
            'baru' => 2,
            'tunda' => 3,
            'diproses' => 4,
            'selesai' => 5,
            'tutup' => 5,
        ];

        $currentStep = $steps[$emailSatker->status] ?? 1;

        $isCancelled = $emailSatker->status == 'tutup';

        $skipApproval = in_array($emailSatker->jenis_layanan, ['reset', 'reaktivasi', 'ubah_akun']);
    @endphp

    <div class="bg-surface rounded-xl border border-outline-variant p-6">

        <div class="flex items-center">

            {{-- Pengajuan --}}
            <div class="flex flex-col items-center">

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center

                    @if ($currentStep > 1) bg-primary text-white
                    @elseif($currentStep == 1)
                        bg-yellow-500 text-gray-600
                    @else
                        bg-gray-200 text-gray-600 @endif">

                    <span class="material-symbols-outlined">
                        {{ $currentStep > 1 ? 'check' : 'description' }}
                    </span>

                </div>

                <span class="text-sm mt-3 font-medium text-center">
                    Pengajuan
                </span>

            </div>

            <div class="flex-1 h-1 mx-3 {{ $currentStep > 1 ? 'bg-primary' : 'bg-gray-200' }}"></div>

            {{-- Pemeriksaan --}}
            <div class="flex flex-col items-center">

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center

                    @if ($currentStep > 2) bg-primary text-white
                    @elseif($currentStep == 2)
                        bg-yellow-500 text-gray-600
                    @else
                        bg-gray-200 text-gray-600 @endif">

                    <span class="material-symbols-outlined">
                        {{ $currentStep > 2 ? 'check' : 'fact_check' }}
                    </span>

                </div>

                <span class="text-sm mt-3 font-medium text-center">
                    Pemeriksaan Dokumen
                </span>

            </div>

            @unless ($skipApproval)
                <div class="flex-1 h-1 mx-3 {{ $currentStep > 2 ? 'bg-primary' : 'bg-gray-200' }}"></div>

                {{-- Persetujuan --}}
                <div class="flex flex-col items-center">

                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center

                        @if ($currentStep > 3) bg-primary text-white
                        @elseif($currentStep == 3)
                            bg-yellow-500 text-gray-600
                        @else
                            bg-gray-200 text-gray-600 @endif">

                        <span class="material-symbols-outlined">
                            {{ $currentStep > 3 ? 'check' : 'approval' }}
                        </span>

                    </div>

                    <span class="text-sm mt-3 font-medium text-center">
                        Persetujuan Pimpinan
                    </span>

                </div>
            @endunless

            <div class="flex-1 h-1 mx-3 {{ $currentStep > 3 ? 'bg-primary' : 'bg-gray-200' }}"></div>

            {{-- Proses --}}
            <div class="flex flex-col items-center">

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center

                    @if ($currentStep > 4) bg-primary text-white
                    @elseif($currentStep == 4)
                        bg-yellow-500 text-gray-600
                    @else
                        bg-gray-200 text-gray-600 @endif">

                    <span class="material-symbols-outlined">
                        {{ $currentStep > 4 ? 'check' : 'settings' }}
                    </span>

                </div>

                <span class="text-sm mt-3 font-medium text-center">
                    Proses Pembuatan
                </span>

            </div>

            <div
                class="flex-1 h-1 mx-3

                @if ($isCancelled) bg-red-500
                @elseif($currentStep >= 5)
                    bg-yellow-500
                @else
                    bg-gray-200 @endif">
            </div>

            {{-- Selesai --}}
            <div class="flex flex-col items-center">

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center

                    @if ($isCancelled) bg-red-500 text-white
                    @elseif($currentStep == 5)
                        bg-green-500 text-white
                    @else
                        bg-gray-200 text-gray-600 @endif">

                    <span class="material-symbols-outlined">

                        @if ($isCancelled)
                            cancel
                        @elseif($currentStep == 5)
                            check
                        @else
                            task_alt
                        @endif

                    </span>

                </div>

                <span
                    class="text-sm mt-3 font-medium text-center

                    @if ($isCancelled) text-red-600
                    @elseif($currentStep == 5)
                        text-green-600 @endif">

                    {{ $isCancelled ? 'Pengajuan Dibatalkan' : 'Selesai' }}

                </span>

            </div>

        </div>

    </div>

    {{-- Detail --}}

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

        {{-- ================= KOLOM KIRI ================= --}}

        <div class="lg:col-span-8 space-y-6">

            {{-- Card Data Penanggung Jawab --}}
            <div class="bg-surface rounded-xl border border-outline-variant p-6">

                <div class="flex items-center gap-2 mb-4">

                    <span class="material-symbols-outlined text-primary">
                        badge
                    </span>

                    <h3 class="text-xl font-semibold text-on-surface">

                        @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                            Data Penanggung Jawab Lama
                        @else
                            Data Penanggung Jawab
                        @endif

                    </h3>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>

                        <label class="font-semibold">
                            Nama Lengkap
                        </label>

                        <p>
                            {{ $emailSatker->nama_penanggung_jawab }}
                        </p>

                    </div>

                    <div>

                        <label class="font-semibold">
                            NIP
                        </label>

                        <p>
                            {{ $emailSatker->nip }}
                        </p>

                    </div>

                    <div>

                        <label class="font-semibold">
                            Jabatan
                        </label>

                        <p>
                            {{ $emailSatker->jabatan }}
                        </p>

                    </div>

                    <div>

                        <label class="font-semibold">
                            Pangkat / Golongan
                        </label>

                        <p>
                            {{ $emailSatker->pangkat_gol }}
                        </p>

                    </div>

                    <div>

                        <label class="font-semibold">
                            Nomor HP / WA
                        </label>

                        <p>
                            {{ $emailSatker->no_hp }}
                        </p>

                    </div>

                    <div>

                        <label class="font-semibold">
                            Email
                        </label>

                        <p>
                            {{ $emailSatker->email }}
                        </p>

                    </div>

                    <div class="md:col-span-2">

                        <label class="font-semibold">
                            Instansi / Unit Kerja
                        </label>

                        <p>
                            {{ $emailSatker->nama_instansi }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Card Data Penanggung Jawab baru --}}
            @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                <div class="bg-surface rounded-xl border border-outline-variant p-6">

                    <div class="flex items-center gap-2 mb-4">

                        <span class="material-symbols-outlined text-primary">
                            manage_accounts
                        </span>

                        <h3 class="font-semibold text-lg">

                            Data Penanggung Jawab Baru

                        </h3>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <label class="font-semibold">
                                Nama Lengkap
                            </label>

                            <p>
                                {{ $emailSatker->nama_penanggung_jawab_baru }}
                            </p>

                        </div>

                        <div>

                            <label class="font-semibold">
                                NIP
                            </label>

                            <p>
                                {{ $emailSatker->nip_baru }}
                            </p>

                        </div>

                        <div>

                            <label class="font-semibold">
                                Jabatan
                            </label>

                            <p>
                                {{ $emailSatker->jabatan_baru }}
                            </p>

                        </div>

                        <div>

                            <label class="font-semibold">
                                Pangkat / Golongan
                            </label>

                            <p>
                                {{ $emailSatker->pangkat_gol_baru }}
                            </p>

                        </div>

                        <div>

                            <label class="font-semibold">
                                Nomor HP / WA
                            </label>

                            <p>
                                {{ $emailSatker->no_hp_baru }}
                            </p>

                        </div>

                        <div>

                            <label class="font-semibold">
                                Email
                            </label>

                            <p>
                                {{ $emailSatker->email_baru }}
                            </p>

                        </div>

                    </div>

                </div>
            @endif

            {{-- Card Data Subdomain --}}
            <div class="bg-surface rounded-xl border border-outline-variant p-6">

                <div class="flex items-center gap-2 mb-4">

                    <span class="material-symbols-outlined text-primary">
                        alternate_email
                    </span>

                    <h3 class="font-semibold text-lg">
                        Data Email Satuan Kerja
                    </h3>

                </div>

                <div class="space-y-4">

                    <div>

                        <label class="font-semibold">
                            Nama Instansi
                        </label>

                        <p>
                            {{ $emailSatker->nama_instansi }}
                        </p>

                    </div>

                    @if ($emailSatker->jenis_layanan == 'ubah_akun')
                        <div>

                            <label class="font-semibold">
                                Nama Akun Email Lama
                            </label>

                            <p>
                                {{ $emailSatker->nama_akun_dinas }}
                            </p>

                        </div>

                        <div>

                            <label class="font-semibold">
                                Nama Akun Email Baru
                            </label>

                            <p>
                                {{ $emailSatker->nama_akun_dinas_baru }}
                            </p>

                        </div>
                    @else
                        <div>

                            <label class="font-semibold">
                                Nama Akun Email
                            </label>

                            <p>
                                {{ $emailSatker->nama_akun_dinas }}
                            </p>

                        </div>
                    @endif

                    <div>

                        <p class="text-sm text-on-surface-variant">
                            Jenis Layanan
                        </p>

                        <p class="font-medium">

                            @switch($emailSatker->jenis_layanan)
                                @case('baru')
                                    Pengajuan Email Satuan Kerja Baru
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

                                @case('ubah_penanggung')
                                    Perubahan Penanggung Jawab
                                @break

                                @default
                                    -
                            @endswitch

                        </p>

                    </div>

                </div>

            </div>

            {{-- Card Data Pendukung --}}
            <div class="bg-surface rounded-xl border border-outline-variant p-6">

                <div class="flex items-center gap-2 mb-4">

                    <span class="material-symbols-outlined text-primary">
                        description
                    </span>

                    <h3 class="font-semibold text-lg">
                        Dokumen Pendukung
                    </h3>

                </div>

                <div class="grid lg:grid-cols-2 gap-6">

                    {{-- KARPEG --}}
                    <div class="bg-surface rounded-xl border border-outline-variant p-4">

                        <div class="flex items-center justify-between mb-4">

                            <h3 class="font-semibold text-lg">
                                Kartu Pegawai
                            </h3>

                            <a href="{{ route('admin.email-satker.karpeg', $emailSatker) }}" target="_blank"
                                class="px-4 py-2 bg-primary text-white rounded-lg">

                                Buka Dokumen

                            </a>

                        </div>

                        <div class="border rounded-lg overflow-hidden bg-gray-100">

                            <iframe src="{{ route('admin.email-satker.karpeg', $emailSatker) }}"
                                class="w-full h-[700px]">
                            </iframe>

                        </div>

                    </div>

                    {{-- FORMULIR --}}
                    <div class="bg-surface rounded-xl border border-outline-variant p-4">

                        <div class="flex items-center justify-between mb-4">

                            <h3 class="font-semibold text-lg">
                                Formulir Email Satuan Kerja
                            </h3>

                            @if ($emailSatker->formulir_email)
                                <a href="{{ route('admin.email-satker.formulir', $emailSatker) }}" target="_blank"
                                    class="px-4 py-2 bg-primary text-white rounded-lg">

                                    Buka Dokumen

                                </a>
                            @endif

                        </div>

                        @if ($emailSatker->formulir_email)
                            <div class="border rounded-lg overflow-hidden bg-gray-100">

                                <iframe src="{{ route('admin.email-satker.formulir', $emailSatker) }}"
                                    class="w-full h-[700px]">
                                </iframe>

                            </div>

                            <form action="{{ route('admin.email-satker.delete-formulir', $emailSatker) }}"
                                method="POST" class="mt-4">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus formulir yang diupload pemohon?')"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg">

                                    Hapus Formulir

                                </button>

                            </form>
                        @else
                            <div class="border rounded-lg p-10 text-center bg-gray-50">

                                <span class="material-symbols-outlined text-5xl text-gray-400">

                                    description

                                </span>

                                <h4 class="font-medium text-gray-700 mt-3">

                                    Belum Ada Dokumen

                                </h4>

                                <p class="text-sm text-gray-500 mt-2">

                                    Pemohon belum mengunggah formulir yang telah ditandatangani.

                                </p>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="lg:col-span-4">

            {{-- Tindakan Admin --}}
            <div class="bg-surface rounded-xl border border-outline-variant p-6 sticky top-6">

                <div class="flex items-center gap-2 mb-6">

                    <span class="material-symbols-outlined text-primary">
                        admin_panel_settings
                    </span>

                    <h3 class="font-semibold text-lg">
                        Tindakan Admin
                    </h3>

                </div>

                @if ($errors->any())

                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                        <ul class="list-disc pl-5 text-red-700">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif

                <form id="status" action="{{ route('admin.email-satker.update-status', $emailSatker) }}"
                    method="POST">

                    @csrf
                    @method('PATCH')

                    <div class="space-y-5">

                        {{-- STATUS --}}
                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Status Pengajuan

                            </label>

                            <select id="status" name="status"
                                class="w-full rounded-lg border border-outline-variant px-4 py-3">

                                <option value="terbuka" {{ $emailSatker->status == 'terbuka' ? 'selected' : '' }}>
                                    Pengajuan
                                </option>

                                <option value="baru" {{ $emailSatker->status == 'baru' ? 'selected' : '' }}>
                                    Pemeriksaan Dokumen
                                </option>

                                @if (!in_array($emailSatker->jenis_layanan, ['reset', 'reaktivasi', 'ubah_akun']))
                                    <option value="tunda" {{ $emailSatker->status == 'tunda' ? 'selected' : '' }}>
                                        Persetujuan Pimpinan
                                    </option>
                                @endif

                                <option value="diproses" {{ $emailSatker->status == 'diproses' ? 'selected' : '' }}>
                                    Proses Pembuatan
                                </option>

                                <option value="selesai" {{ $emailSatker->status == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>

                                <option value="tutup" {{ $emailSatker->status == 'tutup' ? 'selected' : '' }}>
                                    Pengajuan Dibatalkan
                                </option>

                            </select>

                            @error('status')
                                <p class="text-red-500 text-sm mt-1">

                                    {{ $message }}

                                </p>
                            @enderror

                        </div>

                        {{-- CATATAN ADMIN --}}
                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Catatan Admin

                            </label>

                            <textarea name="catatan_admin" rows="6" class="w-full rounded-lg border border-outline-variant px-4 py-3"
                                placeholder="Masukkan catatan untuk pemohon...">{{ old('catatan_admin', $emailSatker->catatan_admin) }}</textarea>

                            @error('catatan_admin')
                                <p class="text-red-500 text-sm mt-1">

                                    {{ $message }}

                                </p>
                            @enderror

                        </div>

                        {{-- INFO --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-700">

                            Catatan ini akan ditampilkan kepada pemohon pada halaman riwayat pengajuan.

                        </div>

                        {{-- CATATAN PIMPINAN --}}
                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Catatan Pimpinan

                            </label>

                            @if ($emailSatker->catatan_pimpinan)
                                <div class="mt-1 p-3 bg-blue-50 border border-blue-200 rounded-lg">

                                    {{ $emailSatker->catatan_pimpinan }}

                                </div>
                            @else
                                <p class="text-gray-500 text-sm">

                                    Belum ada catatan dari pimpinan.

                                </p>
                            @endif

                        </div>

                    </div>

                </form>

                <div class="flex flex-col gap-3 mt-5">

                    @if ($emailSatker->status == 'diproses')

                        <div class="border rounded-lg bg-gray-50 p-5 mt-4">

                            <h4 class="font-semibold text-lg mb-4">

                                Kirim Informasi Akun

                            </h4>

                            {{-- Tujuan Email --}}
                            <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 p-4">

                                <p class="text-sm text-gray-600">

                                    Informasi akun akan dikirim ke Email Penanggung Jawab

                                </p>

                                <p class="font-semibold text-blue-700 mt-1">

                                    {{ $emailSatker->jenis_layanan == 'ubah_penanggung' ? $emailSatker->email_baru : $emailSatker->email }}

                                </p>

                            </div>

                            <form action="{{ route('admin.email-satker.send-information', $emailSatker) }}"
                                method="POST">

                                @csrf

                                <div class="space-y-4">

                                    {{-- ===================== --}}
                                    {{-- BARU --}}
                                    {{-- RESET --}}
                                    {{-- REAKTIVASI --}}
                                    {{-- ===================== --}}

                                    @if (in_array($emailSatker->jenis_layanan, ['baru', 'reset', 'reaktivasi']))
                                        <div>

                                            <label class="block text-sm font-medium mb-2">

                                                Username Email

                                            </label>

                                            <input type="text" name="username"
                                                class="w-full rounded-lg border px-4 py-3"
                                                value="{{ $emailSatker->nama_akun_dinas }}" readonly>

                                        </div>
                                    @endif

                                    {{-- ===================== --}}
                                    {{-- UBAH AKUN --}}
                                    {{-- ===================== --}}

                                    @if ($emailSatker->jenis_layanan == 'ubah_akun')
                                        <div>

                                            <label class="block text-sm font-medium mb-2">

                                                Username Lama

                                            </label>

                                            <input type="text"
                                                class="w-full rounded-lg border bg-gray-100 px-4 py-3"
                                                value="{{ $emailSatker->nama_akun_dinas }}" readonly>

                                        </div>

                                        <div>

                                            <label class="block text-sm font-medium mb-2">

                                                Username Baru

                                            </label>

                                            <input type="text" name="username"
                                                class="w-full rounded-lg border px-4 py-3"
                                                value="{{ $emailSatker->nama_akun_dinas_baru }}" readonly>

                                        </div>
                                    @endif

                                    {{-- ===================== --}}
                                    {{-- UBAH PENANGGUNG JAWAB --}}
                                    {{-- ===================== --}}

                                    @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                                        <div>

                                            <label class="block text-sm font-medium mb-2">

                                                Username Email

                                            </label>

                                            <input type="text" name="username"
                                                class="w-full rounded-lg border px-4 py-3"
                                                value="{{ $emailSatker->nama_akun_dinas }}" readonly>

                                        </div>
                                    @endif

                                    {{-- PASSWORD --}}

                                    <div>

                                        <label class="block text-sm font-medium mb-2">

                                            @if (in_array($emailSatker->jenis_layanan, ['reset', 'reaktivasi']))
                                                Password Baru
                                            @else
                                                Password Awal
                                            @endif

                                        </label>

                                        <input type="text" name="password"
                                            class="w-full rounded-lg border px-4 py-3"
                                            placeholder="Masukkan password awal" required>

                                    </div>

                                    <button type="submit"
                                        class="w-full rounded-lg bg-primary py-3 text-white hover:opacity-90">

                                        @if ($emailSatker->dokumen_akun)

                                            <button type="submit"
                                                class="w-full rounded-lg bg-orange-500 hover:bg-orange-600 text-white py-3">

                                                Kirim Ulang Informasi Akun

                                            </button>
                                        @else
                                            <button type="submit"
                                                class="w-full rounded-lg bg-primary hover:opacity-90 text-white py-3">

                                                @if ($emailSatker->jenis_layanan == 'baru')
                                                    Kirim Informasi Akun
                                                @elseif($emailSatker->jenis_layanan == 'reset')
                                                    Kirim Password Baru
                                                @elseif($emailSatker->jenis_layanan == 'reaktivasi')
                                                    Kirim Informasi Reaktivasi
                                                @elseif($emailSatker->jenis_layanan == 'ubah_akun')
                                                    Kirim Informasi Perubahan Akun
                                                @elseif($emailSatker->jenis_layanan == 'ubah_penanggung')
                                                    Kirim Informasi Penanggung Jawab
                                                @endif

                                            </button>

                                        @endif

                                    </button>

                                </div>

                            </form>

                        </div>

                    @endif

                    @if ($emailSatker->dokumen_akun)

                        <div class="border rounded-lg p-4 bg-green-50 mt-4">

                            <div class="flex items-center gap-2 mb-3">

                                <span class="material-symbols-outlined text-green-600">

                                    mark_email_read

                                </span>

                                <h4 class="font-semibold">

                                    Informasi Akun

                                </h4>

                            </div>

                            <div class="space-y-2 text-sm">

                                <div>

                                    <span class="text-gray-500">

                                        Status Pengiriman

                                    </span>

                                    <br>

                                    <span class="font-medium text-green-700">

                                        Berhasil Dikirim

                                    </span>

                                </div>

                                @if ($emailSatker->email_sent_at)
                                    <div>

                                        <span class="text-gray-500">

                                            Tanggal Pengiriman

                                        </span>

                                        <br>

                                        <span class="font-medium">

                                            {{ $emailSatker->email_sent_at->format('d F Y H:i') }}

                                        </span>

                                    </div>
                                @endif

                            </div>

                            <a href="{{ route('admin.email-satker.information-account', $emailSatker) }}"
                                target="_blank"
                                class="mt-4 block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">

                                Lihat Dokumen Informasi Akun

                            </a>

                        </div>

                    @endif

                    {{-- Simpan + Kembali --}}
                    <div class="flex gap-3">

                        <button type="submit" form="status"
                            class="flex-1 bg-primary text-white py-3 rounded-lg font-medium hover:opacity-90 transition">

                            Simpan Perubahan

                        </button>

                        <a href="{{ route('admin.email-satker') }}"
                            class="flex-1 text-center border border-outline-variant py-3 rounded-lg font-medium hover:bg-surface-container transition">

                            Kembali

                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        function confirmSendToLeader() {

            Swal.fire({
                title: 'Kirim ke Pimpinan?',
                text: 'Pengajuan akan dikirim ke pimpinan untuk persetujuan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal',
            }).then((result) => {

                if (result.isConfirmed) {
                    document.getElementById('sendToLeaderForm').submit();
                }

            });

        }
    </script>

</x-admin-layout>
