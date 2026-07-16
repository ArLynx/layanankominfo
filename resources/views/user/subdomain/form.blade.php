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
            @if (isset($subdomain))
                <a class="text-label-md font-label-md text-primary flex items-center gap-2 hover:bg-surface-container px-3 py-2 rounded transition-colors"
                    href="{{ route('subdomain.show', $subdomain) }}">
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

                {{ isset($subdomain) ? 'Edit Pengajuan Subdomain' : 'Formulir Pengajuan Layanan' }}

            </h1>

            <p class="text-body-lg font-body-lg text-on-surface-variant max-w-3xl">

                {{ isset($subdomain)
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
                <h3 class="text-headline-md font-headline-md text-primary">Detail Pengajuan Subdomain</h3>
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
                            Penanggung jawab subdomain minimal memiliki jabatan setingkat
                            Administrator atau Jabatan Fungsional (JF) Ahli Madya.
                        </p>
                    </div>
                </div>
            </div>

            <form class="p-6 md:p-8 flex flex-col gap-8"
                action="{{ isset($subdomain) ? route('subdomain.update', $subdomain) : route('subdomain.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf

                @isset($subdomain)
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
                            {{ old('jenis_layanan', $subdomain->jenis_layanan ?? '') == 'baru' ? 'selected' : '' }}>
                            Pengajuan Subdomain Baru
                        </option>

                        <option value="ubah_penanggung"
                            {{ old('jenis_layanan', $subdomain->jenis_layanan ?? '') == 'ubah_penanggung' ? 'selected' : '' }}>
                            Perubahan Penanggung Jawab Subdomain
                        </option>

                        <option value="ubah_subdomain"
                            {{ old('jenis_layanan', $subdomain->jenis_layanan ?? '') == 'ubah_subdomain' ? 'selected' : '' }}>
                            Perubahan nama subdomain
                        </option>

                        <option value="nonaktif"
                            {{ old('jenis_layanan', $subdomain->jenis_layanan ?? '') == 'nonaktif' ? 'selected' : '' }}>
                            Penonaktifan subdomain
                        </option>

                    </select>

                    @error('jenis_layanan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- subdomain -->
                <div id="subdomain-section" class="flex flex-col gap-2">
                    <label id="label-subdomain" class="text-label-md font-label-md text-on-surface flex items-center gap-1"
                        for="subdomain">

                        Nama Subdomain yang Diajukan

                        <span class="text-error">*</span>

                    </label>
                    <div class="relative flex items-center">
                        <input
                            class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nama_subdomain" name="nama_subdomain"
                            value="{{ old('nama_subdomain', isset($subdomain) ? str_replace('.murungrayakab.go.id', '', $subdomain->nama_subdomain) : '') }}"
                            placeholder="nama-instansi (subdomain hanya boleh huruf kecil, angka dan tanda hubung (-)"
                            type="text">
                        <span
                            class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg text-label-md text-on-surface-variant font-semibold">.murungrayakab.go.id</span>
                    </div>
                    @error('nama_subdomain')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-caption font-caption text-on-surface-variant flex items-start gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Ketersediaan nama subdomain tunduk pada kebijakan dan penamaan standar pemerintah daerah.
                    </p>
                </div>

                <!-- subdomain baru -->
                <div id="subdomain-baru-section" class="hidden flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">
                        Nama Subdomain Baru
                        <span class="text-error">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <input id="nama_subdomain_baru" name="nama_subdomain_baru"
                            value="{{ old('nama_subdomain_baru', isset($subdomain) && $subdomain->nama_subdomain_baru ? str_replace('.murungrayakab.go.id', '', $subdomain->nama_subdomain_baru) : '') }}"
                            placeholder="nama-instansi (subdomain hanya boleh huruf kecil, angka dan tanda hubung (-)""
                            type="text"
                            class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg">
                        <span class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg">

                            .murungrayakab.go.id
                        </span>
                    </div>
                    @error('nama_subdomain_baru')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-caption font-caption text-on-surface-variant flex items-start gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Isikan nama subdomain yang baru.
                    </p>
                </div>

                <!-- deskripsikan website -->
                <div class="flex flex-col gap-2">
                    <label id="label-deskripsi" class="text-label-md font-label-md text-on-surface" for="deskripsi_website">

                        Deskripsikan Website
                        <span class="text-error">*</span>

                    </label>
                    <textarea id="deskripsi_website" name="deskripsi_website"
                        class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all min-h-[100px]"
                        placeholder="Misal: Profil Dinas, Aplikasi Internal, Portal Layanan Publik, dll">{{ old('deskripsi_website', $subdomain->deskripsi_website ?? '') }}</textarea>
                    @error('deskripsi_website')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
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

                    <!-- penanggung jawab -->
                    <div class="flex flex-col gap-2">
                        <label id="label-penanggung-jawab" class="text-label-md font-label-md text-on-surface"
                            for="nama_penanggung_jawab">
                            Nama Penanggung Jawab
                            <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nama_penanggung_jawab" name="nama_penanggung_jawab"
                            value="{{ old('nama_penanggung_jawab', $subdomain->nama_penanggung_jawab ?? '') }}"
                            placeholder="Nama lengkap" type="text">
                        @error('nama_penanggung_jawab')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- nip -->
                    <div class="flex flex-col gap-2">
                        <label id="label-nip" class="text-label-md font-label-md text-on-surface"
                            for="nip_penanggung_jawab">
                            NIP Penanggung Jawab
                            <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nip_penanggung_jawab" name="nip_penanggung_jawab"
                            value="{{ old('nip_penanggung_jawab', $subdomain->nip_penanggung_jawab ?? '') }}"
                            placeholder="NIP" type="text">
                        @error('nip_penanggung_jawab')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- pangkat golongan -->
                    <div class="flex flex-col gap-2">
                        <label id="label-pangkat" class="text-label-md font-label-md text-on-surface" for="pangkat_gol">
                            Pangkat/Golongan
                            <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="pangkat_gol" name="pangkat_gol"
                            value="{{ old('pangkat_gol', $subdomain->pangkat_gol ?? '') }}"
                            placeholder="Penata Muda (III/a)" type="text">
                        @error('pangkat_gol')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- jabatan -->
                    <div class="flex flex-col gap-2">
                        <label id="label-jabatan" class="text-label-md font-label-md text-on-surface" for="jabatan">
                            Jabatan Penanggung Jawab
                            <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="jabatan" name="jabatan" value="{{ old('jabatan', $subdomain->jabatan ?? '') }}"
                            placeholder="Jabatan" type="text">
                        @error('jabatan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- no hp -->
                    <div class="flex flex-col gap-2">
                        <label id="label-nohp" class="text-label-md font-label-md text-on-surface" for="no_hp">
                            No HP Penanggung Jawab
                            <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="no_hp" name="no_hp" value="{{ old('no_hp', $subdomain->no_hp ?? '') }}"
                            placeholder="No. WhatsApp 08xxxxx" type="text">
                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- email -->
                    <div class="flex flex-col gap-2">
                        <label id="label-email" class="text-label-md font-label-md text-on-surface" for="email">
                            Email Penanggung Jawab
                            <span class="text-error">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $subdomain->email ?? '') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                            placeholder="nama@gmail.com">
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

                        <!-- Nama -->
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Nama Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>
                            <input type="text" name="nama_penanggung_jawab_baru"
                                value="{{ old('nama_penanggung_jawab_baru', $subdomain->nama_penanggung_jawab_baru ?? '') }}"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                                placeholder="Nama lengkap">
                        </div>

                        <!-- NIP -->
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                NIP Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>
                            <input type="text" name="nip_penanggung_jawab_baru"
                                value="{{ old('nip_penanggung_jawab_baru', $subdomain->nip_penanggung_jawab_baru ?? '') }}"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                                placeholder="NIP">
                        </div>

                        <!-- Pangkat -->
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Pangkat / Golongan Baru
                                <span class="text-error">*</span>
                            </label>
                            <input type="text" name="pangkat_gol_baru"
                                value="{{ old('pangkat_gol_baru', $subdomain->pangkat_gol_baru ?? '') }}"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                                placeholder="Penata (III/c)">
                        </div>

                        <!-- Jabatan -->
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Jabatan Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>
                            <input type="text" name="jabatan_baru"
                                value="{{ old('jabatan_baru', $subdomain->jabatan_baru ?? '') }}"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                                placeholder="Jabatan">
                        </div>

                        <!-- No HP -->
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                No. HP Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>
                            <input type="text" name="no_hp_baru"
                                value="{{ old('no_hp_baru', $subdomain->no_hp_baru ?? '') }}"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">
                                Email Penanggung Jawab Baru
                                <span class="text-error">*</span>
                            </label>
                            <input type="email" name="email_baru"
                                value="{{ old('email_baru', $subdomain->email_baru ?? '') }}"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                                placeholder="nama@email.com">
                        </div>

                    </div> {{-- grid baru --}}
                </div> {{-- penanggung baru --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- nama instansi -->
                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface" for="pic_name">
                            Nama Instansi/Unit Kerja
                            <span class="text-error">*</span>
                        </label>

                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            type="text" name="nama_instansi"
                            value="{{ old('nama_instansi', $subdomain->nama_instansi ?? '') }}"
                            placeholder="Contoh: Dinas Komunikasi dan Informatika">

                        @error('nama_instansi')
                            <p class="text-red-500 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- nama kadis -->
                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            Nama Kepala Instansi/Unit Kerja <span class="text-error">*</span>
                        </label>

                        <input type="text" name="nama_kadis"
                            value="{{ old('nama_kadis', $subdomain->nama_kadis ?? '') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="Nama Kepala Instansi/Unit Kerja">
                        @error('nama_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- nip kadis -->
                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            NIP Kepala Instansi/Unit Kerja <span class="text-error">*</span>
                        </label>

                        <input type="text" name="nip_kadis"
                            value="{{ old('nip_kadis', $subdomain->nip_kadis ?? '') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="NIP Instansi/Unit Kerja">
                        @error('nip_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- jabatan kadis -->
                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            Jabatan Kepala Instansi/Unit Kerja <span class="text-error">*</span>
                        </label>

                        <input type="text" name="jabatan_kadis"
                            value="{{ old('jabatan_kadis', $subdomain->jabatan_kadis ?? '') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="Kepala Dinas/Camat/Lurah/...">
                        @error('jabatan_kadis')
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

                        @if (!isset($subdomain))
                            <span class="text-error">*</span>
                        @endif
                    </label>

                    @if (isset($subdomain))
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
                                @if (isset($subdomain) && $subdomain->karpeg)
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

                        {{ isset($subdomain) ? 'Simpan Perubahan' : 'Kirim Pengajuan' }}

                        <span class="material-symbols-outlined text-xl">
                            {{ isset($subdomain) ? 'save' : 'send' }}
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
            const subdomainBaru = document.getElementById('subdomain-baru-section');

            function toggleSubdomainBaru() {

                if (jenisLayanan.value === 'ubah_subdomain') {

                    subdomainBaru.classList.remove('hidden');

                } else {

                    subdomainBaru.classList.add('hidden');

                }
            }

            toggleSubdomainBaru();

            jenisLayanan.addEventListener('change', toggleSubdomainBaru);

        });

        //subdomain lama
        document.addEventListener('DOMContentLoaded', function() {

            const jenisLayanan = document.getElementById('jenis_layanan');
            const labelSubdomain = document.getElementById('label-subdomain');

            function updateLabelSubdomain() {

                if (jenisLayanan.value === 'ubah_subdomain') {

                    labelSubdomain.innerHTML = `
                Nama Subdomain Lama
                <span class="text-error">*</span>
            `;

                } else {

                    labelSubdomain.innerHTML = `
                Nama Subdomain yang Diajukan
                <span class="text-error">*</span>
            `;

                }

            }

            updateLabelSubdomain();

            jenisLayanan.addEventListener('change', updateLabelSubdomain);

        });

        //deskripsi
        document.addEventListener('DOMContentLoaded', function() {

            const jenisLayanan = document.getElementById('jenis_layanan');

            const labelDeskripsi = document.getElementById('label-deskripsi');
            const textareaDeskripsi = document.getElementById('deskripsi_website');

            function updateDeskripsi() {

                switch (jenisLayanan.value) {

                    case 'ubah_penanggung':

                        labelDeskripsi.innerHTML =
                            'Alasan Perubahan Penanggung Jawab <span class="text-error">*</span>';

                        textareaDeskripsi.placeholder =
                            'Contoh: Terjadi pergantian pejabat penanggung jawab karena mutasi, promosi jabatan, atau perubahan tugas.';

                        break;

                    case 'ubah_subdomain':

                        labelDeskripsi.innerHTML =
                            'Alasan Perubahan Nama Subdomain <span class="text-error">*</span>';

                        textareaDeskripsi.placeholder =
                            'Contoh: Penyesuaian nama subdomain dengan nomenklatur perangkat daerah atau layanan yang terbaru.';

                        break;

                    case 'nonaktif':

                        labelDeskripsi.innerHTML =
                            'Alasan Penonaktifan Subdomain <span class="text-error">*</span>';

                        textareaDeskripsi.placeholder =
                            'Contoh: Website sudah tidak digunakan, digabung dengan layanan lain, atau aplikasi telah dihentikan.';

                        break;

                    default:

                        labelDeskripsi.innerHTML =
                            'Deskripsikan Website <span class="text-error">*</span>';

                        textareaDeskripsi.placeholder =
                            'Contoh: Website profil instansi, aplikasi pelayanan publik, sistem informasi internal, portal data, dan sebagainya.';

                }
            }

            updateDeskripsi();

            jenisLayanan.addEventListener('change', updateDeskripsi);

        });

        document.addEventListener('DOMContentLoaded', function() {

            const jenisLayanan = document.getElementById('jenis_layanan');

            const alertPenanggung = document.getElementById('alert-penanggung-jawab');
            const cardPenanggungLama = document.getElementById('card-penanggung-lama');
            const penanggungBaruForm = document.getElementById('penanggung-baru-form');

            const labelNama = document.getElementById('label-penanggung-jawab');
            const labelNip = document.getElementById('label-nip');
            const labelPangkat = document.getElementById('label-pangkat');
            const labelJabatan = document.getElementById('label-jabatan');
            const labelNoHp = document.getElementById('label-nohp');
            const labelEmail = document.getElementById('label-email');

            function togglePenanggungJawab() {

                if (jenisLayanan.value === 'ubah_penanggung') {

                    // tampilkan alert
                    alertPenanggung.classList.remove('hidden');

                    // tampilkan judul data lama
                    cardPenanggungLama.classList.remove('hidden');

                    // tampilkan data baru
                    penanggungBaruForm.classList.remove('hidden');

                    // ubah label lama
                    labelNama.innerHTML =
                        'Nama Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelNip.innerHTML =
                        'NIP Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelPangkat.innerHTML =
                        'Pangkat / Golongan Lama <span class="text-error">*</span>';

                    labelJabatan.innerHTML =
                        'Jabatan Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelNoHp.innerHTML =
                        'No. HP Penanggung Jawab Lama <span class="text-error">*</span>';

                    labelEmail.innerHTML =
                        'Email Penanggung Jawab Lama <span class="text-error">*</span>';

                } else {

                    // sembunyikan alert
                    alertPenanggung.classList.add('hidden');

                    // sembunyikan judul lama
                    cardPenanggungLama.classList.add('hidden');

                    // sembunyikan data baru
                    penanggungBaruForm.classList.add('hidden');

                    // kembalikan label
                    labelNama.innerHTML =
                        'Nama Penanggung Jawab <span class="text-error">*</span>';

                    labelNip.innerHTML =
                        'NIP Penanggung Jawab <span class="text-error">*</span>';

                    labelPangkat.innerHTML =
                        'Pangkat / Golongan <span class="text-error">*</span>';

                    labelJabatan.innerHTML =
                        'Jabatan Penanggung Jawab <span class="text-error">*</span>';

                    labelNoHp.innerHTML =
                        'No. HP Penanggung Jawab <span class="text-error">*</span>';

                    labelEmail.innerHTML =
                        'Email Penanggung Jawab <span class="text-error">*</span>';

                }
            }

            // saat pilihan berubah
            jenisLayanan.addEventListener('change', togglePenanggungJawab);

            // saat halaman pertama dibuka
            togglePenanggungJawab();

        });
    </script>
@endsection
