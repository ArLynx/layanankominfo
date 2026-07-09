@extends('user.layouts.app')

@section('content')

    <!-- Header -->
    <header
        class="bg-surface border-b border-border-subtle py-4 px-gutter md:px-margin-desktop sticky top-0 z-10 w-full shadow-sm">

        <div class="max-w-container-max mx-auto flex items-center justify-between">

            <div class="flex items-center gap-3">

                <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings:'FILL' 1;">
                    account_balance
                </span>

                <div>

                    <h1 class="text-headline-md font-headline-md text-primary tracking-tight">
                        Dinas Kominfo Murung Raya
                    </h1>

                    <p class="text-caption font-caption text-on-surface-variant">
                        Portal Layanan Digital
                    </p>

                </div>

            </div>

            @if (isset($emailPribadi))
                <a href="{{ route('email-pribadi.show', $emailPribadi) }}"
                    class="text-label-md font-label-md text-primary flex items-center gap-2 hover:bg-surface-container px-3 py-2 rounded transition-colors">

                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>

                    Batal

                </a>
            @else
                <a href="{{ route('jenis-layanan') }}"
                    class="text-label-md font-label-md text-primary flex items-center gap-2 hover:bg-surface-container px-3 py-2 rounded transition-colors">

                    <span class="material-symbols-outlined">
                        close
                    </span>

                    Batal

                </a>
            @endif

        </div>

    </header>

    <!-- Main -->
    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">

        <!-- Judul -->
        <div class="mb-10 text-center md:text-left">

            <h1 class="text-display-sm font-display-sm text-on-surface mb-3">

                {{ isset($emailPribadi) ? 'Edit Pengajuan Email Pribadi' : 'Formulir Pengajuan Email Pribadi' }}

            </h1>

            <p class="text-body-lg font-body-lg text-on-surface-variant max-w-3xl">

                {{ isset($emailPribadi)
                    ? 'Perbarui data pengajuan sebelum formulir dicetak dan diunggah.'
                    : 'Lengkapi formulir berikut untuk mengajukan layanan Email Pribadi.' }}

            </p>

        </div>

        <!-- Step -->
        <div class="mb-12 relative flex items-center justify-between w-full md:w-3/4 mx-auto md:mx-0">

            <div
                class="absolute top-1/2 left-0 w-full h-[2px] bg-border-subtle -z-10 -translate-y-1/2 rounded-full hidden md:block">
            </div>

            <!-- Step 1 -->
            <div class="flex flex-col items-center gap-2 relative bg-background px-2">

                <div
                    class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary ring-4 ring-background">

                    <span class="material-symbols-outlined text-sm">
                        check
                    </span>

                </div>

                <span class="text-label-sm hidden md:block">
                    Pilih Layanan
                </span>

            </div>

            <div class="flex-grow h-[2px] bg-primary md:hidden mx-2"></div>

            <!-- Step 2 -->
            <div class="flex flex-col items-center gap-2 relative bg-background px-2">

                <div
                    class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary ring-4 ring-background">

                    <span class="material-symbols-outlined text-sm">
                        check
                    </span>

                </div>

                <span class="text-label-sm hidden md:block">
                    Data Pemohon
                </span>

            </div>

            <div class="flex-grow h-[2px] bg-border-subtle md:hidden mx-2"></div>

            <!-- Step 3 -->
            <div class="flex flex-col items-center gap-2 relative bg-background px-2">

                <div
                    class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container border border-secondary flex items-center justify-center ring-4 ring-background font-bold shadow-sm">

                    3

                </div>

                <span class="text-label-sm font-bold text-primary hidden md:block">
                    Detail & Dokumen
                </span>

            </div>

        </div>

        <!-- Card -->
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-border-subtle bg-surface-gray">

                <h3 class="text-headline-md font-headline-md text-primary">
                    Detail Pengajuan Email Pribadi
                </h3>

                <p class="text-caption font-caption text-on-surface-variant mt-1">
                    Langkah 3 dari 3
                </p>

            </div>

            {{-- Error Validation --}}
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

            {{-- Success --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-500 text-green-700 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-500 text-red-700 p-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Catatan --}}
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
                            Pastikan data ASN dan nama akun email yang diajukan sudah benar. Nama akun akan diverifikasi
                            oleh admin sebelum dibuatkan akun email resmi.
                        </p>

                    </div>

                </div>

            </div>

            <form
                action="{{ isset($emailPribadi) ? route('email-pribadi.update', $emailPribadi) : route('email-pribadi.store') }}"
                method="POST" enctype="multipart/form-data" class="p-6 md:p-8 flex flex-col gap-8">

                @csrf

                @isset($emailPribadi)
                    @method('PUT')
                @endisset

                <!-- jenis laynanan -->
                <div class="flex flex-col gap-2">

                    <label class="text-label-md font-label-md text-on-surface">
                        Jenis Layanan
                        <span class="text-error">*</span>
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
                            {{ old('jenis_layanan', $emailPribadi->jenis_layanan ?? '') == 'baru' ? 'selected' : '' }}>
                            Pengajuan Email Pribadi Baru
                        </option>

                        <option value="reset"
                            {{ old('jenis_layanan', $emailPribadi->jenis_layanan ?? '') == 'reset' ? 'selected' : '' }}>
                            Reset Password
                        </option>

                        <option value="reaktivasi"
                            {{ old('jenis_layanan', $emailPribadi->jenis_layanan ?? '') == 'reaktivasi' ? 'selected' : '' }}>
                            Reaktivasi Akun
                        </option>

                        <option value="ubah_akun"
                            {{ old('jenis_layanan', $emailPribadi->jenis_layanan ?? '') == 'ubah_akun' ? 'selected' : '' }}>
                            Perubahan Nama Akun Email
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

                        Nama Akun Email Dinas (Pribadi)

                        <span class="text-error">*</span>

                    </label>

                    <div class="relative flex items-center">

                        <input
                            class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nama_akuns" name="nama_akun"
                            value="{{ old('nama_akun', isset($emailPribadi) ? str_replace('@murungrayakab.go.id', '', $emailPribadi->nama_akun) : '') }}"
                            placeholder="nama lengkap" type="text">

                        <span
                            class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg text-label-md text-on-surface-variant font-semibold">
                            @murungrayakab.go.id
                        </span>

                    </div>

                    @error('nama_akun')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-caption font-caption text-on-surface-variant flex items-start gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Nama akun email akan digunakan sebagai alamat email resmi instansi.
                    </p>

                </div>

                {{-- Nama email baru --}}
                <div id="nama-akun-baru-section" class="hidden flex flex-col gap-2">

                    <label class="text-label-md font-label-md">

                        Nama Akun Email Baru

                        <span class="text-error">*</span>

                    </label>

                    <div class="relative flex items-center">

                        <input id="nama_akun_baru" name="nama_akun_baru" type="text"
                            value="{{ old('nama_akun_baru', $emailPribadi->nama_akun_baru ?? '') }}"
                            placeholder="contoh : nama2026"
                            class="flex-grow
                px-4
                py-3
                bg-surface
                border
                border-outline-variant
                rounded-l-lg">

                        <span
                            class="px-4
                py-3
                bg-surface-container
                border
                border-l-0
                border-outline-variant
                rounded-r-lg">

                            @murungrayakab.go.id

                        </span>

                    </div>

                    @error('nama_akun_baru')
                        <p class="text-red-500 text-sm">

                            {{ $message }}

                        </p>
                    @enderror

                    <p class="text-caption text-on-surface-variant">

                        Diisi apabila mengajukan perubahan nama akun email.

                    </p>

                </div>

                {{-- Jenis Pengajuan --}}
                <div class="flex flex-col gap-2">

                    <label class="text-label-md font-label-md text-on-surface">

                        Jenis Pengajuan

                        <span class="text-error">*</span>

                    </label>

                    <select id="pengajuan" name="pengajuan"
                        class="w-full px-4 py-3 bg-surface border rounded-lg
        @error('pengajuan')
            border-red-500
        @else
            border-outline-variant
        @enderror">

                        <option value="">
                            Pilih Jenis Pengajuan
                        </option>

                        <option value="diri_sendiri"
                            {{ old('pengajuan', $emailPribadi->pengajuan ?? '') == 'diri_sendiri' ? 'selected' : '' }}>
                            Diri Sendiri
                        </option>

                        <option value="orang_lain"
                            {{ old('pengajuan', $emailPribadi->pengajuan ?? '') == 'orang_lain' ? 'selected' : '' }}>
                            Orang Lain
                        </option>

                    </select>

                    @error('pengajuan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Nama Lengkap

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="nama" value="{{ old('nama', $emailPribadi->nama ?? '') }}"
                                placeholder="Nama Lengkap"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nama')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- NIP --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                NIP

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="nip" value="{{ old('nip', $emailPribadi->nip ?? '') }}"
                                placeholder="NIP"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nip')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Pangkat --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Pangkat / Golongan

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="pangkat_gol"
                                value="{{ old('pangkat_gol', $emailPribadi->pangkat_gol ?? '') }}"
                                placeholder="Contoh : Penata (III/c)"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('pangkat_gol')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Jabatan --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Jabatan

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="jabatan"
                                value="{{ old('jabatan', $emailPribadi->jabatan ?? '') }}" placeholder="Jabatan"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('jabatan')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Email Pribadi Aktif

                                <span class="text-error">*</span>

                            </label>

                            <input type="email" name="email" value="{{ old('email', $emailPribadi->email ?? '') }}"
                                placeholder="nama@gmail.com"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('email')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- No HP --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Nomor HP WA

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="no_hp" value="{{ old('no_hp', $emailPribadi->no_hp ?? '') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('no_hp')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama Instansi --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Nama Instansi / Unit Kerja

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="nama_instansi"
                                value="{{ old('nama_instansi', $emailPribadi->nama_instansi ?? '') }}"
                                placeholder="Contoh : Dinas Komunikasi dan Informatika"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nama_instansi')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Nama Kepala Instansi --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Nama Kepala Instansi/Unit Kerja

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="nama_kadis"
                                value="{{ old('nama_kadis', $emailPribadi->nama_kadis ?? '') }}"
                                placeholder="Nama Kepala Instansi/Unit Kerja"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nama_kadis')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Jabatan Kepala Instansi --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                Jabatan Kepala Instansi/Unit Kerja

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="jabatan_kadis"
                                value="{{ old('jabatan_kadis', $emailPribadi->jabatan_kadis ?? '') }}"
                                placeholder="Contoh : Kepala Dinas/Kepala Badan/Camat/Lurah"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('jabatan_kadis')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- NIP Kepala Instansi --}}
                        <div class="flex flex-col gap-2">

                            <label class="text-label-md font-label-md">

                                NIP Kepala Instansi/Unit Kerja

                                <span class="text-error">*</span>

                            </label>

                            <input type="text" name="nip_kadis"
                                value="{{ old('nip_kadis', $emailPribadi->nip_kadis ?? '') }}"
                                placeholder="NIP Kepala Instansi"
                                class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg">

                            @error('nip_kadis')
                                <p class="text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                <!-- File Upload: Kartu Pegawai -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">

                        Upload Kartu Pegawai

                        @if (!isset($emailPribadi))
                            <span class="text-error">*</span>
                        @endif
                    </label>

                    @if (isset($emailPribadi))
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
                                @if (isset($emailPribadi) && $emailPribadi->karpeg)
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

                        {{ isset($emailPribadi) ? 'Simpan Perubahan' : 'Kirim Pengajuan' }}

                        <span class="material-symbols-outlined text-xl">
                            {{ isset($emailPribadi) ? 'save' : 'send' }}
                        </span>
                    </button>
                </div>

            </form>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | Upload Karpeg
            |--------------------------------------------------------------------------
            */

            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('karpeg');
            const fileName = document.getElementById('file-name');

            if (dropZone && fileInput) {

                dropZone.addEventListener('click', () => {
                    fileInput.click();
                });

                fileInput.addEventListener('change', function() {

                    if (this.files.length > 0) {

                        fileName.textContent = '✓ ' + this.files[0].name;

                        fileName.classList.add('text-green-600');

                    } else {

                        fileName.textContent = 'Belum ada file dipilih';

                        fileName.classList.remove('text-green-600');

                    }

                });

                dropZone.addEventListener('dragover', function(e) {

                    e.preventDefault();

                    dropZone.classList.add(
                        'border-primary',
                        'bg-surface-container-low'
                    );

                });

                dropZone.addEventListener('dragleave', function(e) {

                    e.preventDefault();

                    dropZone.classList.remove(
                        'border-primary',
                        'bg-surface-container-low'
                    );

                });

                dropZone.addEventListener('drop', function(e) {

                    e.preventDefault();

                    dropZone.classList.remove(
                        'border-primary',
                        'bg-surface-container-low'
                    );

                    const files = e.dataTransfer.files;

                    if (!files.length) return;

                    fileInput.files = files;

                    fileName.textContent = '✓ ' + files[0].name;

                    fileName.classList.add('text-green-600');

                });

            }

            /*
            |--------------------------------------------------------------------------
            | Jenis Layanan
            |--------------------------------------------------------------------------
            */

            const jenisLayanan = document.getElementById('jenis_layanan');

            const namaAkunBaru = document.getElementById('nama-akun-baru-section');

            const labelNamaAkun = document.getElementById('label-nama-akun');

            function updateJenisLayanan() {

                if (!jenisLayanan) return;

                if (jenisLayanan.value === 'ubah_akun') {

                    namaAkunBaru.classList.remove('hidden');

                    labelNamaAkun.innerHTML = `
                Nama Akun Email Lama
                <span class="text-error">*</span>
            `;

                } else {

                    namaAkunBaru.classList.add('hidden');

                    labelNamaAkun.innerHTML = `
                Nama Akun Email
                <span class="text-error">*</span>
            `;

                }

            }

            updateJenisLayanan();

            if (jenisLayanan) {

                jenisLayanan.addEventListener(
                    'change',
                    updateJenisLayanan
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Jenis Pengajuan
            |--------------------------------------------------------------------------
            */

            const pengajuan = document.getElementById('pengajuan');

            const judul = document.getElementById('judul-data-email');

            function updatePengajuan() {

                if (!pengajuan) return;

                if (pengajuan.value === 'orang_lain') {

                    judul.textContent =
                        'Data Pemilik Email';

                } else {

                    judul.textContent =
                        'Data Pemohon';

                }

            }

            updatePengajuan();

            if (pengajuan) {

                pengajuan.addEventListener(
                    'change',
                    updatePengajuan
                );

            }

        });
    </script>
@endsection
