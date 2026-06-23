<x-admin-layout title="Persetujuan Pimpinan">

    <div class="max-w-7xl mx-auto space-y-6">

        <div class="bg-surface rounded-xl border border-outline-variant p-6">

            <h1 class="text-2xl font-bold">
                Persetujuan Pimpinan
            </h1>

            <p class="text-on-surface-variant mt-2">
                Verifikasi dokumen pengajuan subdomain.
            </p>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- Dokumen --}}
            <div class="lg:col-span-8">

                <div class="bg-surface rounded-xl border border-outline-variant p-6">

                    <div class="flex items-center justify-between mb-4">

                        <h3 class="font-semibold text-lg">
                            Dokumen Permohonan
                        </h3>

                        @if ($subdomain->formulir_subdomain)
                            <a href="{{ route('admin.subdomain.formulir', $subdomain) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg">

                                <span class="material-symbols-outlined">
                                    open_in_new
                                </span>

                                Buka Dokumen

                            </a>
                        @endif

                    </div>

                    @if ($subdomain->formulir_subdomain)
                        <div class="border rounded-lg overflow-hidden bg-gray-100">

                            <iframe src="{{ route('admin.subdomain.formulir', $subdomain) }}" class="w-full h-[1200px]">
                            </iframe>

                        </div>
                    @else
                        <div class="border rounded-lg p-10 text-center bg-gray-50">

                            <span class="material-symbols-outlined text-5xl text-gray-400 mb-3">
                                description
                            </span>

                            <h4 class="font-medium text-gray-700">
                                Belum Ada Dokumen
                            </h4>

                            <p class="text-sm text-gray-500 mt-2">
                                Pemohon belum mengunggah formulir subdomain yang telah ditandatangani.
                            </p>

                        </div>
                    @endif

                </div>

            </div>

            {{-- Persetujuan --}}
            <div class="lg:col-span-4">

                <div class="bg-surface rounded-xl border border-outline-variant p-6">

                    <h3 class="font-semibold text-lg mb-4">
                        Informasi Pengajuan
                    </h3>

                    <div class="space-y-4">

                        <div>
                            <label class="text-sm text-gray-500">
                                Nomor Tiket
                            </label>

                            <p class="font-medium">
                                {{ $subdomain->nomor_tiket }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">
                                Nama Subdomain
                            </label>

                            <p class="font-medium">
                                {{ $subdomain->nama_subdomain }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">
                                Catatan Admin
                            </label>

                            <div class="font-medium">
                                {{ $subdomain->catatan_admin ?: 'Tidak ada catatan dari admin.' }}
                            </div>
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">
                                Catatan Pimpinan
                            </label>

                            <textarea name="catatan_pimpinan" form="approval-form" rows="4" class="w-full border rounded-lg p-3 mt-1"
                                placeholder="Masukkan catatan pimpinan...">{{ old('catatan_pimpinan', $subdomain->catatan_pimpinan) }}</textarea>

                            @error('catatan_pimpinan')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">
                                Status
                            </label>

                            <p class="font-medium text-amber-600">
                                Menunggu Persetujuan
                            </p>
                        </div>

                    </div>

                    <hr class="my-6">

                    <form id="approval-form" method="POST">

                        @csrf

                        <div class="space-y-3">

                            <button type="submit" formaction="{{ route('admin.approve-subdomain', $subdomain) }}"
                                class="w-full bg-green-500 text-white py-3 rounded-lg font-medium">

                                Setujui Pengajuan

                            </button>

                            <button type="submit" formaction="{{ route('admin.reject-subdomain', $subdomain) }}"
                                class="w-full bg-red-500 text-white py-3 rounded-lg font-medium">

                                Tolak Pengajuan

                            </button>

                        </div>

                    </form>

                    <a href="{{ route('admin.subdomain') }}"
                        class="block text-center w-full border border-gray-300 py-3 rounded-lg">

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

    </div>

</x-admin-layout>
