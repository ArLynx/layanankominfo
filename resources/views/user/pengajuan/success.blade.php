@extends('user.layouts.app')

@section('content')

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
                    Dokumen aplikasi Anda telah berhasil kami terima.
                    <span class="font-semibold text-gray-900">
                        Silakan download formulir untuk ditandatangani pada Detail Pengajuan.
                    </span>
                    Tim administrasi kami akan segera melakukan verifikasi terhadap data yang dilampirkan.
                </p>

                <div class="bg-gray-50 border rounded-lg p-6 mb-8">

                    <p class="text-sm text-gray-500 mb-2">
                        Nomor Tiket
                    </p>

                    <h2 class="text-3xl font-bold text-blue-900">
                        @if (isset($subdomain))
                            {{ $subdomain->nomor_tiket }}
                        @elseif(isset($emailSatker))
                            {{ $emailSatker->nomor_tiket }}
                        @elseif(isset($emailPribadi))
                            {{ $emailPribadi->nomor_tiket }}
                        @endif
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
                        @if (isset($subdomain))
                            {{ $statusStep[$subdomain->status] }}
                        @elseif(isset($emailSatker))
                            {{ $statusStep[$emailSatker->status] }}
                        @elseif(isset($emailPribadi))
                            {{ $statusStep[$emailPribadi->status] }}
                        @endif
                    </p>

                </div>

                <div class="flex justify-center gap-3">

                    <a href="{{ route('riwayat.index') }}" class="px-6 py-3 bg-primary text-white rounded-lg">

                        Riwayat Pengajuan
                    </a>

                    @if (isset($subdomain))
                        <a href="{{ route('subdomain.show', $subdomain) }}" class="px-6 py-3 border rounded-lg">

                            Detail Pengajuan

                        </a>
                    @elseif(isset($emailSatker))
                        <a href="{{ route('email-satker.show', $emailSatker) }}" class="px-6 py-3 border rounded-lg">

                            Detail Pengajuan

                        </a>
                    @elseif(isset($emailPribadi))
                        <a href="{{ route('email-pribadi.show', $emailPribadi) }}" class="px-6 py-3 border rounded-lg">

                            Detail Pengajuan

                        </a>
                    @endif

                </div>

            </div>

        </div>
    </main>
@endsection
