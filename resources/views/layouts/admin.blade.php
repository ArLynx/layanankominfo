<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9ff;
            color: #0b1c30;
        }


    </style>
</head>

<body class="flex h-screen overflow-hidden antialiased font-body-md text-body-md">

    <!-- SideNavBar (Desktop) -->
    <nav
        class="fixed left-0 top-0 h-full w-[280px] bg-surface-container-low flex flex-col py-6 border-r border-border-subtle z-40 hidden md:flex">
        <div class="px-gutter mb-8 flex flex-col gap-2">
            <h1 class="text-headline-md font-headline-md text-primary">Admin Panel</h1>
            <p class="text-body-md font-body-md text-on-surface-variant">Dinas Kominfo</p>
        </div>

        <ul class="space-y-1">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg
            {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-on-primary translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high' }}
            transition-all">

                    <span class="material-symbols-outlined">
                        dashboard
                    </span>

                    <span class="text-label-md font-label-md">
                        Dashboard
                    </span>

                </a>
            </li>

            {{-- Profil --}}
            <li>
                <a href=""
                    class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg
            {{ request()->routeIs('profile') ? 'bg-primary text-on-primary translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high' }}
            transition-all">

                    <span class="material-symbols-outlined">
                        account_circle
                    </span>

                    <span class="text-label-md font-label-md">
                        Profil Saya
                    </span>

                </a>
            </li>

            @if (auth()->user()->role === 'superadmin')
                {{-- Manajemen User --}}
                <li>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg
            {{ request()->routeIs('admin.users*') ? 'bg-primary text-on-primary translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high' }}
            transition-all">

                        <span class="material-symbols-outlined">
                            manage_accounts
                        </span>

                        <span class="text-label-md font-label-md">
                            Manajemen User
                        </span>

                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'admin')
                {{-- Pengajuan --}}
                <li x-data="{
                    open: {{ request()->routeIs('admin.subdomain*') ||
                    request()->routeIs('admin.email-pribadi*') ||
                    request()->routeIs('admin.email-satker*')
                        ? 'true'
                        : 'false' }}
                }">

                    <button @click="open=!open"
                        class="w-full flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-all
            {{ request()->routeIs('admin.subdomain*') ||
            request()->routeIs('admin.email-pribadi*') ||
            request()->routeIs('admin.email-satker*')
                ? 'bg-primary text-on-primary'
                : 'text-on-surface-variant hover:bg-surface-container-high' }}">

                        <div class="flex items-center gap-3">

                            <span class="material-symbols-outlined">

                                assignment

                            </span>

                            <span class="text-label-md font-label-md">

                                Pengajuan

                            </span>

                        </div>

                        <span class="material-symbols-outlined transition-transform duration-300"
                            :class="{ 'rotate-180': open }">

                            expand_more

                        </span>

                    </button>

                    <div x-show="open" x-transition class="overflow-hidden">

                        <ul class="ml-8 mt-2 border-l border-outline-variant pl-4 space-y-1">

                            <li>

                                <a href="{{ route('admin.subdomain') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
                        {{ request()->routeIs('admin.subdomain*') ? 'bg-primary text-on-primary' : 'hover:bg-surface-container-high' }}">

                                    <span class="material-symbols-outlined text-[18px]">

                                        dns

                                    </span>

                                    <span>

                                        Subdomain

                                    </span>

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('admin.email-pribadi') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
                        {{ request()->routeIs('admin.email-pribadi*')
                            ? 'bg-primary text-on-primary'
                            : 'hover:bg-surface-container-high' }}">

                                    <span class="material-symbols-outlined text-[18px]">

                                        mail

                                    </span>

                                    <span>

                                        Email Pribadi

                                    </span>

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('admin.email-satker') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
                        {{ request()->routeIs('admin.email-satker*') ? 'bg-primary text-on-primary' : 'hover:bg-surface-container-high' }}">

                                    <span class="material-symbols-outlined text-[18px]">

                                        alternate_email

                                    </span>

                                    <span>

                                        Email Satker

                                    </span>

                                </a>

                            </li>

                        </ul>

                    </div>

                </li>

                {{-- Laporan --}}
                <li>

                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg
            {{ request()->routeIs('admin.laporan*') ? 'bg-primary text-on-primary translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high' }}
            transition-all">

                        <span class="material-symbols-outlined">

                            assessment

                        </span>

                        <span class="text-label-md font-label-md">

                            Laporan

                        </span>

                    </a>

                </li>
            @endif

            @if (auth()->user()->role === 'superadmin')
                {{-- Manajemen Admin --}}
                <li>
                    <a href="{{ route('admin.admins') }}"
                        class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg
            {{ request()->routeIs('admin.admins*') ? 'bg-primary text-on-primary translate-x-1' : 'text-on-surface-variant hover:bg-surface-container-high' }}
            transition-all">

                        <span class="material-symbols-outlined">
                            admin_panel_settings
                        </span>

                        <span class="text-label-md font-label-md">
                            Manajemen Admin
                        </span>

                    </a>
                </li>

                {{-- Log Aktivitas --}}
                <li>

                    <a href=""
                        class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg
        {{ request()->routeIs('admin.activity-logs*')
            ? 'bg-primary text-on-primary translate-x-1'
            : 'text-on-surface-variant hover:bg-surface-container-high' }}
        transition-all">

                        <span class="material-symbols-outlined">
                            history_toggle_off
                        </span>

                        <span class="text-label-md font-label-md">
                            Log Aktivitas
                        </span>

                    </a>

                </li>
            @endif

        </ul>

        <div class="mt-auto px-gutter pt-4 border-t border-border-subtle">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 py-2 text-error hover:text-on-error-container transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-label-md font-label-md">Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 md:ml-[280px] overflow-y-auto bg-surface-gray">
        <!-- Header -->
        <header
            class="bg-surface-container-lowest border-b border-border-subtle sticky top-0 z-30 px-gutter py-4 flex justify-between items-center">
            <h2 class="text-headline-md font-headline-md text-on-surface">{{ $title ?? 'Dashboard Admin' }}</h2>
            <div class="flex items-center gap-4">

                {{-- Mobile Menu --}}
                <button class="md:hidden text-on-surface" x-data x-on:click="$dispatch('toggle-admin-sidebar')">

                    <span class="material-symbols-outlined">

                        menu

                    </span>

                </button>

                {{-- Bell Notification --}}
                <div x-data="{ open: false }" class="relative">

                    <button @click="open = !open"
                        class="relative w-11 h-11 rounded-full hover:bg-surface-container flex items-center justify-center">

                        <span class="material-symbols-outlined text-[24px]">

                            notifications

                        </span>

                        @if ($unreadNotifications > 0)
                            <span
                                class="absolute -top-1 -right-1 min-w-[18px] h-[18px] rounded-full bg-red-600 text-white text-[10px] flex items-center justify-center">

                                {{ $unreadNotifications }}

                            </span>
                        @endif

                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute top-full right-0 mt-2 bg-white rounded-xl border border-outline-variant shadow-2xl z-[9999]"
                        style="width:420px;">

                        {{-- Header --}}
                        <div
                            class="flex gap-4 px-5 py-4 transition border-b border-outline-variant flex items-center justify-between">

                            <h3 class="font-semibold text-base flex items-center gap-2">

                                <span class="material-symbols-outlined text-primary">

                                    notifications

                                </span>

                                Notifikasi

                            </h3>

                            <a href="{{ route('admin.notifications.index') }}"
                                class="text-xs text-primary hover:underline">

                                Lihat Semua

                            </a>

                        </div>

                        <div class="divide-y divide-outline-variant max-h-[420px] overflow-y-auto">

                            @forelse($headerNotifications as $notification)
                                <a href="{{ route('admin.notifications.read', $notification->id) }}"
                                    class="flex gap-3 px-4 py-3 transition
                                    {{ !$notification->is_read
                                        ? 'bg-blue-50 border-l-4 border-blue-600 hover:bg-blue-100'
                                        : 'hover:bg-surface-container-low' }}">

                                    <div class="mt-1">

                                        @switch($notification->type)
                                            @case('subdomain')
                                                <span class="material-symbols-outlined text-blue-600">

                                                    language

                                                </span>
                                            @break

                                            @case('email_satker')
                                                <span class="material-symbols-outlined text-purple-600">

                                                    mail

                                                </span>
                                            @break

                                            @case('email_pribadi')
                                                <span class="material-symbols-outlined text-green-600">

                                                    person

                                                </span>
                                            @break
                                        @endswitch

                                    </div>

                                    <div class="flex-1">

                                        <p class="font-medium text-sm">

                                            {{ $notification->title }}

                                        </p>

                                        <p class="text-xs text-on-surface-variant">

                                            {{ $notification->message }}

                                        </p>

                                        <p class="text-[11px] text-on-surface-variant mt-1">

                                            {{ $notification->created_at->diffForHumans() }}

                                        </p>

                                    </div>

                                </a>

                                @empty

                                    <div class="px-4 py-8 text-center text-sm text-on-surface-variant">

                                        Belum ada notifikasi.

                                    </div>
                                @endforelse

                            </div>

                        </div>

                    </div>

                    {{-- Avatar --}}
                    <div
                        class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">

                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}

                    </div>

                </div>

            </header>

            <div class="p-gutter max-w-container-max mx-auto space-y-8">
                {{ $slot }}
            </div>
            <!-- Footer -->
            <footer
                class="w-full py-8 px-gutter border-t border-border-subtle flex flex-col md:flex-row justify-between items-center bg-surface-container-lowest mt-auto">
                <div class="text-label-md font-bold text-primary mb-4 md:mb-0">
                    © 2026 Dinas Kominfo Kabupaten Murung Raya. Transparansi &amp; Administrasi Efisien.
                </div>
            </footer>
        </main>


        @stack('modals')
        @livewireScripts


    </body>

    </html>
