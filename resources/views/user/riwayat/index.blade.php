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
        <div class="p-6">

            <h1 class="text-2xl font-bold mb-6">
                Riwayat Pengajuan
            </h1>

            {{-- TAB --}}
            <div class="flex gap-3 mb-6">

                <a href="{{ route('riwayat.index', ['tab' => 'subdomain']) }}"
                    class="px-4 py-2 rounded-lg bg-primary text-white">
                    Subdomain
                </a>

                <a href="{{ route('riwayat.index', ['tab' => 'email-satker']) }}" class="px-4 py-2 rounded-lg border">
                    Email Satker
                </a>

                <a href="{{ route('riwayat.index', ['tab' => 'email-pribadi']) }}" class="px-4 py-2 rounded-lg border">
                    Email Pribadi
                </a>

            </div>

            {{-- FILTER --}}
            <form method="GET" class="flex gap-3 mb-6">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket..."
                    class="border rounded-lg px-3 py-2">

                <select name="status" class="border rounded-lg px-3 py-2">

                    <option value="">Semua Status</option>

                    <option>Semua Status</option>
                    <option value="terbuka">Pengajuan</option>
                    <option value="baru">Pemeriksaan Dokumen</option>
                    <option value="diproses">Proses Pembuatan</option>
                    <option value="tunda">Persetujuan Pimpinan</option>
                    <option value="selesai">Selesai</option>
                    <option value="tutup">Pengajuan Dicancel</option>

                </select>

                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">
                    Cari
                </button>

            </form>

            {{-- TABEL SUBDOMAIN --}}
            <div class="overflow-x-auto">

                <table class="w-full border">

                    <thead>

                        <tr class="bg-gray-100">

                            <th class="p-3 text-left">
                                Nomor Tiket
                            </th>

                            <th class="p-3 text-left">
                                Nama Subdomain
                            </th>

                            <th class="p-3 text-left">
                                Status
                            </th>

                            <th class="p-3 text-left">
                                Tanggal
                            </th>

                            <th class="p-3 text-left">
                                Catatan
                            </th>

                            <th class="p-3 text-left">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($subdomains as $item)
                            <tr>

                                <td class="p-3">
                                    {{ $item->nomor_tiket }}
                                </td>

                                <td class="p-3">
                                    {{ $item->nama_subdomain }}
                                </td>

                                <td class="p-3">

                                    @switch($item->status)
                                        @case('terbuka')
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                                Pengajuan
                                            </span>
                                        @break

                                        @case('baru')
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                                Pemeriksaan Dokumen
                                            </span>
                                        @break

                                        @case('diproses')
                                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                                Proses Pembuatan
                                            </span>
                                        @break

                                        @case('tunda')
                                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded">
                                                Persetujuan
                                            </span>
                                        @break

                                        @case('selesai')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                                Selesai
                                            </span>
                                        @break

                                        @case('tutup')
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                                Pengajuan ditolak
                                            </span>
                                        @break

                                        @default
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                                Tutup
                                            </span>
                                    @endswitch

                                </td>

                                <td class="p-3">
                                    {{ $item->created_at->format('d-m-Y') }}
                                </td>

                                <td class="p-3">

                                    @if ($item->catatan_admin)
                                        <div
                                            class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg px-3 py-2 text-sm">

                                            {{ $item->catatan_admin }}

                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">
                                            Tidak ada catatan
                                        </span>
                                    @endif

                                </td>

                                <td class="p-3">

                                    <a href="{{ route('subdomain.show', $item->id) }}"
                                        class="bg-primary text-white px-3 py-2 rounded">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center p-5">

                                        Belum ada data pengajuan

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-5">

                    {{ $subdomains->links() }}

                </div>

            </div>
        </main>
    @endsection
