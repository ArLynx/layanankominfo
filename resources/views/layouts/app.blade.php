<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Fonts -->
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

<body class="bg-background text-on-background font-body-md text-body-md h-screen flex overflow-hidden">

    <!-- Mobile Top Navigation (Visible only on small screens) -->
    <header
        class="md:hidden fixed top-0 w-full z-50 bg-surface border-b border-border-subtle flex justify-between items-center px-margin-mobile py-4 shadow-sm">
        <div class="flex items-center gap-3">
            <button class="text-primary p-1" x-data x-on:click="$dispatch('toggle-sidebar')">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>
            <span class="text-headline-lg-mobile font-headline-lg-mobile text-primary">Dinas Kominfo</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-surface-container-high overflow-hidden border border-border-subtle">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=001e40&color=fff"
                alt="Avatar" class="w-full h-full object-cover">
        </div>
    </header>

    <!-- Sidebar Overlay (Mobile) -->
    <div x-data="{ open: false }" x-on:toggle-sidebar.window="open = !open" class="md:hidden">
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-40" x-on:click="open = false"></div>

        <!-- SideNavBar -->
        <aside x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed left-0 top-0 h-full w-[280px] bg-surface-container-low flex flex-col py-6 z-50 shadow-xl">

            <!-- Header -->
            <div class="px-gutter mb-8 flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[20px]"
                        style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
                </div>
                <div>
                    <h1 class="text-headline-md font-headline-md text-primary truncate">Portal Pemohon</h1>
                    <p class="text-label-sm font-label-sm text-on-surface-variant truncate">Dinas Kominfo</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 flex flex-col gap-1 px-3">
                <a href="{{ route('dashboard-user') }}"
                    class="{{ request()->routeIs('dashboard-user') ? 'bg-primary text-on-primary shadow-sm translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary' }} mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-[20px]"
                        style="font-variation-settings: '{{ request()->routeIs('dashboard-user') ? '1' : '0' }}';">dashboard</span>
                    <span class="text-label-md font-label-md">Dashboard</span>
                </a>
                <a href="{{ route('requests.service') }}"
                    class="{{ request()->routeIs('requests.service') ? 'bg-primary text-on-primary shadow-sm translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary' }} mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-[20px]"
                        style="font-variation-settings: '{{ request()->routeIs('requests.service') ? '1' : '0' }}';">add_circle</span>
                    <span class="text-label-md font-label-md">Layanan Baru</span>
                </a>
                <a href="{{ route('requests.index') }}"
                    class="{{ request()->routeIs('requests.index') ? 'bg-primary text-on-primary shadow-sm translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary' }} mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-[20px]"
                        style="font-variation-settings: '{{ request()->routeIs('requests.index') ? '1' : '0' }}';">history</span>
                    <span class="text-label-md font-label-md">Riwayat</span>
                </a>
                <a href="#"
                    class="text-on-surface-variant hover:bg-surface-container-high hover:text-primary mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-[20px]">description</span>
                    <span class="text-label-md font-label-md">Dokumen</span>
                </a>
                <a href="{{ route('profile.show') }}"
                    class="text-on-surface-variant hover:bg-surface-container-high hover:text-primary mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                    <span class="text-label-md font-label-md">Profil Saya</span>
                </a>
                <a href="#"
                    class="text-on-surface-variant hover:bg-surface-container-high hover:text-primary mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-[20px]">settings</span>
                    <span class="text-label-md font-label-md">Pengaturan</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="px-5 mt-auto pt-4 border-t border-border-subtle flex flex-col gap-4">
                <button
                    class="w-full bg-primary text-on-primary text-label-md font-label-md py-3 rounded-lg shadow-sm hover:bg-primary-container transition-colors flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">edit_document</span>
                    Buat Laporan
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-on-surface-variant hover:bg-surface-container-high px-2 py-2 rounded-lg flex items-center gap-3 transition-all hover:text-error">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        <span class="text-label-md font-label-md">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>
    </div>

    <!-- SideNavBar (Desktop) -->
    <aside
        class="hidden md:flex bg-surface-container-low fixed left-0 top-0 h-full w-[280px] border-r border-border-subtle flex flex-col py-6 z-40 shadow-[4px_0_12px_rgba(0,30,64,0.02)]">
        <!-- Header -->
        <div class="px-gutter mb-8 flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]"
                    style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-headline-md font-headline-md text-primary truncate">Portal Pemohon</h1>
                <p class="text-label-sm font-label-sm text-on-surface-variant truncate">Dinas Kominfo</p>
                <a href="{{ route('profile.show') }}"
                    class="text-caption font-caption text-primary hover:underline mt-0.5 inline-block">Edit Profil</a>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 flex flex-col gap-1 px-3">
            <a href="{{ route('dashboard-user') }}"
                class="{{ request()->routeIs('dashboard-user') ? 'bg-primary text-on-primary shadow-sm translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary' }} mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                <span class="material-symbols-outlined text-[20px]"
                    style="font-variation-settings: '{{ request()->routeIs('dashboard-user') ? '1' : '0' }}';">dashboard</span>
                <span class="text-label-md font-label-md">Dashboard</span>
            </a>
            <a href="{{ route('requests.service') }}"
                class="{{ request()->routeIs('requests.service') ? 'bg-primary text-on-primary shadow-sm translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary' }} mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                <span class="material-symbols-outlined text-[20px]"
                    style="font-variation-settings: '{{ request()->routeIs('requests.service') ? '1' : '0' }}';">add_circle</span>
                <span class="text-label-md font-label-md">Layanan Baru</span>
            </a>
            <a href="{{ route('requests.index') }}"
                class="{{ request()->routeIs('requests.index') ? 'bg-primary text-on-primary shadow-sm translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-primary' }} mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                <span class="material-symbols-outlined text-[20px]"
                    style="font-variation-settings: '{{ request()->routeIs('requests.index') ? '1' : '0' }}';">history</span>
                <span class="text-label-md font-label-md">Riwayat</span>
            </a>
            <a href="#"
                class="text-on-surface-variant hover:bg-surface-container-high hover:text-primary mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                <span class="material-symbols-outlined text-[20px]">description</span>
                <span class="text-label-md font-label-md">Dokumen</span>
            </a>
            <a href="{{ route('profile.show') }}"
                class="text-on-surface-variant hover:bg-surface-container-high hover:text-primary mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                <span class="material-symbols-outlined text-[20px]">person</span>
                <span class="text-label-md font-label-md">Profil Saya</span>
            </a>
            <a href="#"
                class="text-on-surface-variant hover:bg-surface-container-high hover:text-primary mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span class="text-label-md font-label-md">Pengaturan</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="px-5 mt-auto pt-4 border-t border-border-subtle flex flex-col gap-4">
            <button
                class="w-full bg-primary text-on-primary text-label-md font-label-md py-3 rounded-lg shadow-sm hover:bg-primary-container transition-colors flex justify-center items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">edit_document</span>
                Buat Laporan
            </button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-on-surface-variant hover:bg-surface-container-high px-2 py-2 rounded-lg flex items-center gap-3 transition-all hover:text-error">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span class="text-label-md font-label-md">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 md:ml-[280px] h-full overflow-y-auto pt-[80px] md:pt-0 bg-surface-bright relative">
        <!-- Background Pattern -->
        <div
            class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-surface-container-highest/40 via-transparent to-transparent opacity-50">
        </div>

        <div class="p-margin-mobile md:p-margin-desktop max-w-container-max mx-auto relative z-10 flex flex-col gap-8">
            {{ $slot }}
        </div>
    </main>

    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>
</html>