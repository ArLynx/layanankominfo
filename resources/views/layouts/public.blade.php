<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Portal Layanan</title>

    <!-- Font & Icon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col">

    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 bg-surface/95 backdrop-blur-sm border-b border-border-subtle">
        <div class="flex justify-between items-center px-gutter py-4 max-w-container-max mx-auto">
            <div class="flex items-center gap-4">
                <span class="text-headline-md font-headline-md font-bold text-primary">Dinas Kominfo Murung Raya</span>
            </div>

            <!-- Menu Navigasi -->
            <nav class="hidden md:flex items-center gap-6">
                <a class="text-primary font-bold border-b-2 border-primary pb-1" href="{{ url('/') }}">Layanan</a>
                <button type="button"
                    class="text-on-surface-variant font-label-md hover:text-primary transition-colors duration-200 cursor-pointer"
                    onclick="openModal('modal-panduan')">Panduan</button>
                <button type="button"
                    class="text-on-surface-variant font-label-md hover:text-primary transition-colors duration-200 cursor-pointer"
                    onclick="openModal('modal-status')">Status</button>
                <button type="button"
                    class="text-on-surface-variant font-label-md hover:text-primary transition-colors duration-200 cursor-pointer"
                    onclick="openModal('modal-bantuan')">Bantuan</button>
            </nav>

            <!-- Tombol Auth (Login/Register atau Dashboard) -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- Jika user sudah login -->
                    <a href="{{ url('/dashboard') }}"
                        class="font-label-md text-label-md bg-primary text-on-primary px-4 py-2 rounded-lg hover:bg-primary-container transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        Dashboard
                    </a>
                @else
                    <!-- Jika user belum login -->
                    <a href="{{ route('login') }}"
                        class="font-label-md text-label-md text-primary hover:bg-surface-container-low px-4 py-2 rounded-lg transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="font-label-md text-label-md bg-primary text-on-primary px-4 py-2 rounded-lg hover:bg-primary-container transition-colors">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-[88px]">
        {{ $slot }}

    </main>

    <!-- Modals -->
    <x-modal-dialog id="modal-panduan" icon="menu_book" title="Panduan">
        <p>Fitur panduan penggunaan portal layanan masih dalam tahap pengembangan. Kami akan segera hadirkan petunjuk
            lengkap untuk memudahkan Anda dalam menggunakan setiap layanan.</p>
    </x-modal-dialog>

    <x-modal-dialog id="modal-status" icon="monitoring" title="Status Layanan">
        <p>Fitur status layanan masih dalam tahap pengembangan. Nantikan informasi real-time mengenai status pengajuan
            dan layanan Anda.</p>
    </x-modal-dialog>

    <x-modal-dialog id="modal-bantuan" icon="support" title="Bantuan">
        <p>Fitur bantuan masih dalam tahap pengembangan. Jika memerlukan bantuan, silakan hubungi tim support kami
            melalui kontak yang tersedia.</p>
    </x-modal-dialog>

    <!-- Footer -->
    <footer class="w-full py-8 px-gutter border-t border-border-subtle bg-surface-container-lowest">
        <div class="flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto gap-4">
            <div class="text-center md:text-left">
                <span class="text-label-md font-bold text-primary">Dinas Kominfo Murung Raya</span>
                <p class="text-caption font-caption text-on-surface-variant mt-1">
                    © {{ date('Y') }} Dinas Kominfo Kabupaten Murung Raya. Transparansi & Administrasi Efisien.
                </p>
            </div>
            <nav class="flex flex-wrap justify-center gap-6">
            </nav>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>