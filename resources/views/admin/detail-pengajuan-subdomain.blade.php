<x-admin-layout title="Detail Pengajuan Subdomain">
    <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-headline-lg font-headline-lg text-on-surface">Pengajuan Subdomain</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Daftar pengajuan layanan subdomain yang
                masuk. agencies.</p>
        </div>
    </header>

    {{-- haeder --}}
    <div class="bg-surface rounded-xl border border-outline-variant p-6">

        <div class="flex items-start justify-between">

            <div>

                <div class="flex items-center gap-2 mb-2">

                    <h1 class="text-2xl font-bold">
                        {{ $subdomain->nomor_tiket }}
                    </h1>

                    @switch($subdomain->status)
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
                    Permohonan Pembuatan Subdomain
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

        $currentStep = $steps[$subdomain->status] ?? 1;

        $isCancelled = $subdomain->status == 'tutup';
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

            <div class="flex-1 h-1 mx-3 {{ $currentStep > 3 ? 'bg-primary' : 'bg-gray-200' }}"></div>

            {{-- Pembuatan --}}
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
                 bg-yellow-500 text-gray-600
            @else
                bg-gray-200 text-gray-600 @endif">
            </div>

            {{-- Selesai / Cancel --}}
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

        <div class="lg:col-span-8 space-y-6">

            {{-- Data Penanggung Jawab --}}
            {{-- Data Subdomain --}}
            {{-- Dokumen --}}

        </div>

        <div class="lg:col-span-4">

            {{-- Tindakan Admin --}}

        </div>

        {{-- Card Data Penanggung Jawab --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-6">

            <div class="flex items-center gap-2 mb-4">

                <span class="material-symbols-outlined text-primary">
                    badge
                </span>

                <h3 class="font-semibold text-lg">
                    Data Penanggung Jawab
                </h3>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">
                        Nama Lengkap
                    </label>

                    <p>
                        {{ $subdomain->nama_penanggung_jawab }}
                    </p>
                </div>

                <div>
                    <label class="font-semibold">
                        NIP
                    </label>

                    <p>
                        {{ $subdomain->nip_penanggung_jawab }}
                    </p>
                </div>

                <div>
                    <label class="font-semibold">
                        Jabatan
                    </label>

                    <p>
                        {{ $subdomain->jabatan }}
                    </p>
                </div>

                <div>
                    <label class="font-semibold">
                        Pangkat / Golongan
                    </label>

                    <p>
                        {{ $subdomain->pangkat_gol }}
                    </p>
                </div>

                <div>
                    <label class="font-semibold">
                        Nomor HP / WA
                    </label>

                    <p>
                        {{ $subdomain->no_hp }}
                    </p>
                </div>

                <div>
                    <label class="font-semibold">
                        Email
                    </label>

                    <p>
                        {{ $subdomain->email }}
                    </p>
                </div>


            </div>

        </div>

    </div>

    {{-- Card Data Subdomain --}}
    <div class="bg-surface rounded-xl border border-outline-variant p-6">

        <div class="flex items-center gap-2 mb-4">

            <span class="material-symbols-outlined text-primary">
                dns
            </span>

            <h3 class="font-semibold text-lg">
                Data Subdomain
            </h3>

        </div>

        <div class="space-y-4">

            <div>
                <label class="font-semibold">
                    Nama Instansi
                </label>

                <p>
                    {{ $subdomain->nama_instansi }}
                </p>
            </div>

            @if ($subdomain->jenis_layanan == 'ubah_subdomain')
                <div>
                    <label class="font-semibold">
                        Nama Subdomain Lama
                    </label>

                    <p>
                        {{ $subdomain->nama_subdomain }}
                    </p>
                </div>

                <div>
                    <label class="font-semibold">
                        Nama Subdomain Baru
                    </label>

                    <p>
                        {{ $subdomain->nama_subdomain_baru }}
                    </p>
                </div>
            @else
                <div>
                    <label class="font-semibold">
                        Nama Subdomain
                    </label>

                    <p>
                        {{ $subdomain->nama_subdomain }}
                    </p>
                </div>
            @endif

            @php
                $judulDeskripsi = match ($subdomain->jenis_layanan) {
                    'ubah_penanggung' => 'Alasan Perubahan Penanggung Jawab',
                    'ubah_subdomain' => 'Alasan Perubahan Nama Subdomain',
                    'nonaktif' => 'Alasan Penonaktifan Subdomain',
                    default => 'Deskripsi Website',
                };
            @endphp

            <div>
                <label class="font-semibold">
                    {{ $judulDeskripsi }}
                </label>

                <div class="mt-2 p-4 bg-gray-50 border rounded-lg whitespace-pre-line">
                    {{ $subdomain->deskripsi_website }}
                </div>
            </div>

            <div>
                <p class="text-sm text-on-surface-variant">
                    Jenis Layanan
                </p>

                <p class="font-medium">

                    @switch($subdomain->jenis_layanan)
                        @case('baru')
                            Pengajuan Subdomain Baru
                        @break

                        @case('ubah_penanggung')
                            Perubahan Penanggung Jawab Subdomain
                        @break

                        @case('ubah_subdomain')
                            Perubahan Nama Subdomain
                        @break

                        @case('nonaktif')
                            Penonaktifan Subdomain
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

                    <a href="{{ route('admin.subdomain.karpeg', $subdomain) }}" target="_blank"
                        class="px-4 py-2 bg-primary text-white rounded-lg">

                        Buka Dokumen

                    </a>

                </div>

                <div class="border rounded-lg overflow-hidden bg-gray-100">

                    <iframe src="{{ route('admin.subdomain.karpeg', $subdomain) }}" class="w-full h-[700px]">

                    </iframe>

                </div>

            </div>

            {{-- FORMULIR --}}
            <div class="bg-surface rounded-xl border border-outline-variant p-4">

                <div class="flex items-center justify-between mb-4">

                    <h3 class="font-semibold text-lg">
                        Formulir Subdomain
                    </h3>

                    @if ($subdomain->formulir_subdomain)
                        <a href="{{ route('admin.subdomain.formulir', $subdomain) }}" target="_blank"
                            class="px-4 py-2 bg-primary text-white rounded-lg">

                            Buka Dokumen

                        </a>
                    @endif

                </div>

                @if ($subdomain->formulir_subdomain)
                    <div class="border rounded-lg overflow-hidden bg-gray-100">

                        <iframe src="{{ route('admin.subdomain.formulir', $subdomain) }}" class="w-full h-[700px]">

                        </iframe>

                    </div>
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

            @if ($subdomain->formulir_subdomain)
                <form action="{{ route('admin.subdomain.delete-formulir', $subdomain) }}" method="POST"
                    class="mt-4">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        onclick="return confirm('Yakin ingin menghapus formulir yang diupload pemohon?')"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg">

                        Hapus Formulir

                    </button>

                </form>
            @endif

        </div>

    </div>

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

        <form id="status" action="{{ route('admin.subdomain.update-status', $subdomain) }}" method="POST">

            @csrf
            @method('PATCH')

            <div class="space-y-5">

                {{-- Status --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Status Pengajuan
                    </label>

                    <select id="status" name="status"
                        class="w-full rounded-lg border border-outline-variant px-4 py-3">

                        <option value="terbuka" {{ $subdomain->status == 'terbuka' ? 'selected' : '' }}>
                            Pengajuan
                        </option>

                        <option value="baru" {{ $subdomain->status == 'baru' ? 'selected' : '' }}>
                            Pemeriksaan Dokumen
                        </option>

                        <option value="tunda" {{ $subdomain->status == 'tunda' ? 'selected' : '' }}>
                            Persetujuan Pimpinan
                        </option>

                        <option value="diproses" {{ $subdomain->status == 'diproses' ? 'selected' : '' }}>
                            Proses Pembuatan
                        </option>

                        <option value="selesai" {{ $subdomain->status == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>

                        <option value="tutup" {{ $subdomain->status == 'tutup' ? 'selected' : '' }}>
                            Pengajuan Dibatalkan
                        </option>

                    </select>

                    @error('status')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Catatan --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Catatan Admin
                    </label>

                    <textarea name="catatan_admin" rows="6" class="w-full rounded-lg border border-outline-variant px-4 py-3"
                        placeholder="Masukkan catatan untuk pemohon...">{{ old('catatan_admin', $subdomain->catatan_admin) }}</textarea>

                    @error('catatan_admin')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Info --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-700">

                    Catatan ini akan ditampilkan kepada pemohon pada halaman riwayat pengajuan.

                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Catatan Pimpinan
                    </label>

                    @if ($subdomain->catatan_pimpinan)
                        <div class="mt-1 p-3 bg-blue-50 border border-blue-200 rounded-lg">

                            {{ $subdomain->catatan_pimpinan }}

                        </div>
                    @else
                        <p class="text-red-gray text-sm mt-1">
                            Belum ada catatan dari pimpinan.
                        </p>
                    @endif

                </div>
            </div>
        </form>


        <div class="flex flex-col gap-3 mt-3">

            {{-- Saat diproses boleh cetak SK --}}
            @if ($subdomain->status == 'diproses')
                <a href="{{ route('admin.subdomain.cetak-sk', $subdomain) }}" target="_blank"
                    class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">

                    Cetak Surat Penunjukan

                </a>
            @endif

            {{-- Jika sudah ada SK, tampilkan terus --}}
            @if ($subdomain->surat_penunjukan)
                <div class="border rounded-lg p-4 bg-gray-50 mt-3">

                    <h4 class="font-medium mb-3">
                        Surat Penunjukan
                    </h4>

                    <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                        Surat Penunjukan telah diupload.
                    </div>

                    <a href="{{ route('admin.subdomain.download-sk', $subdomain) }}" target="_blank"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">

                        Lihat Surat

                    </a>

                </div>
            @endif

            {{-- Upload hanya saat diproses --}}
            @if ($subdomain->status == 'diproses')
                <div class="border rounded-lg p-4 bg-gray-50 mt-3">

                    <h4 class="font-medium mb-3">
                        Upload Surat Penunjukan Final
                    </h4>

                    <form action="{{ route('admin.subdomain.upload-sk', $subdomain) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <input type="file" name="surat_penunjukan" accept=".pdf" class="w-full border p-2 mb-3">

                        <button type="submit"
                            class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">

                            {{ $subdomain->surat_penunjukan ? 'Upload Ulang Surat' : 'Upload Surat Penunjukan' }}

                        </button>

                    </form>

                </div>
            @endif

            <div class="flex gap-3">

                <button type="submit" form="status"
                    class="flex-1 bg-primary text-white py-3 rounded-lg font-medium hover:opacity-90 transition">

                    Simpan Perubahan

                </button>

                <a href="{{ route('admin.subdomain') }}"
                    class="flex-1 text-center border border-outline-variant py-3 rounded-lg font-medium hover:bg-surface-container transition">

                    Kembali

                </a>

            </div>

            @if (!in_array($subdomain->status, ['tunda', 'selesai', 'tutup']))
                <form id="sendToLeaderForm" action="{{ route('admin.subdomain.send-to-leader', $subdomain) }}"
                    method="POST">

                    @csrf
                    @method('PATCH')

                    <button type="button" onclick="confirmSendToLeader()"
                        class="w-full bg-amber-500 text-white py-3 rounded-lg font-medium hover:bg-amber-600 transition">

                        <span class="material-symbols-outlined align-middle text-[18px] mr-1">
                            approval
                        </span>

                        Kirim ke Pimpinan

                    </button>

                </form>
            @endif

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
