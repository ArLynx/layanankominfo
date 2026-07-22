<x-admin-layout title="Log Aktivitas">

    <div x-data="{
        openModal: false,
        selectedLog: {}
    }">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h1 class="text-headline-large font-bold text-on-surface">

                    Log Aktivitas

                </h1>

                <p class="mt-1 text-on-surface-variant">

                    Menampilkan seluruh aktivitas Admin, Pimpinan, dan Super Admin pada Sistem Layanan Diskominfo
                    Kabupaten
                    Murung Raya.

                </p>

            </div>

        </div>

        {{-- Filter --}}
        <section class="bg-surface-container-lowest rounded-xl border border-border-subtle p-5 mb-6">

            <form method="GET">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    {{-- Search --}}
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..."
                        class="rounded-lg border border-border-subtle px-4 py-2">

                    {{-- Role --}}
                    <select name="role" class="rounded-lg border border-border-subtle px-4 py-2">

                        <option value="">Semua Role</option>

                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>

                            Admin

                        </option>

                        <option value="pimpinan" {{ request('role') == 'pimpinan' ? 'selected' : '' }}>

                            Pimpinan

                        </option>

                        <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>

                            Super Admin

                        </option>

                    </select>

                    {{-- Modul --}}
                    <select name="modul" class="rounded-lg border border-border-subtle px-4 py-2">

                        <option value="">Semua Modul</option>

                        <option value="Subdomain">Subdomain</option>

                        <option value="Email Satker">Email Satker</option>

                        <option value="Email Pribadi">Email Pribadi</option>

                        <option value="Manajemen User">Manajemen User</option>

                        <option value="Manajemen Admin">Manajemen Admin</option>

                    </select>

                    <button class="bg-primary text-on-primary rounded-lg">

                        Cari

                    </button>

                </div>

            </form>

        </section>

        {{-- Table --}}
        <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead>

                        <tr
                            class="bg-surface-gray border-b border-border-subtle text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">

                            <th class="px-6 py-3">Waktu</th>

                            <th class="px-6 py-3">Nama</th>

                            <th class="px-6 py-3">Role</th>

                            <th class="px-6 py-3">Aksi</th>

                            <th class="px-6 py-3">Modul</th>

                            <th class="px-6 py-3">Nomor Tiket</th>

                            <th class="px-6 py-3">Detail</th>

                        </tr>

                    </thead>

                    <tbody class="text-body-md font-body-md text-on-surface divide-y divide-border-subtle">

                        @forelse($logs as $log)
                            <tr class="hover:bg-surface-gray transition-colors">

                                <td class="px-6 py-4 whitespace-nowrap">

                                    {{ $log->created_at->format('d-m-Y H:i') }}

                                </td>

                                <td class="px-6 py-4 font-medium">

                                    {{ $log->actor_name }}

                                </td>

                                <td class="px-6 py-4">

                                    @if ($log->role == 'superadmin')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">

                                            Super Admin

                                        </span>
                                    @elseif($log->role == 'pimpinan')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">

                                            Pimpinan

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-container text-on-primary-container">

                                            Admin

                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    {{ $log->aksi }}

                                </td>

                                <td class="px-6 py-4">

                                    {{ $log->modul }}

                                </td>

                                <td class="px-6 py-4">

                                    {{ $log->nomor_tiket ?? '-' }}

                                </td>

                                <td class="px-6 py-4">

                                    <button
                                        @click="
                                        openModal = true;
                                        selectedLog = {
                                            waktu: '{{ $log->created_at->translatedFormat('d F Y H:i') }} WIB',
                                            nama: '{{ $log->actor_name }}',
                                            role: '{{ ucfirst($log->role) }}',
                                            aksi: '{{ $log->aksi }}',
                                            modul: '{{ $log->modul }}',
                                            tiket: '{{ $log->nomor_tiket ?? '-' }}',
                                            detail: @js($log->detail),
                                            ip: '{{ $log->ip_address }}'
                                        }
                                    "
                                        class="text-primary hover:underline font-medium">

                                        Lihat Detail

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-8 text-center text-on-surface-variant">

                                    Belum ada aktivitas.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="px-6 py-4 border-t border-border-subtle bg-surface">

                {{ $logs->withQueryString()->links() }}

            </div>

        </section>

        {{-- Modal Detail --}}
        <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

            <div @click.outside="openModal=false" class="bg-white rounded-xl shadow-xl w-full max-w-2xl">

                {{-- Header --}}
                <div class="flex justify-between items-center px-6 py-4 border-b">

                    <h2 class="text-xl font-semibold">

                        Detail Aktivitas

                    </h2>

                    <button @click="openModal=false">

                        <span class="material-symbols-outlined">

                            close

                        </span>

                    </button>

                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4">

                    <div class="grid grid-cols-2 gap-5">

                        <div>

                            <label class="text-sm text-gray-500">

                                Waktu

                            </label>

                            <p x-text="selectedLog.waktu"></p>

                        </div>

                        <div>

                            <label class="text-sm text-gray-500">

                                Nama

                            </label>

                            <p x-text="selectedLog.nama"></p>

                        </div>

                        <div>

                            <label class="text-sm text-gray-500">

                                Role

                            </label>

                            <p x-text="selectedLog.role"></p>

                        </div>

                        <div>

                            <label class="text-sm text-gray-500">

                                Modul

                            </label>

                            <p x-text="selectedLog.modul"></p>

                        </div>

                        <div>

                            <label class="text-sm text-gray-500">

                                Nomor Tiket

                            </label>

                            <p x-text="selectedLog.tiket"></p>

                        </div>

                        <div>

                            <label class="text-sm text-gray-500">

                                IP Address

                            </label>

                            <p x-text="selectedLog.ip"></p>

                        </div>

                    </div>

                    <div>

                        <label class="text-sm text-gray-500">

                            Aksi

                        </label>

                        <p class="font-medium" x-text="selectedLog.aksi"></p>

                    </div>

                    <div>

                        <label class="text-sm text-gray-500">

                            Detail Aktivitas

                        </label>

                        <div class="mt-2 rounded-lg bg-gray-50 p-4 border">

                            <p x-text="selectedLog.detail"></p>

                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex justify-end px-6 py-4 border-t">

                    <button @click="openModal=false" class="px-4 py-2 rounded-lg bg-primary text-white">

                        Tutup

                    </button>

                </div>

            </div>

        </div>

    </div>
</x-admin-layout>
