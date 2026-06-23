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

        <div class="max-w-3xl mx-auto py-12">

            <div class="bg-white rounded-xl shadow border p-8 text-center">

                <div class="mb-6">
                    <span class="material-symbols-outlined text-green-600 text-7xl">
                        check_circle
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-green-600 mb-3">
                    Pengajuan Berhasil Dikirim
                </h1>

                <p class="text-gray-600 mb-8">
                    Dokumen aplikasi Anda telah berhasil kami terima. Tim administrasi kami akan segera melakukan verifikasi
                    terhadap data yang dilampirkan.
                </p>

                <div class="bg-gray-50 border rounded-lg p-6 mb-8">

                    <p class="text-sm text-gray-500 mb-2">
                        Nomor Tiket
                    </p>

                    <h2 class="text-3xl font-bold text-blue-900">
                        {{ $subdomain->nomor_tiket }}
                    </h2>

                    @php
                        $statusStep = [
                            'terbuka' => 'Pengajuan',
                            'baru' => 'Pemeriksaan Dokumen',
                            'diproses' => 'Proses Pembuatan',
                            'tunda' => 'Persetujuan',
                            'selesai' => 'Selesai',
                            'tutup' => 'Ditutup',
                        ];
                    @endphp

                    <p class="text-sm text-gray-500 mt-3">
                        Status Saat Ini:
                        {{ $statusStep[$subdomain->status] }}
                    </p>

                </div>

                <div class="flex justify-center gap-3">

                    <a href="{{ route('riwayat.index') }}" class="px-6 py-3 bg-primary text-white rounded-lg">

                        Riwayat Pengajuan
                    </a>

                    <a href="{{ route('subdomain.show', $subdomain->id) }}" class="px-6 py-3 border rounded-lg">

                        Detail Pengajuan
                    </a>

                </div>

            </div>

        </div>
    </main>
@endsection
