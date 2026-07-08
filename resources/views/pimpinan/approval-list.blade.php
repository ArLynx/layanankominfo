<x-pimpinan-layout title="Persetujuan Pimpinan">
    @if (session('success'))
        <script>Swal.fire({icon:'success',title:'Berhasil',text:@json(session('success')),confirmButtonText:'OK'});</script>
    @endif

    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-border-subtle pb-6">
        <div>
            <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                Persetujuan Pimpinan
            </h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Daftar pengajuan subdomain yang menunggu persetujuan Anda</p>
        </div>
    </header>

    <div class="bg-surface border border-border-subtle rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle bg-surface-gray/50">
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">No</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Nomor Tiket</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Pemohon</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Instansi</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Nama Subdomain</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                        <th class="px-6 py-4 text-center text-label-sm font-label-sm text-on-surface-variant">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface">
                    @forelse ($subdomains as $subdomain)
                        <tr class="border-b border-border-subtle hover:bg-surface-gray/30 transition-colors">
                            <td class="px-6 py-4">{{ $subdomains->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-mono text-sm">{{ $subdomain->nomor_tiket }}</td>
                            <td class="px-6 py-4">{{ $subdomain->nama_penanggung_jawab }}</td>
                            <td class="px-6 py-4">{{ $subdomain->nama_instansi }}</td>
                            <td class="px-6 py-4">{{ $subdomain->nama_subdomain }}</td>
                            <td class="px-6 py-4 text-caption text-on-surface-variant">{{ $subdomain->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pimpinan.approval-show', $subdomain) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">approval</span>
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3 block">check_circle</span>
                                Tidak ada pengajuan yang menunggu persetujuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-border-subtle">
            <div class="flex items-center justify-between">
                <div class="text-sm text-on-surface-variant">
                    Menampilkan {{ $subdomains->firstItem() ?? 0 }} - {{ $subdomains->lastItem() ?? 0 }} dari {{ $subdomains->total() }} data
                </div>
                {{ $subdomains->links() }}
            </div>
        </div>
    </div>
</x-pimpinan-layout>
