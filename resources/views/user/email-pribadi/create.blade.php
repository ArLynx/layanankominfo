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
            <a class="text-label-md font-label-md text-primary flex items-center gap-2 hover:bg-surface-container px-3 py-2 rounded transition-colors"
                href="{{ route('jenis-layanan') }}">
                <span class="material-symbols-outlined text-xl">close</span> Batal
            </a>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
        <!-- Page Header -->
        <div class="mb-10 text-center md:text-left">
            <h2
                class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-on-background mb-2">
                Formulir Pengajuan Layanan</h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Lengkapi detail teknis dan dokumen pendukung
                untuk memproses permohonan Anda.</p>
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
                <h3 class="text-headline-md font-headline-md text-primary">Detail Pengajuan Email Pribadi</h3>
                <p class="text-caption font-caption text-on-surface-variant mt-1">Langkah 3 dari 3</p>
            </div>

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
            <form class="p-6 md:p-8 flex flex-col gap-8" action="{{ route('subdomain.store') }}" method="POST"
                enctype="multipart/form-data" class="p-6 md:p-8 flex flex-col gap-8">
                @csrf

                <!-- Input: Subdomain / Email -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface flex items-center gap-1" for="subdomain">
                        Nama Subdomain yang Diajukan
                        <span class="text-error">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <input
                            class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="subdomain" name="nama_subdomain" value="{{ old('nama_subdomain') }}"
                            placeholder="nama-instansi" type="text">
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

                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface" for="purpose">
                        Deskrisikan Website <span class="text-error">*</span>
                    </label>
                    <textarea
                        class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all min-h-[100px]"
                        id="deskripsi_website" name="deskripsi_website"
                        placeholder="Misal: Profil Dinas, Aplikasi Internal, Portal Layanan Publik, dll">{{ old('deskripsi_website') }}</textarea>
                    @error('deskripsi_website')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface" for="pic_name">
                            Nama Penanggung Jawab Teknis <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nama_penanggung_jawab" name="nama_penanggung_jawab"
                            value="{{ old('nama_penanggung_jawab') }}" placeholder="Nama lengkap" type="text">
                        @error('nama_penanggung_jawab')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface" for="pic_name">
                            NIP Penanggung Jawab Teknis <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="nip" name="nip" value="{{ old('nip') }}" placeholder="Nama lengkap"
                            type="text">
                        @error('nip')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface" for="pic_contact">
                            Kontak Penanggung Jawab <span class="text-error">*</span>
                        </label>
                        <input
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="No. WhatsApp / HP"
                            type="text">
                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            Email Pribadi <span class="text-error">*</span>
                        </label>

                        <input type="email" name="email_pribadi" value="{{ old('email_pribadi') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg"
                            placeholder="nama@gmail.com">
                        @error('email_pribadi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            Jenis Layanan <span class="text-error">*</span>
                        </label>

                        <select name="jenis_layanan"
                            class="w-full px-4 py-3 bg-surface border rounded-lg
                            @error('jenis_layanan')
                                border-red-500
                            @else
                                border-outline-variant
                            @enderror">

                            <option value="">Pilih Layanan</option>

                            <option value="baru" {{ old('jenis_layanan') == 'baru' ? 'selected' : '' }}>
                                Permohonan Baru
                            </option>

                            <option value="reset" {{ old('jenis_layanan') == 'reset' ? 'selected' : '' }}>
                                Reset Password
                            </option>

                            <option value="hapus" {{ old('jenis_layanan') == 'hapus' ? 'selected' : '' }}>
                                Hapus Akun
                            </option>

                            <option value="ubah" {{ old('jenis_layanan') == 'ubah' ? 'selected' : '' }}>
                                Ganti Nama Akun
                            </option>
                        </select>

                        @error('jenis_layanan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            Nama Kepala Dinas <span class="text-error">*</span>
                        </label>

                        <input type="text" name="nama_kadis" value="{{ old('nama_kadis') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="Nama Kepala Dinas">
                        @error('nama_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">
                            NIP Kepala Dinas <span class="text-error">*</span>
                        </label>

                        <input type="text" name="nip_kadis" value="{{ old('nip_kadis') }}"
                            class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="NIP Kepala Dinas">
                        @error('nip_kadis')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
                <!-- File Upload: Kartu Pegawai -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">Upload SK Pegawai <span
                            class="text-error">*</span></label>
                    <!-- Drag & Drop Zone -->
                    <div class="border-2 border-dashed border-outline-variant hover:border-primary bg-surface hover:bg-surface-container-low transition-colors rounded-xl p-8 flex flex-col items-center justify-center gap-4 cursor-pointer group"
                        id="drop-zone">
                        <div
                            class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center group-hover:bg-primary-fixed transition-colors">
                            <span
                                class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                        </div>
                        <div class="text-center">
                            <p class="text-body-md font-body-md text-on-surface mb-1">Tarik &amp; lepas file di sini,
                                atau <span class="text-primary font-semibold hover:underline">klik untuk memilih</span>
                            </p>
                            <p id="file-name" class="text-caption font-caption text-on-surface-variant">
                                Belum ada file dipilih
                            </p>
                            <p class="text-caption font-caption text-on-surface-variant">Format yang didukung: PDF,
                                JPG,
                                PNG (Maks. 5MB)</p>
                        </div>
                        <input accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="sk_pegawai" name="sk_pegawai"
                            type="file">
                        @error('sk_pegawai')
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

                        Kirim Pengajuan

                        <span class="material-symbols-outlined text-xl">
                            send
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('sk_pegawai');
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
    </script>
@endsection
