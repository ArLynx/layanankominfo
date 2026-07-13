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
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition
        {{ request('tab', 'subdomain') == 'subdomain'
            ? 'bg-primary text-white'
            : 'border border-outline-variant text-on-surface hover:bg-surface-container' }}">

                    <span>Subdomain</span>

                    <span class="text-xs font-semibold opacity-80">
                        ({{ $subdomainCount }})
                    </span>

                </a>

                <a href="{{ route('riwayat.index', ['tab' => 'email-satker']) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition
        {{ request('tab') == 'email-satker'
            ? 'bg-primary text-white'
            : 'border border-outline-variant text-on-surface hover:bg-surface-container' }}">

                    <span>Email Satker</span>

                    <span class="text-xs font-semibold opacity-80">
                        ({{ $emailSatkerCount }})
                    </span>

                </a>

                <a href="{{ route('riwayat.index', ['tab' => 'email-pribadi']) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition
        {{ request('tab') == 'email-pribadi'
            ? 'bg-primary text-white'
            : 'border border-outline-variant text-on-surface hover:bg-surface-container' }}">

                    <span>Email Pribadi</span>

                    <span class="text-xs font-semibold opacity-80">
                        ({{ $emailPribadiCount }})
                    </span>

                </a>

            </div>

            {{-- FILTER --}}
            <form method="GET" class="flex gap-3 mb-6">

                <input type="hidden" name="tab" value="{{ request('tab', 'subdomain') }}">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket..."
                    class="border rounded-lg px-3 py-2">

                <select name="status" class="border rounded-lg px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="terbuka" {{ request('status') == 'terbuka' ? 'selected' : '' }}>Pengajuan</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Pemeriksaan Dokumen</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Proses Pembuatan
                    </option>
                    <option value="tunda" {{ request('status') == 'tunda' ? 'selected' : '' }}>Persetujuan Pimpinan
                    </option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="tutup" {{ request('status') == 'tutup' ? 'selected' : '' }}>Pengajuan Dicancel</option>
                </select>

                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">
                    Cari
                </button>

            </form>

            @if (request('tab', 'subdomain') == 'subdomain')
                {{-- TABEL SUBDOMAIN --}}
                <div class="overflow-x-auto">

                    <table class="w-full border">

                        <thead>

                            <tr class="bg-gray-100">

                                <th class="p-3 text-center">No</th>
                                <th class="p-3 text-left">Nomor Tiket</th>
                                <th class="p-3 text-left">Nama Subdomain</th>
                                <th class="p-3 text-left">Jenis Layanan</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Tanggal</th>
                                <th class="p-3 text-center">Catatan</th>
                                <th class="p-3 text-center">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($subdomains ?? [] as $item)
                                <tr>

                                    <td class="p-3 text-center">
                                        {{ $subdomains->firstItem() + $loop->index }}
                                    </td>

                                    <td class="p-3">
                                        {{ $item->nomor_tiket }}
                                    </td>

                                    <td class="p-3">
                                        {{ $item->nama_subdomain }}
                                    </td>

                                    <td class="p-3">

                                        @switch($item->jenis_layanan)
                                            @case('baru')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                                    Pengajuan Subdomain Baru
                                                </span>
                                            @break

                                            @case('ubah_penanggung')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">
                                                    Perubahan Penanggung Jawab Subdomain
                                                </span>
                                            @break

                                            @case('ubah_subdomain')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium">
                                                    Perubahan Nama Subdomain
                                                </span>
                                            @break

                                            @case('nonaktif')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">
                                                    Penonaktifan Subdomain
                                                </span>
                                            @break
                                        @endswitch

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

                                    <td class="text-center">

                                        @if ($item->catatan_admin)
                                            <button onclick="showCatatan(`{{ addslashes($item->catatan_admin) }}`)"
                                                class="text-amber-600 hover:text-amber-800">

                                                <span class="material-symbols-outlined">

                                                    sticky_note_2

                                                </span>

                                            </button>
                                        @else
                                            <span class="text-gray-400">

                                                -

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

                                        <td colspan="8" class="text-center p-5">

                                            Belum ada data pengajuan

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-5">

                        @if ($subdomains && $subdomains->hasPages())
                            <div class="mt-5">
                                {{ $subdomains->links() }}
                            </div>
                        @endif

                    </div>
                @elseif (request('tab') == 'email-satker')
                    {{-- TABEL EMAIL SATKER --}}

                    <div class="overflow-x-auto">

                        <table class="w-full border">

                            <thead>

                                <tr class="bg-gray-100">

                                    <th class="p-3">No</th>
                                    <th class="p-3">Nomor Tiket</th>
                                    <th class="p-3">Nama Email</th>
                                    <th class="p-3">Jenis Layanan</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3 text-center">Catatan</th>
                                    <th class="p-3">Aksi</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($emailSatkers ?? [] as $item)
                                    <tr>

                                        <td class="p-3 text-center">
                                            {{ $emailSatkers->firstItem() + $loop->index }}
                                        </td>

                                        <td class="p-3">
                                            {{ $item->nomor_tiket }}
                                        </td>

                                        <td class="p-3">
                                            {{ $item->nama_akun_dinas }}
                                        </td>

                                        <td class="p-3">

                                            @switch($item->jenis_layanan)
                                                @case('baru')
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                                        Pengajuan Email Satker Baru
                                                    </span>
                                                @break

                                                @case('reset')
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-medium">
                                                        Reset Password
                                                    </span>
                                                @break

                                                @case('reaktivasi')
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                                        Reaktivasi Akun
                                                    </span>
                                                @break

                                                @case('ubah_akun')
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium">
                                                        Perubahan Nama Akun Email
                                                    </span>
                                                @break

                                                @case('ubah_penanggung')
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">
                                                        Perubahan Penanggung Jawab Email
                                                    </span>
                                                @break

                                                @default
                                                    <span class="text-gray-400">
                                                        -
                                                    </span>
                                            @endswitch

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
                                                        Pengajuan Dibatalkan
                                                    </span>
                                                @break
                                            @endswitch

                                        </td>

                                        <td class="p-3">
                                            {{ $item->created_at->format('d-m-Y') }}
                                        </td>

                                        <td class="text-center">

                                            @if ($item->catatan_admin)
                                                <button onclick="showCatatan(`{{ addslashes($item->catatan_admin) }}`)"
                                                    class="text-amber-600 hover:text-amber-800">

                                                    <span class="material-symbols-outlined">
                                                        sticky_note_2
                                                    </span>

                                                </button>
                                            @else
                                                -
                                            @endif

                                        </td>

                                        <td class="p-3">

                                            <a href="{{ route('email-satker.show', $item) }}"
                                                class="bg-primary text-white px-3 py-2 rounded">

                                                Detail

                                            </a>

                                        </td>

                                    </tr>

                                    @empty

                                        <tr>

                                            <td colspan="8" class="text-center p-5">

                                                Belum ada data Email Satker

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-5">

                            @if ($emailSatkers && $emailSatkers->hasPages())
                                <div class="mt-5">
                                    {{ $emailSatkers->links() }}
                                </div>
                            @endif

                        </div>
                    @elseif (request('tab') == 'email-pribadi')
                        {{-- TABEL EMAIL PRIBADI --}}

                        <div class="overflow-x-auto">

                            <table class="w-full border">

                                <thead>

                                    <tr class="bg-gray-100">

                                        <th class="p-3">No</th>
                                        <th class="p-3">Nomor Tiket</th>
                                        <th class="p-3">Nama Pegawai</th>
                                        <th class="p-3">Nama Email</th>
                                        <th class="p-3">Jenis Layanan</th>
                                        <th class="p-3">Status</th>
                                        <th class="p-3">Tanggal</th>
                                        <th class="p-3 text-center">Catatan</th>
                                        <th class="p-3">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($emailPribadis ?? [] as $item)
                                        <tr>

                                            <td class="p-3 text-center">
                                                {{ $emailPribadis->firstItem() + $loop->index }}
                                            </td>

                                            <td class="p-3">
                                                {{ $item->nomor_tiket }}
                                            </td>

                                            <td class="p-3">
                                                {{ $item->nama }}
                                            </td>

                                            <td class="p-3">
                                                {{ $item->email }}
                                            </td>

                                            <td class="p-3">

                                                @switch($item->jenis_layanan)
                                                    @case('baru')
                                                        <span
                                                            class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                                            Permohonan Baru
                                                        </span>
                                                    @break

                                                    @case('reset')
                                                        <span
                                                            class="inline-flex px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-medium">
                                                            Reset Password
                                                        </span>
                                                    @break

                                                    @case('reaktivasi')
                                                        <span
                                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                                            Reaktivasi Akun
                                                        </span>
                                                    @break

                                                    @case('ubah_akun')
                                                        <span
                                                            class="inline-flex px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium">
                                                            Ganti Nama Akun
                                                        </span>
                                                    @break

                                                    @default
                                                        <span class="text-gray-400">
                                                            -
                                                        </span>
                                                @endswitch

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
                                                            Pengajuan Dibatalkan
                                                        </span>
                                                    @break
                                                @endswitch

                                            </td>

                                            <td class="p-3">
                                                {{ $item->created_at->format('d-m-Y') }}
                                            </td>

                                            <td class="text-center">

                                                @if ($item->catatan_admin)
                                                    <button onclick="showCatatan(`{{ addslashes($item->catatan_admin) }}`)"
                                                        class="text-amber-600 hover:text-amber-800">

                                                        <span class="material-symbols-outlined">
                                                            sticky_note_2
                                                        </span>

                                                    </button>
                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td class="p-3">

                                                <a href="{{ route('email-pribadi.show', $item) }}"
                                                    class="bg-primary text-white px-3 py-2 rounded">

                                                    Detail

                                                </a>

                                            </td>

                                        </tr>

                                        @empty

                                            <tr>

                                                <td colspan="9" class="text-center p-5">

                                                    Belum ada data Email Pribadi

                                                </td>

                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                            <div class="mt-5">

                                @if ($emailPribadis && $emailPribadis->hasPages())
                                    <div class="mt-5">
                                        {{ $emailPribadis->links() }}
                                    </div>
                                @endif

                            </div>
                        @endif

                    </div>
                </main>

                {{-- modal catatan --}}
                <div id="catatanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

                    <div class="bg-white rounded-xl w-full max-w-lg p-6">

                        <div class="flex justify-between items-center mb-5">

                            <h3 class="font-bold text-lg">

                                Catatan Admin

                            </h3>

                            <button onclick="closeCatatan()">

                                ✕

                            </button>

                        </div>

                        <div id="isiCatatan" class="whitespace-pre-line leading-7 text-gray-700">

                        </div>

                    </div>

                </div>

                <script>
                    function showCatatan(catatan) {

                        document.getElementById('isiCatatan').innerHTML = catatan;

                        document.getElementById('catatanModal').classList.remove('hidden');

                        document.getElementById('catatanModal').classList.add('flex');

                    }

                    function closeCatatan() {

                        document.getElementById('catatanModal').classList.add('hidden');

                        document.getElementById('catatanModal').classList.remove('flex');

                    }
                </script>

            @endsection
