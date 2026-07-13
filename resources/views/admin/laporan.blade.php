<x-admin-layout title="Laporan">

    {{-- Header --}}
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-headline-large font-bold text-on-surface">
                Laporan Pengajuan
            </h1>

            <p class="mt-2 text-on-surface-variant">
                Rekapitulasi seluruh layanan Diskominfo Kabupaten Murung Raya.
            </p>

        </div>

    </div>

    {{-- ================= CARD RINGKASAN ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

        {{-- Total Pengajuan --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Total Pengajuan
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-on-surface">
                        {{ number_format($totalPengajuan) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Seluruh layanan
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-blue-600 text-3xl">
                        description
                    </span>

                </div>

            </div>

        </div>

        {{-- Pengajuan Selesai --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Pengajuan Selesai
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-green-600">
                        {{ number_format($totalSelesai) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Status selesai
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-green-600 text-3xl">
                        task_alt
                    </span>

                </div>

            </div>

        </div>

        {{-- Sedang Diproses --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Sedang Diproses
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-amber-600">
                        {{ number_format($totalDiproses) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Menunggu penyelesaian
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-amber-600 text-3xl">
                        hourglass_top
                    </span>

                </div>

            </div>

        </div>

        {{-- Pengajuan Ditolak --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Pengajuan Ditolak
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-red-600">
                        {{ number_format($totalDitolak) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Status ditolak
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-red-600 text-3xl">
                        cancel
                    </span>

                </div>

            </div>

        </div>

    </div>
    {{-- ================= END CARD ================= --}}

    {{-- Filter --}}
    <div class="bg-surface rounded-xl border border-outline-variant mb-8">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-outline-variant">

            <h3 class="flex items-center gap-2 text-title-medium font-semibold">

                <span class="material-symbols-outlined text-primary">
                    filter_alt
                </span>

                Filter Laporan

            </h3>

        </div>

        <form method="GET" class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Tanggal Awal --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Tanggal Awal

                    </label>

                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                        class="w-full rounded-lg border border-outline-variant px-4 py-3">

                </div>

                {{-- Tanggal Akhir --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Tanggal Akhir

                    </label>

                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                        class="w-full rounded-lg border border-outline-variant px-4 py-3">

                </div>

                {{-- Jenis --}}
                <select name="jenis" class="w-full rounded-lg border border-outline-variant px-4 py-3">

                    <option value="" {{ request('jenis') == '' ? 'selected' : '' }}>
                        Semua
                    </option>

                    <option value="subdomain" {{ request('jenis') == 'subdomain' ? 'selected' : '' }}>
                        Subdomain
                    </option>

                    <option value="email_satker" {{ request('jenis') == 'email_satker' ? 'selected' : '' }}>
                        Email Satker
                    </option>

                    <option value="email_pribadi" {{ request('jenis') == 'email_pribadi' ? 'selected' : '' }}>
                        Email Pribadi
                    </option>

                </select>

            </div>

            <div class="flex flex-wrap justify-end gap-3 mt-8">

                {{-- Reset --}}
                <a href="{{ route('admin.laporan') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-outline-variant hover:bg-surface-container transition">

                    <span class="material-symbols-outlined">
                        restart_alt
                    </span>

                    Reset

                </a>

                {{-- Terapkan --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-primary text-on-primary hover:opacity-90 transition">

                    <span class="material-symbols-outlined">
                        filter_alt
                    </span>

                    Terapkan

                </button>

            </div>

        </form>

    </div>

    {{-- ================= TAB MENU ================= --}}
    <div x-data="{ tab: 'ringkasan' }">

        <div class="flex items-center justify-between border-b border-outline-variant">

            {{-- Tab --}}
            <div class="flex">

                <button @click="tab='ringkasan'"
                    :class="tab == 'ringkasan' ?
                        'bg-primary text-on-primary' :
                        'text-on-surface-variant hover:bg-surface-container'"
                    class="px-6 py-4 text-sm font-medium transition rounded-tl-xl">

                    Ringkasan

                </button>

                <button @click="tab='statistik'"
                    :class="tab == 'statistik' ?
                        'bg-primary text-on-primary' :
                        'text-on-surface-variant hover:bg-surface-container'"
                    class="px-6 py-4 text-sm font-medium transition">

                    Statistik

                </button>

            </div>

            {{-- Export --}}
            <div class="flex gap-3 pr-5">

                <a href="{{ route('admin.laporan.export.pdf', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">

                    <span class="material-symbols-outlined">
                        picture_as_pdf
                    </span>

                    PDF Laporan

                </a>

                <a href="{{ route('admin.laporan.export.excel', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">

                    <span class="material-symbols-outlined">
                        table_view
                    </span>

                    Excel Laporan

                </a>

            </div>

        </div>

        <div x-show="tab=='ringkasan'">

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                {{-- Rekap Jenis --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6">

                    <h3 class="text-title-large font-semibold mb-6">
                        Rekap Jenis Layanan
                    </h3>

                    @foreach ($rekapJenis as $nama => $jumlah)
                        @php
                            $persen = $totalJenis > 0 ? ($jumlah / $totalJenis) * 100 : 0;
                        @endphp

                        <div class="mb-5">

                            <div class="flex justify-between mb-2">

                                <span class="capitalize">

                                    {{ str_replace('_', ' ', $nama) }}

                                </span>

                                <strong>{{ $jumlah }}</strong>

                            </div>

                            <div class="w-full h-3 rounded-full bg-surface-container">

                                <div class="h-3 rounded-full bg-primary" style="width: {{ $persen }}%">

                                </div>

                            </div>

                        </div>
                    @endforeach

                    <hr class="my-5">

                    <div class="flex justify-between font-bold">

                        <span>Total</span>

                        <span>{{ $totalJenis }}</span>

                    </div>

                </div>

                {{-- Rekap Status --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-6">

                    <h3 class="text-title-large font-semibold mb-6">

                        Rekap Status Pengajuan

                    </h3>

                    @foreach ($rekapStatus as $nama => $jumlah)
                        @php
                            $persen = $totalStatus > 0 ? ($jumlah / $totalStatus) * 100 : 0;
                        @endphp

                        <div class="mb-5">

                            <div class="flex justify-between mb-2">

                                <span>

                                    @php
                                        $namaStatus = [
                                            'terbuka' => 'Pengajuan',
                                            'baru' => 'Pemeriksaan Dokumen',
                                            'tunda' => 'Persetujuan Pimpinan',
                                            'diproses' => 'Proses Pembuatan',
                                            'selesai' => 'Selesai',
                                            'tutup' => 'Ditolak',
                                        ];
                                    @endphp

                                    <span>

                                        {{ $namaStatus[$nama] }}

                                    </span>

                                </span>

                                <strong>{{ $jumlah }}</strong>

                            </div>

                            <div class="w-full h-3 rounded-full bg-surface-container">

                                @php
                                    $warnaStatus = [
                                        'terbuka' => 'bg-blue-500',
                                        'baru' => 'bg-cyan-500',
                                        'diproses' => 'bg-amber-500',
                                        'tunda' => 'bg-orange-500',
                                        'selesai' => 'bg-green-600',
                                        'tutup' => 'bg-red-600',
                                    ];
                                @endphp

                                <div class="h-3 rounded-full {{ $warnaStatus[$nama] }}"
                                    style="width: {{ $persen }}%">
                                </div>

                            </div>

                        </div>
                    @endforeach

                    <hr class="my-5">

                    <div class="flex justify-between font-bold">

                        <span>Total</span>

                        <span>{{ $totalStatus }}</span>

                    </div>

                </div>

            </div>

        </div>

        <div x-show="tab=='statistik'">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Jenis --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-5">

                    <h3 class="font-semibold mb-4">
                        Pengajuan per Layanan
                    </h3>

                    <div class="h-64">
                        <canvas id="chartJenis"></canvas>
                    </div>

                </div>

                {{-- Status --}}
                <div class="bg-surface rounded-xl border border-outline-variant p-5">

                    <h3 class="font-semibold mb-4">
                        Status Pengajuan
                    </h3>

                    <div class="h-64">
                        <canvas id="chartStatus"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div> {{-- End x-data --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // ============================
        // CHART JENIS LAYANAN
        // ============================
        new Chart(document.getElementById('chartJenis'), {

            type: 'doughnut',

            data: {
                labels: @json(array_keys($chartJenis)),
                datasets: [{
                    data: @json(array_values($chartJenis)),
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 14,
                            padding: 15
                        }
                    }
                }
            }

        });


        // ============================
        // CHART STATUS
        // ============================
        new Chart(document.getElementById('chartStatus'), {

            type: 'bar',

            data: {
                labels: @json(array_keys($chartStatus)),
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: @json(array_values($chartStatus)),
                    borderRadius: 8
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {

                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }

                }

            }

        });
    </script>

</x-admin-layout>
