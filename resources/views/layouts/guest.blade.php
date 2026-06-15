<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="bg-background font-body-md text-on-surface min-h-screen flex antialiased">
    <main class="flex w-full h-screen overflow-hidden">

        <!-- Left Side: Visual/Branding (Hidden on mobile) -->
        <div class="hidden md:flex md:w-1/2 relative bg-primary-container overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAPEK9aPHo1MbYX6EXHoPI06-s6eiXRrpoDi1DitUy6gJxFcjmkI-RKAEbi3xg4jdIfz_Bh7YDrqFZYnTU8n1urKPyqHvSETYJMORGZwhXycJpewtOSn_pcb30G63q1u8OxPvmrMWgvJJYX5XZghzbcb7hjlSi8Lq77q8vH8rGKA1isC1GNo2kwt6DdoF-SV_Uyqe9fLINo8WiG6WtehYtIUKPoGjy2Q6NvXB0ObbpRbw3whTxsO2vOhZ2xxAkCsyPgjrQqqvsDdB4');">
            </div>
            <div class="absolute inset-0 bg-primary/70 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-primary via-transparent to-transparent opacity-90"></div>

            <div class="relative z-10 flex flex-col justify-end p-12 text-on-primary h-full w-full max-w-2xl">
                <div
                    class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface-container-lowest/10 backdrop-blur-md border border-white/20">
                    <span class="material-symbols-outlined text-4xl text-primary-fixed"
                        style="font-variation-settings: 'FILL' 1;">assured_workload</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-surface-container-lowest mb-4">Dinas Kominfo Murung
                    Raya</h1>
                <p class="font-body-lg text-body-lg text-primary-fixed opacity-90 max-w-lg">Portal terpadu untuk
                    transparansi dan administrasi yang efisien. Membangun pelayanan publik digital yang lebih baik dan
                    terpercaya.</p>
                <div
                    class="mt-12 flex items-center space-x-4 text-surface-container-highest font-label-sm text-label-sm">
                    <div class="flex items-center"><span
                            class="material-symbols-outlined mr-2 text-xl">verified_user</span> Sistem Aman</div>
                    <div class="w-1 h-1 rounded-full bg-surface-container-highest"></div>
                    <div class="flex items-center"><span class="material-symbols-outlined mr-2 text-xl">speed</span>
                        Akses Cepat</div>
                </div>
            </div>
        </div>

        <!-- Right Side: Authentication Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-gutter bg-surface overflow-y-auto">
            <div class="w-full max-w-[400px]">

                <!-- Mobile Branding Header -->
                <div class="md:hidden flex flex-col items-center mb-10 text-center">
                    <div
                        class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary-container text-on-primary-container">
                        <span class="material-symbols-outlined text-3xl"
                            style="font-variation-settings: 'FILL' 1;">assured_workload</span>
                    </div>
                    <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-primary">Dinas Kominfo</h1>
                    <p class="font-caption text-caption text-on-surface-variant mt-1">Kabupaten Murung Raya</p>
                </div>

                <div
                    class="bg-surface-container-lowest p-8 rounded-xl border border-border-subtle shadow-[0_4px_20px_rgba(0,30,64,0.03)]">

                    <!-- Tabs (Diubah menjadi Link Navigasi) -->
                    <div class="flex border-b border-border-subtle mb-8">
                        <a href="{{ route('login') }}"
                            class="flex-1 pb-3 text-center font-label-md text-label-md transition-all duration-200 focus:outline-none {{ request()->routeIs('login') ? 'text-primary border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary border-b-2 border-transparent' }}">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="flex-1 pb-3 text-center font-label-md text-label-md transition-all duration-200 focus:outline-none {{ request()->routeIs('register') ? 'text-primary border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary border-b-2 border-transparent' }}">
                            Daftar
                        </a>
                    </div>

                    <!-- Area Konten Form (Diisi oleh login.blade.php atau register.blade.php) -->
                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>

                </div>
            </div>
        </div>
    </main>

    @livewireScripts
</body>

</html>