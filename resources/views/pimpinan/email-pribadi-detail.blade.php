<x-pimpinan-layout title="Detail Pengajuan Email Pribadi">
    <header class="flex items-start md:items-center justify-between border-b border-border-subtle pb-6">
        <div>
            <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                Detail Pengajuan Email Pribadi
            </h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Informasi dan dokumen pengajuan email pribadi</p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8">
            <div class="bg-surface rounded-xl border border-border-subtle p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg">Dokumen Permohonan</h3>
                    @if ($emailPribadi->formulir_email)
                        <a href="{{ route('pimpinan.email-pribadi.formulir', $emailPribadi) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg">
                            <span class="material-symbols-outlined">open_in_new</span>
                            Buka Dokumen
                        </a>
                    @endif
                </div>

                @if ($emailPribadi->formulir_email)
                    <div class="border rounded-lg overflow-hidden bg-gray-100">
                        <iframe src="{{ route('pimpinan.email-pribadi.formulir', $emailPribadi) }}" class="w-full h-[1200px]"></iframe>
                    </div>
                @else
                    <div class="border rounded-lg p-10 text-center bg-gray-50">
                        <span class="material-symbols-outlined text-5xl text-gray-400 mb-3">description</span>
                        <h4 class="font-medium text-gray-700">Belum Ada Dokumen</h4>
                        <p class="text-sm text-gray-500 mt-2">Pemohon belum mengunggah formulir email pribadi yang telah ditandatangani.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="bg-surface rounded-xl border border-border-subtle p-6">
                <h3 class="font-semibold text-lg mb-4">Informasi Pengajuan</h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Nomor Tiket</label>
                        <p class="font-medium">{{ $emailPribadi->nomor_tiket }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Pemohon</label>
                        <p class="font-medium">{{ $emailPribadi->nama }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Instansi</label>
                        <p class="font-medium">{{ $emailPribadi->nama_instansi }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Nama Akun</label>
                        <p class="font-medium">{{ $emailPribadi->nama_akun }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Catatan Admin</label>
                        <div class="font-medium">{{ $emailPribadi->catatan_admin ?: 'Tidak ada catatan dari admin.' }}</div>
                    </div>

                    @if($emailPribadi->catatan_pimpinan)
                        <div>
                            <label class="text-sm text-gray-500">Catatan Pimpinan</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm">{{ $emailPribadi->catatan_pimpinan }}</div>
                        </div>
                    @endif

                    <div>
                        <label class="text-sm text-gray-500">Status</label>
                        @php
                            $s = $emailPribadi->status;
                            $statusLabel = match($s) {
                                'terbuka' => ['Pengajuan', 'text-blue-600'],
                                'baru' => ['Pemeriksaan Dokumen', 'text-indigo-600'],
                                'tunda' => ['Menunggu Persetujuan', 'text-amber-600'],
                                'diproses' => ['Proses Pembuatan', 'text-indigo-600'],
                                'selesai' => ['Selesai', 'text-green-600'],
                                'tutup' => ['Pengajuan Ditolak', 'text-red-600'],
                                default => [$s, 'text-gray-600'],
                            };
                        @endphp
                        <p class="font-medium {{ $statusLabel[1] }}">{{ $statusLabel[0] }}</p>
                    </div>
                </div>

                <a href="{{ route('pimpinan.email-pribadi.list') }}"
                   class="block text-center w-full border border-gray-300 py-3 rounded-lg mt-6">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</x-pimpinan-layout>
