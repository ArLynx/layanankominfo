<x-pimpinan-layout title="Persetujuan Email Satuan Kerja">
    <header class="flex items-start md:items-center justify-between border-b border-border-subtle pb-6">
        <div>
            <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                Persetujuan Email Satuan Kerja
            </h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Verifikasi dokumen pengajuan email satuan kerja</p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8">
            <div class="bg-surface rounded-xl border border-border-subtle p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg">Dokumen Permohonan</h3>
                    @if ($emailSatker->formulir_email)
                        <a href="{{ route('pimpinan.email-satker.formulir', $emailSatker) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg">
                            <span class="material-symbols-outlined">open_in_new</span>
                            Buka Dokumen
                        </a>
                    @endif
                </div>

                @if ($emailSatker->formulir_email)
                    <div class="border rounded-lg overflow-hidden bg-gray-100">
                        <iframe src="{{ route('pimpinan.email-satker.formulir', $emailSatker) }}" class="w-full h-[1200px]"></iframe>
                    </div>
                @else
                    <div class="border rounded-lg p-10 text-center bg-gray-50">
                        <span class="material-symbols-outlined text-5xl text-gray-400 mb-3">description</span>
                        <h4 class="font-medium text-gray-700">Belum Ada Dokumen</h4>
                        <p class="text-sm text-gray-500 mt-2">Pemohon belum mengunggah formulir email satuan kerja yang telah ditandatangani.</p>
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
                        <p class="font-medium">{{ $emailSatker->nomor_tiket }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Nama Akun Dinas</label>
                        <p class="font-medium">{{ $emailSatker->nama_akun_dinas }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Catatan Admin</label>
                        <div class="font-medium">{{ $emailSatker->catatan_admin ?: 'Tidak ada catatan dari admin.' }}</div>
                    </div>

                    @if($emailSatker->status === 'tunda')
                        <div>
                            <label class="text-sm text-gray-500">Catatan Pimpinan</label>
                            <textarea name="catatan_pimpinan" form="approval-form" rows="4"
                                      class="w-full border rounded-lg p-3 mt-1"
                                      placeholder="Masukkan catatan pimpinan...">{{ old('catatan_pimpinan', $emailSatker->catatan_pimpinan) }}</textarea>
                            @error('catatan_pimpinan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @elseif($emailSatker->catatan_pimpinan)
                        <div>
                            <label class="text-sm text-gray-500">Catatan Pimpinan</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm">{{ $emailSatker->catatan_pimpinan }}</div>
                        </div>
                    @endif

                    <div>
                        <label class="text-sm text-gray-500">Status</label>
                        @php
                            $s = $emailSatker->status;
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

                @if($emailSatker->status === 'tunda')
                    <hr class="my-6">

                    <form id="approval-form" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <button type="button" onclick="openApprovalModal('approve')"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium">
                                Setujui Pengajuan
                            </button>
                            <button type="button" onclick="openApprovalModal('reject')"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-medium">
                                Tolak Pengajuan
                            </button>
                        </div>
                    </form>

                    <div id="approvalModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
                            <div class="p-6">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-amber-500 text-4xl">warning</span>
                                    <div>
                                        <h3 id="approvalTitle" class="text-xl font-bold"></h3>
                                        <p id="approvalText" class="text-gray-600 mt-1"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t p-5 flex justify-end gap-3">
                                <button type="button" onclick="closeApprovalModal()" class="px-5 py-2 rounded-lg border">Batal</button>
                                <button type="button" id="confirmApproval" class="px-5 py-2 rounded-lg text-white">Ya</button>
                            </div>
                        </div>
                    </div>
                @endif

                <a href="{{ route('pimpinan.email-satker.approval-list') }}"
                   class="block text-center w-full border border-gray-300 py-3 rounded-lg mt-3">Kembali</a>
            </div>
        </div>
    </div>

    @if($emailSatker->status === 'tunda')
    <script>
        const form = document.getElementById('approval-form');
        const modal = document.getElementById('approvalModal');
        const title = document.getElementById('approvalTitle');
        const text = document.getElementById('approvalText');
        const confirmBtn = document.getElementById('confirmApproval');

        function openApprovalModal(action) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            if (action === 'approve') {
                title.innerHTML = 'Setujui Pengajuan';
                text.innerHTML = 'Apakah Anda yakin ingin menyetujui pengajuan ini?';
                confirmBtn.className = 'px-5 py-2 rounded-lg bg-green-600 text-white';
                confirmBtn.onclick = function() {
                    form.action = "{{ route('pimpinan.email-satker.approve', $emailSatker) }}";
                    form.submit();
                };
            } else {
                title.innerHTML = 'Tolak Pengajuan';
                text.innerHTML = 'Apakah Anda yakin ingin menolak pengajuan ini?';
                confirmBtn.className = 'px-5 py-2 rounded-lg bg-red-600 text-white';
                confirmBtn.onclick = function() {
                    form.action = "{{ route('pimpinan.email-satker.reject', $emailSatker) }}";
                    form.submit();
                };
            }
        }

        function closeApprovalModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
    @endif
</x-pimpinan-layout>
