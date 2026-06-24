@extends('user.layouts.app')

@section('content')
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
        </div>
    </header>

    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-2xl font-bold mb-4">
                    Detail Pengajuan Subdomain
                </h2>

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label class="font-semibold">
                            Nomor Tiket
                        </label>

                        <p>
                            {{ $subdomain->nomor_tiket }}
                        </p>
                    </div>

                    <div>
                        <label class="font-semibold">
                            Status
                        </label>

                        <p>

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
                                    Pengajuan Dicancel
                                @break

                                @default
                                    -
                            @endswitch

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

                    <div>

                        <label class="font-semibold">
                            Jenis Layanan
                        </label>

                        <p>

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

                        <p>
                            {{ $subdomain->deskripsi_website }}
                        </p>
                    </div>

                    <div>
                        <label class="font-semibold">
                            Nama Penanggung Jawab
                        </label>

                        <p>
                            {{ $subdomain->nama_penanggung_jawab }}
                        </p>
                    </div>

                    <div>
                        <label class="font-semibold">
                            No HP Penanggung Jawab
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

                    <div>
                        <label class="font-semibold">
                            Tanggal Pengajuan
                        </label>

                        <p>
                            {{ $subdomain->created_at->format('d-m-Y H:i') }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="mt-6">

                <a href="{{ route('subdomain.cetak', $subdomain) }}" target="_blank"
                    class="px-4 py-2 bg-blue-600 text-white rounded">

                    Cetak Formulir

                </a>

            </div>

            @if (!$subdomain->formulir_subdomain)
                <div class="mt-6">

                    <form action="{{ route('subdomain.upload-formulir', $subdomain) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <label class="block mb-2">

                            Upload Formulir yang Sudah Ditandatangani

                        </label>

                        <input type="file" name="formulir_subdomain" accept=".pdf" class="border p-2">

                        @error('formulir_subdomain')
                            <p class="text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                        <button type="submit" class="ml-2 px-4 py-2 bg-green-600 text-white rounded">

                            Upload

                        </button>

                    </form>

                </div>
            @endif

            @if ($subdomain->formulir_subdomain)
                <div class="mt-6 p-4 bg-green-50 border border-green-300 rounded">

                    <p class="text-green-700 font-medium mb-2">
                        Formulir TTD sudah diupload
                    </p>

                    <div class="flex gap-4">

                        <a href="{{ route('subdomain.download-formulir', $subdomain->id) }}"
                            target="_blank"class="text-blue-600 hover:underline">

                            Download Formulir

                        </a>

                    </div>

                </div>
            @endif

            @if ($subdomain->surat_penunjukan)
                <div class="mt-6 p-4 bg-blue-50 border border-blue-300 rounded">

                    <p class="text-blue-700 font-medium mb-2">
                        Surat Penunjukan telah tersedia
                    </p>

                    <a href="{{ route('subdomain.download-sk-penunjukan', $subdomain) }}" target="_blank"
                        class="text-blue-600 hover:underline">

                        Download Surat Penunjukan

                    </a>

                </div>
            @endif

        </div>
    </main>
@endsection
