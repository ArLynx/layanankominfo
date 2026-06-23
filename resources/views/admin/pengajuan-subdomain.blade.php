<x-admin-layout title="Pengajuan Subdomain">

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error')),
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-headline-lg font-headline-lg text-on-surface">Pengajuan Subdomain</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Daftar pengajuan layanan subdomain yang
                masuk</p>
        </div>
    </header>

    {{-- Filter --}}
    <div class="bg-surface rounded-xl border border-outline-variant p-4">

        <form class="flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[300px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tiket, nama pemohon, atau subdomain..."
                    class="w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface">
            </div>

            <div>
                <select class="px-4 py-3 rounded-lg border border-outline-variant bg-surface min-w-[180px]">
                    <option>Semua Status</option>
                    <option value="terbuka">Pengajuan</option>
                    <option value="baru">Pemeriksaan Dokumen</option>
                    <option value="tunda">Persetujuan Pimpinan</option>
                    <option value="diproses">Proses Pembuatan</option>
                    <option value="selesai">Selesai</option>
                    <option value="tutup">Pengajuan Dicancel</option>
                </select>
            </div>

            <button type="submit" class="px-6 py-3 rounded-lg bg-primary text-on-primary font-medium">
                Cari
            </button>

        </form>

    </div>

    {{-- Tabel --}}
    <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-surface-container">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">
                            Nomor Tiket
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Pemohon
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Instansi
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Nama Subdomain
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Aksi
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($subdomains as $subdomain)
                        <tr class="border-t border-outline-variant">

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $subdomain->nomor_tiket }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $subdomain->nama_penanggung_jawab }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $subdomain->nama_instansi }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $subdomain->nama_subdomain }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                @if ($subdomain->status == 'terbuka')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700 whitespace-nowrap">
                                        Pengajuan
                                    </span>
                                @elseif ($subdomain->status == 'baru')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700 whitespace-nowrap">
                                        Pemeriksaan Dokumen
                                    </span>
                                @elseif ($subdomain->status == 'tunda')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700 whitespace-nowrap">
                                        Persetujuan Pimpinan
                                    </span>
                                @elseif ($subdomain->status == 'diproses')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700 whitespace-nowrap">
                                        Proses Pembuatan
                                    </span>
                                @elseif ($subdomain->status == 'selesai')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-700 whitespace-nowrap">
                                        Selesai
                                    </span>
                                @elseif ($subdomain->status == 'ditolak')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-700 whitespace-nowrap">
                                        Pengajuan Dicancel
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $subdomain->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.subdomain.show', $subdomain) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary text-white">

                                        <span class="material-symbols-outlined text-[18px]">
                                            visibility
                                        </span>

                                    </a>

                                    {{-- Persetujuan Pimpinan --}}
                                    <a href="{{ route('admin.approval-list') }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-500 text-white">

                                        <span class="material-symbols-outlined text-[18px]">
                                            approval
                                        </span>

                                    </a>

                                    <button
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-500 text-white">

                                        <span class="material-symbols-outlined text-[18px]">
                                            delete
                                        </span>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                Belum ada pengajuan subdomain.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-outline-variant">

            <div class="flex items-center justify-between">

                <div class="text-sm text-on-surface-variant">
                    Menampilkan
                    {{ $subdomains->firstItem() ?? 0 }}
                    -
                    {{ $subdomains->lastItem() ?? 0 }}
                    dari
                    {{ $subdomains->total() }}
                    data
                </div>

                {{ $subdomains->links() }}

            </div>

        </div>

    </div>

    </div>

    </div>


</x-admin-layout>
