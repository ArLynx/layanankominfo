<x-pimpinan-layout title="Pengajuan Email Satuan Kerja">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-border-subtle pb-6">
        <div>
            <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                Pengajuan Email Satuan Kerja
            </h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Daftar pengajuan email satuan kerja yang masuk</p>
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
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Akun Dinas</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                        <th class="px-6 py-4 text-center text-label-sm font-label-sm text-on-surface-variant">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface">
                    @forelse ($emailSatkers as $item)
                        <tr class="border-b border-border-subtle hover:bg-surface-gray/30 transition-colors">
                            <td class="px-6 py-4">{{ $emailSatkers->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-mono text-sm">{{ $item->nomor_tiket }}</td>
                            <td class="px-6 py-4">{{ $item->nama_penanggung_jawab }}</td>
                            <td class="px-6 py-4">{{ $item->nama_instansi }}</td>
                            <td class="px-6 py-4">{{ $item->nama_akun_dinas }}</td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'terbuka')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-label-sm font-label-sm bg-indigo-100 text-indigo-700 border border-indigo-200">Pengajuan</span>
                                @elseif ($item->status == 'baru')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-label-sm font-label-sm bg-indigo-100 text-indigo-700 border border-indigo-200">Pemeriksaan Dokumen</span>
                                @elseif ($item->status == 'tunda')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-label-sm font-label-sm bg-yellow-100 text-yellow-700 border border-yellow-200">Persetujuan Pimpinan</span>
                                @elseif ($item->status == 'diproses')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-label-sm font-label-sm bg-indigo-100 text-indigo-700 border border-indigo-200">Proses Pembuatan</span>
                                @elseif ($item->status == 'selesai')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-label-sm font-label-sm bg-green-100 text-green-700 border border-green-200">Selesai</span>
                                @elseif ($item->status == 'tutup')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-label-sm font-label-sm bg-red-100 text-red-700 border border-red-200">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-caption text-on-surface-variant">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pimpinan.email-satker.detail', $item) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary text-white">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">Belum ada pengajuan email satuan kerja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-border-subtle">
            <div class="flex items-center justify-between">
                <div class="text-sm text-on-surface-variant">
                    Menampilkan {{ $emailSatkers->firstItem() ?? 0 }} - {{ $emailSatkers->lastItem() ?? 0 }} dari {{ $emailSatkers->total() }} data
                </div>
                {{ $emailSatkers->links() }}
            </div>
        </div>
    </div>
</x-pimpinan-layout>
