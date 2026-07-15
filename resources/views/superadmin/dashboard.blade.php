<x-admin-layout title="Dashboard Superadmin">

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

        {{-- Total Akun --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Total Akun
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-on-surface">
                        {{ number_format($totalAkun) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Admin, Pimpinan dan User
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-blue-600 text-3xl">
                        groups
                    </span>

                </div>

            </div>

        </div>

        {{-- Admin --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Admin
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-indigo-600">
                        {{ number_format($totalAdmin) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Pengelola sistem
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-indigo-600 text-3xl">
                        admin_panel_settings
                    </span>

                </div>

            </div>

        </div>

        {{-- Pimpinan --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        Pimpinan
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-amber-600">
                        {{ number_format($totalPimpinan) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Persetujuan layanan
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-amber-600 text-3xl">
                        badge
                    </span>

                </div>

            </div>

        </div>

        {{-- User --}}
        <div class="bg-surface rounded-xl border border-outline-variant p-5 hover:shadow-lg transition-all">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-on-surface-variant">
                        User
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-green-600">
                        {{ number_format($totalUser) }}
                    </h2>

                    <p class="text-xs text-on-surface-variant mt-2">
                        Pengguna layanan
                    </p>

                </div>

                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">

                    <span class="material-symbols-outlined text-green-600 text-3xl">
                        person
                    </span>

                </div>

            </div>

        </div>

    </section>

    {{-- Statistik Akun --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Distribusi Role --}}
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 min-h-[420px] flex flex-col">

            <div class="mb-6">

                <h2 class="text-title-large font-semibold">

                    Distribusi Role

                </h2>

                <p class="text-sm text-on-surface-variant">

                    Perbandingan jumlah akun berdasarkan role.

                </p>

            </div>

            <div class="h-72">

                <canvas id="chartRole"></canvas>

            </div>

        </div>

        {{-- Status Akun --}}
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 min-h-[420px] flex flex-col">

            <div class="mb-6">

                <h2 class="text-title-large font-semibold">

                    Status Akun

                </h2>

                <p class="text-sm text-on-surface-variant">

                    Distribusi akun berdasarkan status aktif dan nonaktif.

                </p>

            </div>

            <div class="h-72">

                <canvas id="chartStatus"></canvas>

            </div>

        </div>

    </section>

    {{-- Admin & User Terbaru --}}
    <section class="grid gap-6 mb-8" style="grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));">

        {{-- Admin Terbaru --}}
        <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden">

            <div class="px-6 py-4 border-b border-outline-variant">

                <h2 class="text-title-large font-semibold">
                    Admin Terbaru
                </h2>

                <p class="text-sm text-on-surface-variant">
                    5 akun admin yang terakhir dibuat.
                </p>

            </div>

            <div class="divide-y divide-outline-variant">

                @forelse($adminTerbaru as $admin)
                    <div class="flex items-center justify-between px-6 py-4">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-11 h-11 rounded-full bg-primary-container text-white flex items-center justify-center">

                                <span class="material-symbols-outlined">

                                    person

                                </span>

                            </div>

                            <div>

                                <h4 class="font-semibold">

                                    {{ $admin->name }}

                                </h4>

                                <p class="text-sm text-on-surface-variant">

                                    {{ ucfirst($admin->role) }}

                                </p>

                            </div>

                        </div>

                        <div class="text-right">

                            <p class="text-xs text-on-surface-variant">

                                {{ $admin->created_at->translatedFormat('d M Y') }}

                            </p>

                        </div>

                    </div>

                @empty

                    <div class="py-8 text-center text-on-surface-variant">

                        Belum ada data admin.

                    </div>
                @endforelse

            </div>

            <div class="px-6 py-4 border-t border-outline-variant text-right">

                <a href="" class="text-primary font-medium hover:underline">

                    Lihat Manajemen Admin →

                </a>

            </div>

        </div>

        {{-- User Terbaru --}}
        <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden">

            <div class="px-6 py-4 border-b border-outline-variant">

                <h2 class="text-title-large font-semibold">
                    User Terbaru
                </h2>

                <p class="text-sm text-on-surface-variant">
                    5 akun pengguna yang terakhir mendaftar.
                </p>

            </div>

            <div class="divide-y divide-outline-variant">

                @forelse($userTerbaru as $user)
                    <div class="flex items-center justify-between px-6 py-4">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-11 h-11 rounded-full bg-green-100 text-green-600 flex items-center justify-center">

                                <span class="material-symbols-outlined">

                                    person

                                </span>

                            </div>

                            <div>

                                <h4 class="font-semibold">

                                    {{ $user->name }}

                                </h4>

                                <p class="text-sm text-on-surface-variant">

                                    Pengguna Layanan

                                </p>

                            </div>

                        </div>

                        <div class="text-right">

                            <p class="text-xs text-on-surface-variant">

                                {{ $user->created_at->translatedFormat('d M Y') }}

                            </p>

                        </div>

                    </div>

                @empty

                    <div class="py-8 text-center text-on-surface-variant">

                        Belum ada data user.

                    </div>
                @endforelse

            </div>

            <div class="px-6 py-4 border-t border-outline-variant text-right">

                <a href="" class="text-primary font-medium hover:underline">

                    Lihat Manajemen User →

                </a>

            </div>

        </div>

    </section>

    {{-- Standar Operasional Prosedur --}}
    <section class="bg-surface rounded-xl border border-outline-variant p-6">

        <div class="mb-6">

            <h2 class="text-title-large font-semibold flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">

                    policy

                </span>

                Standar Operasional Prosedur

            </h2>

            <p class="text-sm text-on-surface-variant mt-1">

                Pedoman bagi Superadmin dalam mengelola akun dan menjaga keamanan sistem.

            </p>

        </div>

        <div class="grid gap-5" style="grid-template-columns: repeat(auto-fit, minmax(250px,1fr));">

            {{-- Card 1 --}}
            <div
                class="bg-surface-container-low rounded-xl border border-outline-variant p-5 hover:shadow-md transition">

                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">

                    <span class="material-symbols-outlined text-blue-600">

                        manage_accounts

                    </span>

                </div>

                <h3 class="font-semibold text-on-surface mb-2">

                    Manajemen Akun

                </h3>

                <p class="text-sm text-on-surface-variant leading-relaxed">

                    Kelola akun Admin, Pimpinan, dan User sesuai hak akses.
                    Pastikan data akun selalu valid sebelum diberikan akses ke sistem.

                </p>

            </div>

            {{-- Card 2 --}}
            <div
                class="bg-surface-container-low rounded-xl border border-outline-variant p-5 hover:shadow-md transition">

                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-4">

                    <span class="material-symbols-outlined text-green-600">

                        shield_lock

                    </span>

                </div>

                <h3 class="font-semibold text-on-surface mb-2">

                    Keamanan Sistem

                </h3>

                <p class="text-sm text-on-surface-variant leading-relaxed">

                    Reset password hanya dilakukan atas permintaan resmi.
                    Hindari memberikan akses kepada pihak yang tidak berwenang.

                </p>

            </div>

            {{-- Card 3 --}}
            <div
                class="bg-surface-container-low rounded-xl border border-outline-variant p-5 hover:shadow-md transition">

                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4">

                    <span class="material-symbols-outlined text-amber-600">

                        history

                    </span>

                </div>

                <h3 class="font-semibold text-on-surface mb-2">

                    Audit Aktivitas

                </h3>

                <p class="text-sm text-on-surface-variant leading-relaxed">

                    Lakukan pemeriksaan Log Aktivitas secara berkala untuk
                    mendeteksi aktivitas yang tidak wajar pada sistem.

                </p>

            </div>

            {{-- Card 4 --}}
            <div
                class="bg-surface-container-low rounded-xl border border-outline-variant p-5 hover:shadow-md transition">

                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center mb-4">

                    <span class="material-symbols-outlined text-red-600">

                        person_off

                    </span>

                </div>

                <h3 class="font-semibold text-on-surface mb-2">

                    Status Akun

                </h3>

                <p class="text-sm text-on-surface-variant leading-relaxed">

                    Nonaktifkan akun yang sudah tidak digunakan agar keamanan
                    sistem tetap terjaga dan data tetap terkendali.

                </p>

            </div>

        </div>

    </section>

    {{-- Informasi Sistem --}}
    <section class="bg-surface rounded-xl border border-outline-variant p-6">

        <div class="mb-6">

            <h2 class="text-title-large font-semibold flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    info
                </span>

                Informasi Sistem

            </h2>

            <p class="text-sm text-on-surface-variant mt-1">

                Informasi umum mengenai aplikasi layanan Diskominfo Kabupaten Murung Raya.

            </p>

        </div>

        <div class="grid gap-5" style="grid-template-columns: repeat(auto-fit, minmax(250px,1fr));">

            {{-- Versi Sistem --}}
            <div class="bg-surface-container-low rounded-xl border border-outline-variant p-5">

                <div class="flex items-center gap-3 mb-3">

                    <span class="material-symbols-outlined text-primary">
                        deployed_code
                    </span>

                    <h3 class="font-semibold">
                        Versi Sistem
                    </h3>

                </div>

                <p class="text-on-surface-variant text-sm">

                    Sistem Layanan Diskominfo

                </p>

                <p class="font-semibold mt-2">

                    Version 1.0.0

                </p>

            </div>

            {{-- Framework --}}
            <div class="bg-surface-container-low rounded-xl border border-outline-variant p-5">

                <div class="flex items-center gap-3 mb-3">

                    <span class="material-symbols-outlined text-green-600">
                        code
                    </span>

                    <h3 class="font-semibold">
                        Framework
                    </h3>

                </div>

                <p class="text-on-surface-variant text-sm">

                    Laravel & PHP

                </p>

                <p class="font-semibold mt-2">

                    Laravel 13 • PHP 8.3

                </p>

            </div>

            {{-- Database --}}
            <div class="bg-surface-container-low rounded-xl border border-outline-variant p-5">

                <div class="flex items-center gap-3 mb-3">

                    <span class="material-symbols-outlined text-amber-600">
                        storage
                    </span>

                    <h3 class="font-semibold">
                        Database
                    </h3>

                </div>

                <p class="text-on-surface-variant text-sm">

                    Basis data aplikasi

                </p>

                <p class="font-semibold mt-2">

                    MySQL 8.4

                </p>

            </div>

            {{-- Status Sistem --}}
            <div class="bg-surface-container-low rounded-xl border border-outline-variant p-5">

                <div class="flex items-center gap-3 mb-3">

                    <span class="material-symbols-outlined text-green-600">
                        verified
                    </span>

                    <h3 class="font-semibold">
                        Status Sistem
                    </h3>

                </div>

                <p class="text-on-surface-variant text-sm">

                    Kondisi aplikasi

                </p>

                <span
                    class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-3 py-1 text-sm font-medium mt-2">

                    ● Sistem Berjalan Normal

                </span>

            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartRole = @json($chartRole);
        const chartStatus = @json($chartStatus);

        // Pie Chart
        new Chart(document.getElementById('chartRole'), {

            type: 'pie',

            data: {

                labels: Object.keys(chartRole),
                datasets: [{
                    data: Object.values(chartRole),
                    backgroundColor: [
                        '#2563EB',
                        '#F59E0B',
                        '#10B981'
                    ]

                }]

            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                responsive: true,
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
                    data: Object.values(chartStatus),
                    backgroundColor: [
                        '#10B981',
                        '#EF4444'
                    ],
                    borderRadius: 8

                }]

            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                responsive: true,
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
