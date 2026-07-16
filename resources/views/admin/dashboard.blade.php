<x-admin-layout title="Dashboard Admin">

    {{-- Header --}}
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-headline-large font-headline-large text-on-surface">

                    Dashboard Admin

                </h1>

                <p class="mt-2 text-on-surface-variant">

                    Selamat datang kembali,
                    <span class="font-semibold">{{ auth()->user()->name }}</span>.
                    Berikut ringkasan pelayanan hari ini.

                </p>

            </div>

            <div
                class="flex items-center gap-3 bg-surface-container-low rounded-xl border border-border-subtle px-5 py-4">

                <span class="material-symbols-outlined text-primary text-3xl">

                    calendar_month

                </span>

                <div>

                    <p class="text-xs text-on-surface-variant">

                        Hari Ini

                    </p>

                    <p class="font-semibold text-on-surface">

                        {{ now()->locale('id')->translatedFormat('l, d F Y') }}

                    </p>

                </div>

            </div>

        </div>

    </section>

    {{-- Statistik --}}
    <section class="grid gap-5 mb-8" style="grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));">

        {{-- Total Pengajuan --}}
        <div
            class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 flex justify-between items-center">

            <div>

                <p class="text-on-surface-variant text-sm">

                    Total Pengajuan

                </p>

                <h2 class="text-3xl font-bold text-primary mt-2">

                    {{ $totalPengajuan }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-full bg-blue-100 text-primary flex items-center justify-center">

                <span class="material-symbols-outlined text-3xl">

                    assignment

                </span>

            </div>

        </div>

        {{-- Hari Ini --}}
        <div
            class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 flex justify-between items-center">

            <div>

                <p class="text-on-surface-variant text-sm">

                    Pengajuan Hari Ini

                </p>

                <h2 class="text-3xl font-bold text-blue-600 mt-2">

                    {{ $totalHariIni }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">

                <span class="material-symbols-outlined text-3xl">

                    today

                </span>

            </div>

        </div>

        {{-- Diproses --}}
        <div
            class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 flex justify-between items-center">

            <div>

                <p class="text-on-surface-variant text-sm">

                    Sedang Diproses

                </p>

                <h2 class="text-3xl font-bold text-status-pending mt-2">

                    {{ $totalDiproses }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-full bg-amber-100 text-status-pending flex items-center justify-center">

                <span class="material-symbols-outlined text-3xl">

                    hourglass_top

                </span>

            </div>

        </div>

        {{-- Selesai --}}
        <div
            class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 flex justify-between items-center">

            <div>

                <p class="text-on-surface-variant text-sm">

                    Pengajuan Selesai

                </p>

                <h2 class="text-3xl font-bold text-success-emerald mt-2">

                    {{ $totalSelesai }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-full bg-emerald-100 text-success-emerald flex items-center justify-center">

                <span class="material-symbols-outlined text-3xl">

                    task_alt

                </span>

            </div>

        </div>

    </section>

    {{-- Statistik Chart --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Jenis Layanan --}}
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 min-h-[420px] flex flex-col">

            <div class="mb-6">

                <h2 class="text-title-large font-semibold">

                    Jenis Layanan

                </h2>

                <p class="text-sm text-on-surface-variant">

                    Distribusi pengajuan berdasarkan layanan.

                </p>

            </div>

            <div class="h-72">

                <canvas id="chartJenis"></canvas>

            </div>

        </div>

        {{-- Status Pengajuan --}}
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 min-h-[420px] flex flex-col">

            <div class="mb-6">

                <h2 class="text-title-large font-semibold">

                    Status Pengajuan

                </h2>

                <p class="text-sm text-on-surface-variant">

                    Distribusi status seluruh pengajuan.

                </p>

            </div>

            <div class="h-72">

                <canvas id="chartStatus"></canvas>

            </div>

        </div>

    </section>


    {{-- Pengajuan Terbaru --}}
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-border-subtle">

            <div>

                <h2 class="text-title-large font-semibold">

                    Pengajuan Terbaru

                </h2>

                <p class="text-sm text-on-surface-variant">

                    Menampilkan 5 pengajuan terbaru dari seluruh layanan.

                </p>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b border-border-subtle bg-surface-container-low">

                        <th class="px-6 py-3 text-left">Nomor Tiket</th>

                        <th class="px-6 py-3 text-left">Jenis</th>

                        <th class="px-6 py-3 text-left">Pemohon</th>

                        <th class="px-6 py-3 text-center">Status</th>

                        <th class="px-6 py-3 text-center">Tanggal</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pengajuanTerbaru as $item)
                        <tr class="border-b border-border-subtle hover:bg-surface-container-low transition">

                            <td class="px-6 py-4">

                                {{ $item['nomor_tiket'] }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $item['jenis'] }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $item['pemohon'] }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                @php
                                    $status = match ($item['status']) {
                                        'terbuka' => ['Pengajuan', 'bg-blue-100 text-blue-700'],
                                        'baru' => ['Pemeriksaan Dokumen', 'bg-cyan-100 text-cyan-700'],
                                        'tunda' => ['Persetujuan Pimpinan', 'bg-yellow-100 text-yellow-700'],
                                        'diproses' => ['Proses Pembuatan', 'bg-orange-100 text-orange-700'],
                                        'selesai' => ['Selesai', 'bg-green-100 text-green-700'],
                                        'tutup' => ['Ditolak', 'bg-red-100 text-red-700'],
                                        default => ['-', 'bg-gray-100 text-gray-700'],
                                    };
                                @endphp

                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>

                            </td>

                            <td class="px-6 py-4 text-center">

                                {{ $item['tanggal']->format('d M Y') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="py-8 text-center text-on-surface-variant">

                                Belum ada pengajuan.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

    {{-- SOP Pelayanan --}}
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6">

        <div class="mb-8">

            <h2 class="text-title-large font-semibold">

                Standar Operasional Pelayanan

            </h2>

            <p class="text-sm text-on-surface-variant mt-1">

                Alur proses pelayanan administrasi Sistem Layanan Diskominfo Kabupaten Murung Raya.

            </p>

        </div>

        <div class="grid gap-6" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">

            {{-- Pemeriksaan --}}
            <div class="rounded-xl border border-border-subtle p-5 text-center bg-surface hover:shadow-md hover:-translate-y-1 transition-all duration-300">

                <div class="w-16 h-16 mx-auto rounded-full bg-blue-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-blue-700 text-3xl">

                        fact_check

                    </span>

                </div>

                <h3 class="font-semibold mt-4">

                    Pemeriksaan Dokumen

                </h3>

                <p class="text-sm text-on-surface-variant mt-2">

                    Admin melakukan pemeriksaan kelengkapan dan validasi dokumen pengajuan.

                </p>

            </div>

            {{-- Persetujuan --}}
            <div class="rounded-xl border border-border-subtle p-5 text-center bg-surface hover:shadow-md hover:-translate-y-1 transition-all duration-300">

                <div class="w-16 h-16 mx-auto rounded-full bg-yellow-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-yellow-700 text-3xl">

                        approval

                    </span>

                </div>

                <h3 class="font-semibold mt-4">

                    Persetujuan Pimpinan

                </h3>

                <p class="text-sm text-on-surface-variant mt-2">

                    Pengajuan yang memenuhi persyaratan diteruskan kepada pimpinan untuk mendapatkan persetujuan.

                </p>

            </div>

            {{-- Proses --}}
            <div class="rounded-xl border border-border-subtle p-5 text-center bg-surface hover:shadow-md hover:-translate-y-1 transition-all duration-300">

                <div class="w-16 h-16 mx-auto rounded-full bg-orange-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-orange-700 text-3xl">

                        settings

                    </span>

                </div>

                <h3 class="font-semibold mt-4">

                    Proses Pembuatan

                </h3>

                <p class="text-sm text-on-surface-variant mt-2">

                    Admin melakukan proses pembuatan layanan sesuai jenis pengajuan.

                </p>

            </div>

            {{-- Selesai --}}
            <div class="rounded-xl border border-border-subtle p-5 text-center bg-surface hover:shadow-md hover:-translate-y-1 transition-all duration-300">

                <div class="w-16 h-16 mx-auto rounded-full bg-green-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-green-700 text-3xl">

                        task_alt

                    </span>

                </div>

                <h3 class="font-semibold mt-4">

                    Pelayanan Selesai

                </h3>

                <p class="text-sm text-on-surface-variant mt-2">

                    Pemohon dapat melihat status selesai dan mengunduh dokumen apabila tersedia.

                </p>

            </div>

        </div>

    </section>

    {{-- Informasi Dashboard --}}
    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Informasi Dashboard --}}
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6">

            <div class="flex items-center gap-3 mb-5">

                <div class="w-12 h-12 rounded-xl bg-primary-container flex items-center justify-center">

                    <span class="material-symbols-outlined text-white">
                        info
                    </span>

                </div>

                <div>

                    <h2 class="text-title-large font-semibold">
                        Informasi Dashboard
                    </h2>

                    <p class="text-sm text-on-surface-variant">
                        Ringkasan informasi penggunaan dashboard.
                    </p>

                </div>

            </div>

            <div class="space-y-4">

                <div class="flex gap-3">

                    <span class="material-symbols-outlined text-primary mt-0.5">
                        dashboard
                    </span>

                    <p class="text-sm text-on-surface-variant">
                        Dashboard menampilkan ringkasan seluruh layanan yang sedang berjalan.
                    </p>

                </div>

                <div class="flex gap-3">

                    <span class="material-symbols-outlined text-green-600 mt-0.5">
                        sync
                    </span>

                    <p class="text-sm text-on-surface-variant">
                        Statistik diperbarui secara otomatis berdasarkan data pengajuan terbaru.
                    </p>

                </div>

                <div class="flex gap-3">

                    <span class="material-symbols-outlined text-amber-600 mt-0.5">
                        account_tree
                    </span>

                    <p class="text-sm text-on-surface-variant">
                        Status pengajuan mengikuti alur pelayanan yang berlaku pada setiap layanan.
                    </p>

                </div>

                <div class="flex gap-3">

                    <span class="material-symbols-outlined text-blue-600 mt-0.5">
                        open_in_new
                    </span>

                    <p class="text-sm text-on-surface-variant">
                        Detail setiap pengajuan dapat dilihat melalui menu <strong>Pengajuan</strong>.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartJenis = @json($chartJenis);
        const chartStatus = @json($chartStatus);

        // Pie Chart
        new Chart(document.getElementById('chartJenis'), {
            type: 'pie',
            data: {
                labels: Object.keys(chartJenis),
                datasets: [{
                    data: Object.values(chartJenis),
                    backgroundColor: [
                        '#2563EB',
                        '#10B981',
                        '#F59E0B'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bar Chart
        new Chart(document.getElementById('chartStatus'), {
            type: 'bar',
            data: {
                labels: Object.keys(chartStatus),
                datasets: [{
                    label: 'Jumlah',
                    data: Object.values(chartStatus),
                    backgroundColor: '#2563EB',
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
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-admin-layout>
