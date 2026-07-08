<x-pimpinan-layout title="Dashboard Pimpinan">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-border-subtle pb-6">
        <div>
            <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                Monitoring Layanan KOMINFO
            </h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Pantau statistik dan seluruh permohonan layanan secara real-time.</p>
        </div>
    </header>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Total</p>
            <p class="text-headline-md font-headline-md text-primary">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm border-l-4 border-l-blue-500">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Terbuka</p>
            <p class="text-headline-md font-headline-md text-blue-600">{{ $stats['terbuka'] }}</p>
        </div>
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm border-l-4 border-l-yellow-500">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Pemeriksaan</p>
            <p class="text-headline-md font-headline-md text-yellow-600">{{ $stats['baru'] }}</p>
        </div>
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm border-l-4 border-l-orange-500">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Persetujuan</p>
            <p class="text-headline-md font-headline-md text-orange-600">{{ $stats['tunda'] }}</p>
        </div>
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm border-l-4 border-l-indigo-500">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Diproses</p>
            <p class="text-headline-md font-headline-md text-indigo-600">{{ $stats['diproses'] }}</p>
        </div>
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm border-l-4 border-l-green-500">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Selesai</p>
            <p class="text-headline-md font-headline-md text-green-600">{{ $stats['selesai'] }}</p>
        </div>
        <div class="bg-surface border border-border-subtle rounded-xl p-4 shadow-sm border-l-4 border-l-red-500">
            <p class="text-caption font-caption text-on-surface-variant mb-1">Ditolak</p>
            <p class="text-headline-md font-headline-md text-red-600">{{ $stats['tutup'] }}</p>
        </div>
    </div>

    <div class="bg-surface border border-border-subtle rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border-subtle bg-surface-gray">
            <h3 class="text-headline-md font-headline-md text-on-surface">Daftar Pengajuan Subdomain</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle bg-surface-gray/50">
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">No</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Nomor Tiket</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Pemohon</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Subdomain</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface">
                    @forelse($subdomains as $subdomain)
                        <tr class="border-b border-border-subtle hover:bg-surface-gray/30 transition-colors">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-mono text-sm">{{ $subdomain->nomor_tiket }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $subdomain->nama_penanggung_jawab }}</div>
                                <div class="text-caption text-on-surface-variant">{{ $subdomain->nama_instansi }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $subdomain->nama_subdomain }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-label-sm font-label-sm 
                                    {{ $subdomain->status === 'terbuka' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                                    {{ $subdomain->status === 'baru' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : '' }}
                                    {{ $subdomain->status === 'tunda' ? 'bg-orange-100 text-orange-700 border border-orange-200' : '' }}
                                    {{ $subdomain->status === 'diproses' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : '' }}
                                    {{ $subdomain->status === 'selesai' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                    {{ $subdomain->status === 'tutup' ? 'bg-gray-100 text-gray-700 border border-gray-200' : '' }}">
                                    {{ ucfirst($subdomain->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-caption text-on-surface-variant">{{ $subdomain->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">Tidak ada data permohonan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-pimpinan-layout>
