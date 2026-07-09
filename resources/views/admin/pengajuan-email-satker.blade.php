<x-admin-layout title="Pengajuan Email Satuan Kerja">

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
            <h2 class="text-headline-lg font-headline-lg text-on-surface">Pengajuan Email Satuan Kerja</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Daftar pengajuan layanan Email Satuan Kerja
                yang
                masuk</p>
        </div>
    </header>

    {{-- Filter --}}
    <div class="bg-surface rounded-xl border border-outline-variant p-4">

        <form class="flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[300px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tiket, nama pemohon, atau email satker..."
                    class="w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface">
            </div>

            <div>
                <select name="status"
                    class="px-4 py-3 rounded-lg border border-outline-variant bg-surface min-w-[180px]">
                    <option value="terbuka" {{ request('status') == 'terbuka' ? 'selected' : '' }}>
                        Pengajuan
                    </option>

                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>
                        Pemeriksaan Dokumen
                    </option>

                    <option value="tunda" {{ request('status') == 'tunda' ? 'selected' : '' }}>
                        Persetujuan Pimpinan
                    </option>

                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>
                        Proses Pembuatan
                    </option>

                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                    <option value="tutup" {{ request('status') == 'tutup' ? 'selected' : '' }}>
                        Pengajuan Dicancel
                    </option>
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
                        <th class="px-6 py-4 text-center font-semibold">
                            No
                        </th>
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
                            Jenis Layanan
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

                    @forelse ($emailSatkers as $emailSatker)
                        <tr class="border-t border-outline-variant">

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                {{ $emailSatkers->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $emailSatker->nomor_tiket }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $emailSatker->nama_penanggung_jawab }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $emailSatker->nama_instansi }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $emailSatker->nama_akun_dinas }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                @php
                                    $jenisLayanan = match ($emailSatker->jenis_layanan) {
                                        'baru' => 'Pengajuan Baru',
                                        'reset' => 'Reset Password',
                                        'reaktivasi' => 'Reaktivasi Akun',
                                        'ubah_akun' => 'Perubahan Nama Akun',
                                        'ubah_penanggung' => 'Perubahan Penanggung Jawab',
                                        default => '-',
                                    };
                                @endphp

                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-slate-100 text-slate-700">
                                    {{ $jenisLayanan }}
                                </span>

                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">

                                @if ($emailSatker->status == 'terbuka')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700 whitespace-nowrap">
                                        Pengajuan
                                    </span>
                                @elseif ($emailSatker->status == 'baru')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700 whitespace-nowrap">
                                        Pemeriksaan Dokumen
                                    </span>
                                @elseif ($emailSatker->status == 'tunda')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700 whitespace-nowrap">
                                        Persetujuan Pimpinan
                                    </span>
                                @elseif ($emailSatker->status == 'diproses')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700 whitespace-nowrap">
                                        Proses Pembuatan
                                    </span>
                                @elseif ($emailSatker->status == 'selesai')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-700 whitespace-nowrap">
                                        Selesai
                                    </span>
                                @elseif ($emailSatker->status == 'tutup')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-700 whitespace-nowrap">
                                        Pengajuan Dicancel
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $emailSatker->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.email-satker.show', $emailSatker) }}"
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

                                    {{-- <form id="delete-form" action="{{ route('admin.subdomain.destroy', $subdomain) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="openDeleteModal()"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-500 hover:bg-red-600 text-white transition">
                                            <span class="material-symbols-outlined text-[18px]">
                                                delete
                                            </span>
                                        </button>
                                    </form> --}}

                                    {{-- ========================================================= --}}
                                    {{-- MODAL KONFIRMASI --}}
                                    {{-- ========================================================= --}}

                                    {{-- <div id="deleteModal"
                                        class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
                                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
                                            <div class="p-6">
                                                <div class="flex items-start gap-4">
                                                    <span class="material-symbols-outlined text-red-500 text-5xl">
                                                        delete_forever
                                                    </span>
                                                    <div>
                                                        <h3 class="text-xl font-bold">
                                                            Hapus Pengajuan
                                                        </h3>
                                                        <p class="text-gray-600 mt-2">
                                                            Pengajuan yang telah dihapus tidak dapat dikembalikan lagi.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="mt-5 rounded-xl bg-red-50 border border-red-200 p-4">
                                                    <p class="text-sm text-red-700">
                                                        Anda yakin ingin menghapus pengajuan dengan nomor tiket
                                                        <strong>{{ $subdomain->nomor_tiket }}</strong>?
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="border-t px-6 py-4 flex justify-end gap-3">
                                                <button type="button" onclick="closeDeleteModal()"
                                                    class="px-5 py-2 rounded-lg border">

                                                    Batal
                                                </button>
                                                <button type="button" onclick="submitDelete()"
                                                    class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">
                                                    Ya, Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="py-16 text-center">
                                Belum ada pengajuan Email Satuan Kerja.
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
                    {{ $emailSatkers->firstItem() ?? 0 }}
                    -
                    {{ $emailSatkers->lastItem() ?? 0 }}
                    dari
                    {{ $emailSatkers->total() }}
                    data
                </div>

                {{ $emailSatkers->links() }}

            </div>

        </div>

    </div>

    </div>

    </div>

    <script>
        //delete
        // function openDeleteModal() {

        //     document.getElementById('deleteModal')
        //         .classList.remove('hidden');

        //     document.getElementById('deleteModal')
        //         .classList.add('flex');

        // }

        // function closeDeleteModal() {

        //     document.getElementById('deleteModal')
        //         .classList.remove('flex');

        //     document.getElementById('deleteModal')
        //         .classList.add('hidden');

        // }

        // function submitDelete() {

        //     document.getElementById('delete-form').submit();

        // }
    </script>

</x-admin-layout>
