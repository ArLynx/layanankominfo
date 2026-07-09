@extends('user.layouts.app')

@section('content')
    <!-- Minimal Header for Transactional Flow (Suppressed Nav) -->
    <header
        class="bg-surface border-b border-border-subtle py-4 px-gutter md:px-margin-desktop sticky top-0 z-10 w-full shadow-sm">
        <div class="max-w-container-max mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-3xl"
                    style="font-variation-settings: 'FILL' 1;">account_balance</span>
                <div>
                    <h1 class="text-headline-md font-headline-md text-primary tracking-tight">Dinas Kominfo Murung Raya
                    </h1>
                    <p class="text-caption font-caption text-on-surface-variant">Portal Layanan Digital</p>
                </div>
            </div>
            @if (isset($emailSatker))
                <a class="text-label-md font-label-md text-primary flex items-center gap-2 hover:bg-surface-container px-3 py-2 rounded transition-colors"
                    href="{{ route('email-satker.show', $emailSatker) }}">
                    <span class="material-symbols-outlined text-xl">
                        arrow_back
                    </span>
                    Batal
                </a>
            @else
                <a class="text-label-md font-label-md text-primary flex items-center gap-2 hover:bg-surface-container px-3 py-2 rounded transition-colors"
                    href="{{ route('jenis-layanan') }}">
                    <span class="material-symbols-outlined text-xl">
                        close
                    </span>
                    Batal
                </a>
            @endif
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
        <!-- Page Header -->
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-display-sm font-display-sm text-on-surface mb-3">

                {{ isset($emailSatker) ? 'Edit Pengajuan Email Satker' : 'Formulir Pengajuan Layanan' }}

            </h1>

            <p class="text-body-lg font-body-lg text-on-surface-variant max-w-3xl">

                {{ isset($emailSatker)
                    ? 'Perbarui data pengajuan sebelum formulir dicetak dan diunggah.'
                    : 'Lengkapi detail teknis dan dokumen pendukung untuk memproses permohonan Anda.' }}

            </p>
        </div>
        <!-- Breadcrumb Stepper (Top-Aligned) -->
        <div class="mb-12 relative flex items-center justify-between w-full md:w-3/4 mx-auto md:mx-0">
            <!-- Connecting Line -->
            <div
                class="absolute top-1/2 left-0 w-full h-[2px] bg-border-subtle -z-10 -translate-y-1/2 rounded-full hidden md:block">
            </div>
            <!-- Step 1: Completed -->
            <div class="flex flex-col items-center gap-2 relative bg-background px-2">
                <div
                    class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary ring-4 ring-background">
                    <span class="material-symbols-outlined text-sm font-bold">check</span>
                </div>
                <span class="text-label-sm font-label-sm text-on-surface-variant hidden md:block">Pilih Layanan</span>
            </div>
            <div class="flex-grow h-[2px] bg-primary md:hidden mx-2"></div>
            <!-- Step 2: Completed -->
            <div class="flex flex-col items-center gap-2 relative bg-background px-2">
                <div
                    class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary ring-4 ring-background">
                    <span class="material-symbols-outlined text-sm font-bold">check</span>
                </div>
                <span class="text-label-sm font-label-sm text-on-surface-variant hidden md:block">Data Pemohon</span>
            </div>
            <div class="flex-grow h-[2px] bg-border-subtle md:hidden mx-2"></div>
            <!-- Step 3: Active (Gold) -->
            <div class="flex flex-col items-center gap-2 relative bg-background px-2">
                <div
                    class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container border border-secondary flex items-center justify-center ring-4 ring-background font-bold shadow-sm">
                    3
                </div>
                <span class="text-label-sm font-label-sm text-primary font-bold hidden md:block">Detail &amp;
                    Dokumen</span>
            </div>
        </div>
        <!-- Form Card Container -->

        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-border-subtle bg-surface-gray">
                <h3 class="text-headline-md font-headline-md text-primary">Detail Pengajuan Email Satuan Kerja</h3>
                <p class="text-caption font-caption text-on-surface-variant mt-1">Langkah 3 dari 3</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-500 text-red-700 p-4 rounded-lg mb-4">
                    <strong>Terjadi kesalahan:</strong>

                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-500 text-green-700 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-500 text-red-700 p-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-amber-600">
                        info
                    </span>
                    <div>
                        <p class="font-medium text-amber-800">
                            Catatan
                        </p>

                        <p class="text-sm text-amber-700 mt-1">
                            Penanggung jawab email satker minimal memiliki jabatan setingkat
                            Administrator atau Jabatan Fungsional (JF) Ahli Madya.
                        </p>
                    </div>
                </div>
            </div>

            <form class="p-6 md:p-8 flex flex-col gap-8"
                action="{{ isset($emailSatker) ? route('email-satker.update', $emailSatker) : route('email-satker.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf

                @isset($emailSatker)
                    @method('PUT')
                @endisset

                <!-- jenis laynanan -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">
                        Jenis Layanan <span class="text-error">*</span>
                    </label>

                    <select id="jenis_layanan" name="jenis_layanan"
                        class="w-full px-4 py-3 bg-surface border rounded-lg
                 @error('jenis_layanan')
                    border-red-500
                 @else
                    border-outline-variant
                @enderror">

                        <option value="">Pilih Layanan</option>

                        <option value="baru"
                            {{ old('jenis_layanan', $emailSatker->jenis_layanan ?? '') == 'baru' ? 'selected' : '' }}>
                            Pengajuan Email Satker Baru
                        </option>

                        <option value="reset"
                            {{ old('jenis_layanan', $emailSatker->jenis_layanan ?? '') == 'reset' ? 'selected' : '' }}>
                            Reset Password
                        </option>

                        <option value="reaktivasi"
                            {{ old('jenis_layanan', $emailSatker->jenis_layanan ?? '') == 'reaktivasi' ? 'selected' : '' }}>
                            Reaktivasi Akun
                        </option>

                        <option value="ubah_akun"
                            {{ old('jenis_layanan', $emailSatker->jenis_layanan ?? '') == 'ubah_akun' ? 'selected' : '' }}>
                            Perubahan Nama Akun Email
                        </option>

                        <option value="ubah_penanggung"
                            {{ old('jenis_layanan', $emailSatker->jenis_layanan ?? '') == 'ubah_penanggung' ? 'selected' : '' }}>
                            Perubahan Penanggung Jawab Email
                        </option>

                    </select>

                    @error('jenis_layanan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- nama email -->
                <div id="nama-akun-section" class="flex flex-col gap-2">

                    <label id="label-nama-akun" class="text-label-md font-label-md text-on-surface flex items-center gap-1">

                        Nama Akun Email Satuan Kerja

                        <span class="text-error">*</span>

                    </label>

                    <div class="relative flex items-center">

                        <input
                            class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nama_akun_dinas" name="nama_akun_dinas"
                            value="{{ old('nama_akun_dinas', isset($emailSatker) ? str_replace('@murungrayakab.go.id', '', $emailSatker->nama_akun_dinas) : '') }}"
                            placeholder="contoh: diskominfo" type="text">

                        <span
                            class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg text-label-md text-on-surface-variant font-semibold">
                            @murungrayakab.go.id
                        </span>

                    </div>

                    @error('nama_akun_dinas')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-caption font-caption text-on-surface-variant flex items-start gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Nama akun email akan digunakan sebagai alamat email resmi instansi.
                    </p>

                </div>

                <!-- email baru -->
                <div id="nama-akun-baru-section" class="hidden flex flex-col gap-2">

                    <label class="text-label-md font-label-md text-on-surface">
                        Nama Akun Email Satuan Kerja Baru
                        <span class="text-error">*</span>
                    </label>

                    <div class="relative flex items-center">

                        <input id="nama_akun_dinas_baru" name="nama_akun_dinas_baru"
                            value="{{ old('nama_akun_dinas_baru', $emailSatker->nama_akun_dinas_baru ?? '') }}"
                            placeholder="contoh: diskominfo2026" type="text"
                            class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg">

                        <span class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg">
                            @murungrayakab.go.id
                        </span>

                    </div>

                    @error('nama_akun_dinas_baru')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-caption font-caption text-on-surface-variant flex items-start gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Masukkan nama akun email baru yang diinginkan. Ketersediaan nama akun akan diverifikasi oleh admin.
                    </p>

                </div>

                <div id="alert-penanggung-jawab" class="hidden mb-6 rounded-lg border border-amber-300 bg-amber-50 p-4">

                    <p class="text-sm text-amber-700">

                        <strong>Perhatian!</strong>

                        Silakan isi data penanggung jawab lama terlebih dahulu,
                        kemudian isi data penanggung jawab baru yang akan menggantikan
                        penanggung jawab sebelumnya.

                    </p>

                </div>

                <div id="card-penanggung-lama" class="hidden mb-6">

                    <h3 class="text-lg font-semibold text-primary">
                        Data Penanggung Jawab Lama
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Silakan isi terlebih dahulu data penanggung jawab yang saat ini masih aktif.
                    </p>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Penanggung Jawab --}}
                    <div class="flex flex-col gap-2">
                        <label id="label-penanggung-jawab" class="text-label-md font-label-md text-on-surface"
                            for="nama_penanggung_jawab">

                            Nama Penanggung Jawab
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" id="nama_penanggung_jawab" name="nama_penanggung_jawab"
                            value="{{ old('nama_penanggung_jawab', $emailSatker->nama_penanggung_jawab ?? '') }}"
                            placeholder="Nama lengkap"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">

                        @error('nama_penanggung_jawab')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="flex flex-col gap-2">
                        <label id="label-nip" class="text-label-md font-label-md text-on-surface" for="nip">

                            NIP Penanggung Jawab
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" id="nip" name="nip"
                            value="{{ old('nip', $emailSatker->nip ?? '') }}" placeholder="NIP"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">

                        @error('nip')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Pangkat / Gol --}}
                    <div class="flex flex-col gap-2">
                        <label id="label-pangkat" class="text-label-md font-label-md text-on-surface" for="pangkat_gol">

                            Pangkat / Golongan
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" id="pangkat_gol" name="pangkat_gol"
                            value="{{ old('pangkat_gol', $emailSatker->pangkat_gol ?? '') }}"
                            placeholder="Contoh : Penata Muda (III/a)"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">

                        @error('pangkat_gol')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div class="flex flex-col gap-2">
                        <label id="label-jabatan" class="text-label-md font-label-md text-on-surface" for="jabatan">

                            Jabatan Penanggung Jawab
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" id="jabatan" name="jabatan"
                            value="{{ old('jabatan', $emailSatker->jabatan ?? '') }}" placeholder="Jabatan"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">

                        @error('jabatan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="flex flex-col gap-2">
                        <label id="label-nohp" class="text-label-md font-label-md text-on-surface" for="no_hp">

                            No. HP Penanggung Jawab
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" id="no_hp" name="no_hp"
                            value="{{ old('no_hp', $emailSatker->no_hp ?? '') }}" placeholder="No. Whastapp 08xxxxxxxxxx"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">

                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col gap-2">
                        <label id="label-email" class="text-label-md font-label-md text-on-surface" for="email">

                            Email Penanggung Jawab
                            <span class="text-error">*</span>

                        </label>

                        <input type="email" id="email" name="email"
                            value="{{ old('email', $emailSatker->email ?? '') }}" placeholder="nama@gmail.com"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div> {{-- Penutup grid Data Lama --}}

                <div id="penanggung-baru-form" class="hidden mt-8">

                    <h3 class="text-lg font-semibold text-primary mb-6">

                        Data Penanggung Jawab Baru

                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Nama Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" name="nama_penanggung_jawab_baru"
                                value="{{ old('nama_penanggung_jawab_baru', $emailSatker->nama_penanggung_jawab_baru ?? '') }}"
                                placeholder="Nama lengkap"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nama_penanggung_jawab_baru')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- NIP --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                NIP Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" name="nip_baru"
                                value="{{ old('nip_baru', $emailSatker->nip_baru ?? '') }}" placeholder="NIP"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nip_baru')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Pangkat --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Pangkat / Golongan Baru
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" name="pangkat_gol_baru"
                                value="{{ old('pangkat_gol_baru', $emailSatker->pangkat_gol_baru ?? '') }}"
                                placeholder="Contoh : Penata (III/c)"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('pangkat_gol_baru')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Jabatan --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Jabatan Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" name="jabatan_baru"
                                value="{{ old('jabatan_baru', $emailSatker->jabatan_baru ?? '') }}" placeholder="Jabatan"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('jabatan_baru')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                No. HP Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" name="no_hp_baru"
                                value="{{ old('no_hp_baru', $emailSatker->no_hp_baru ?? '') }}"
                                placeholder="No. Whastapp 08xxxxxxxxxx"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('no_hp_baru')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Email Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>

                            <input type="email" name="email_baru"
                                value="{{ old('email_baru', $emailSatker->email_baru ?? '') }}"
                                placeholder="nama@gmail.com"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('email_baru')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </div> {{-- penanggung baru --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Instansi --}}
                    <div class="flex flex-col gap-2">

                        <label class="text-label-md font-label-md text-on-surface">

                            Nama Instansi/Unit Kerja
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" name="nama_instansi"
                            value="{{ old('nama_instansi', $emailSatker->nama_instansi ?? '') }}"
                            placeholder="Contoh : Dinas Komunikasi dan Informatika"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                        @error('nama_instansi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Nama Kepala Dinas --}}
                    <div class="flex flex-col gap-2">

                        <label class="text-label-md font-label-md text-on-surface">

                            Nama Kepala Instansi/Unit Kerja
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" name="nama_kadis"
                            value="{{ old('nama_kadis', $emailSatker->nama_kadis ?? '') }}"
                            placeholder="Nama Kepala Instansi/Unit Kerja"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                        @error('nama_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Jabatan Kepala Dinas --}}
                    <div class="flex flex-col gap-2">

                        <label class="text-label-md font-label-md text-on-surface">

                            Jabatan Kepala Instansi/Unit Kerja
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" name="jabatan_kadis"
                            value="{{ old('jabatan_kadis', $emailSatker->jabatan_kadis ?? '') }}"
                            placeholder="Contoh : Kepala Dinas/Camat/Lurah/Kepala Badan"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                        @error('jabatan_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- NIP Kepala Dinas --}}
                    <div class="flex flex-col gap-2">

                        <label class="text-label-md font-label-md text-on-surface">

                            NIP Kepala Instansi/Unit Kerja
                            <span class="text-error">*</span>

                        </label>

                        <input type="text" name="nip_kadis"
                            value="{{ old('nip_kadis', $emailSatker->nip_kadis ?? '') }}" placeholder="NIP Kepala Instansi/Unit Kerja"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                        @error('nip_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                <!-- File Upload: Kartu Pegawai -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">

                        Upload Kartu Pegawai

                        @if (!isset($emailSatker))
                            <span class="text-error">*</span>
                        @endif
                    </label>

                    @if (isset($emailSatker))
                        <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-blue-600">

                                    info
                                </span>
                                <div>
                                    <p class="font-semibold text-blue-800">
                                        Kartu Pegawai sudah tersimpan.
                                    </p>
                                    <p class="text-sm text-blue-700 mt-1">
                                        Upload file baru hanya jika ingin mengganti Kartu Pegawai.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Drag & Drop Zone -->
                    <div class="border-2 border-dashed border-outline-variant hover:border-primary bg-surface hover:bg-surface-container-low transition-colors rounded-xl p-8 flex flex-col items-center justify-center gap-4 cursor-pointer group"
                        id="drop-zone">
                        <div
                            class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center group-hover:bg-primary-fixed transition-colors">
                            <span
                                class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">
                                cloud_upload
                            </span>
                        </div>

                        <div class="text-center">
                            <p class="text-body-md font-body-md text-on-surface mb-1">
                                Tarik & lepas file di sini,
                                atau <span class="text-primary font-semibold hover:underline">
                                    klik untuk memilih
                                </span>
                            </p>

                            <p id="file-name" class="text-caption font-caption text-on-surface-variant">
                                @if (isset($emailSatker) && $emailSatker->karpeg)
                                    File lama tersimpan. Pilih file jika ingin mengganti.
                                @else
                                    Belum ada file dipilih
                                @endif
                            </p>

                            <p class="text-caption font-caption text-on-surface-variant">
                                Format yang didukung:
                                PDF, JPG, PNG (Maks. 5MB)
                            </p>

                        </div>

                        <input accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="karpeg" name="karpeg"
                            type="file">
                        @error('karpeg')
                            <p class="text-red-500 text-sm mt-1">

                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Terms and Conditions Checkbox -->
                <div
                    class="bg-surface-container-low p-4 rounded-lg border border-border-subtle flex items-start gap-3 mt-4">
                    <div class="flex items-center h-6">
                        <input id="terms" name="terms" value="1" type="checkbox"
                            class="w-5 h-5 border-outline-variant rounded text-primary focus:ring-primary focus:ring-offset-background bg-surface cursor-pointer @error('terms') border-red-500 @enderror">
                    </div>

                    <div class="flex flex-col">
                        <label for="terms"
                            class="text-body-md font-body-md text-on-surface cursor-pointer select-none">
                            Saya menyetujui syarat dan ketentuan
                        </label>
                        <p class="text-caption font-caption text-on-surface-variant mt-1">
                            Dengan mencentang kotak ini, saya menyatakan bahwa data yang diberikan
                            adalah benar dan saya mematuhi kebijakan penggunaan fasilitas IT
                            Dinas Kominfo Kabupaten Murung Raya.
                        </p>
                        @error('terms')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="pt-6 border-t border-border-subtle flex flex-col md:flex-row justify-end items-center gap-4 mt-2">
                    <button type="button" onclick="history.back()"
                        class="w-full md:w-auto px-6 py-3 rounded-lg text-label-md font-label-md text-primary bg-transparent hover:bg-surface-container transition-colors order-2 md:order-1 flex items-center justify-center gap-2">

                        <span class="material-symbols-outlined text-xl">
                            arrow_back
                        </span>

                        Kembali
                    </button>
                    <button
                        class="w-full md:w-auto px-6 py-3 rounded-lg text-label-md font-label-md text-on-primary bg-primary hover:bg-primary-container shadow-sm transition-colors order-1 md:order-2 flex items-center justify-center gap-2"
                        type="submit">

                        {{ isset($emailSatker) ? 'Simpan Perubahan' : 'Kirim Pengajuan' }}

                        <span class="material-symbols-outlined text-xl">
                            {{ isset($emailSatker) ? 'save' : 'send' }}
                        </span>
                    </button>
                </div>

            </form>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('karpeg');
            const fileName = document.getElementById('file-name');

            // Klik area upload
            dropZone.addEventListener('click', () => {
                fileInput.click();
            });

            // Saat pilih file
            fileInput.addEventListener('change', function() {

                if (this.files.length > 0) {

                    fileName.textContent =
                        '✓ ' + this.files[0].name;

                    fileName.classList.add('text-green-600');

                } else {

                    fileName.textContent =
                        'Belum ada file dipilih';

                    fileName.classList.remove('text-green-600');
                }
            });

            // Drag masuk
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();

                dropZone.classList.add(
                    'border-primary',
                    'bg-surface-container-low'
                );
            });

            // Drag keluar
            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();

                dropZone.classList.remove(
                    'border-primary',
                    'bg-surface-container-low'
                );
            });

            // Drop file
            dropZone.addEventListener('drop', (e) => {

                e.preventDefault();

                dropZone.classList.remove(
                    'border-primary',
                    'bg-surface-container-low'
                );

                const files = e.dataTransfer.files;

                if (!files.length) return;

                fileInput.files = files;

                fileName.textContent =
                    '✓ ' + files[0].name;

                fileName.classList.add('text-green-600');
            });

        });

        //jenis-layanan
        document.addEventListener('DOMContentLoaded', function() {

            const jenisLayanan = document.getElementById('jenis_layanan');
            const labelNamaAkun = document.getElementById('label-nama-akun');

            function updateLabelNamaAkun() {

                if (jenisLayanan.value === 'ubah_akun') {

                    labelNamaAkun.innerHTML = `
                Nama Akun Email Satuan Kerja Lama
                <span class="text-error">*</span>
            `;

                } else {

                    labelNamaAkun.innerHTML = `
                Nama Akun Email Satuan Kerja
                <span class="text-error">*</span>
            `;

                }

            }

            updateLabelNamaAkun();

            jenisLayanan.addEventListener('change', updateLabelNamaAkun);

        });

        //email baru
        document.addEventListener('DOMContentLoaded', function() {

            const jenisLayanan = document.getElementById('jenis_layanan');
            const namaAkunBaru = document.getElementById('nama-akun-baru-section');

            function toggleNamaAkunBaru() {

                if (jenisLayanan.value === 'ubah_akun') {

                    namaAkunBaru.classList.remove('hidden');

                } else {

                    namaAkunBaru.classList.add('hidden');

                }

            }

            toggleNamaAkunBaru();

            jenisLayanan.addEventListener('change', toggleNamaAkunBaru);

        });

        //oenanggung jawab baru
        document.addEventListener('DOMContentLoaded', function() {

            const jenisLayanan = document.getElementById('jenis_layanan');

            const alertPenanggung = document.getElementById('alert-penanggung-jawab');
            const cardPenanggungLama = document.getElementById('card-penanggung-lama');
            const penanggungBaruForm = document.getElementById('penanggung-baru-form');

            const labelNama = document.getElementById('label-penanggung-jawab');
            const labelNip = document.getElementById('label-nip');
            const labelJabatan = document.getElementById('label-jabatan');
            const labelPangkat = document.getElementById('label-pangkat');
            const labelEmail = document.getElementById('label-email');
            const labelNoHp = document.getElementById('label-nohp');

            function togglePenanggungBaru() {

                if (jenisLayanan.value === 'ubah_penanggung') {

                    // Alert
                    alertPenanggung.classList.remove('hidden');

                    // Judul Data Lama
                    cardPenanggungLama.classList.remove('hidden');

                    // Form Data Baru
                    penanggungBaruForm.classList.remove('hidden');

                    // Label Data Lama
                    labelNama.innerHTML =
                        'Nama Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelNip.innerHTML =
                        'NIP Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelJabatan.innerHTML =
                        'Jabatan Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelPangkat.innerHTML =
                        'Pangkat / Golongan Lama <span class="text-error">*</span>';

                    labelEmail.innerHTML =
                        'Email Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelNoHp.innerHTML =
                        'No. HP Penanggung Jawab Lama <span class="text-error">*</span>';

                } else {

                    alertPenanggung.classList.add('hidden');

                    cardPenanggungLama.classList.add('hidden');

                    penanggungBaruForm.classList.add('hidden');

                    labelNama.innerHTML =
                        'Nama Penanggung Jawab <span class="text-error">*</span>';

                    labelNip.innerHTML =
                        'NIP Penanggung Jawab <span class="text-error">*</span>';

                    labelJabatan.innerHTML =
                        'Jabatan <span class="text-error">*</span>';

                    labelPangkat.innerHTML =
                        'Pangkat / Golongan <span class="text-error">*</span>';

                    labelEmail.innerHTML =
                        'Email <span class="text-error">*</span>';

                    labelNoHp.innerHTML =
                        'No. HP <span class="text-error">*</span>';

                }

            }

            togglePenanggungBaru();

            jenisLayanan.addEventListener('change', togglePenanggungBaru);

        });
    </script>
@endsection
