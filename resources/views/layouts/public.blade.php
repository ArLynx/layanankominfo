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
        html {
            overflow-y: scroll;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col">

    <!-- ================= Responsiv Mobile ================= -->
    <header class="md:hidden fixed top-0 left-0 right-0 z-50 h-16 bg-white border-b border-slate-200 shadow-sm">

        <div class="w-full h-full px-5 flex items-center justify-between">

            <a href="{{ route('home') }}" class="flex items-center gap-3 flex-1 min-w-0">

                <img src="{{ asset('logo-layanan-192x192.png') }}" class="w-10 h-10 shrink-0" alt="Logo">

                <div class="min-w-0">
                    <h1 class="text-[18px] font-semibold text-slate-900 truncate leading-none">
                        Dinas Kominfo
                    </h1>
                    <p class="text-sm font-medium text-slate-600 leading-tight -mt-1">
                        Kabupaten Murung Raya
                    </p>
                </div>

            </a>

            <button id="mobileMenuButton"
                class="ml-3 w-12 h-12 shrink-0 rounded-lg flex items-center justify-center active:bg-slate-100 transition-colors duration-200">

                <span id="mobileMenuIcon" class="material-symbols-outlined text-[26px]">
                    menu
                </span>

            </button>

        </div>

    </header>

    <div id="mobileOverlay"
        class="md:hidden fixed inset-0 top-16 bg-black/30 opacity-0 invisible transition duration-200 z-30">
    </div>

    <div id="mobileMenu"
        class="md:hidden fixed left-0 right-0 bg-white border-b border-slate-200 shadow-lg
           opacity-0 invisible -translate-y-2 transition-all duration-200 z-40"
        style="top: 64px;">

        @php

            $mobileNav = '
            flex
            items-center
            gap-3
            px-6
            h-14
            text-[16px]
            font-medium
            text-slate-700
            active:bg-slate-100
            transition-colors
            duration-200';

            $mobileActive = '
            flex
            items-center
            gap-3
            px-6
            h-14
            text-[16px]
            font-semibold
            text-primary
            bg-slate-100';

        @endphp

        <nav>

            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $mobileActive : $mobileNav }}">
                <span class="material-symbols-outlined text-[20px] shrink-0">home</span>
                <span>Layanan</span>
            </a>

            <a href="{{ route('panduan') }}" class="{{ request()->routeIs('panduan') ? $mobileActive : $mobileNav }}">
                <span class="material-symbols-outlined text-[20px] shrink-0">menu_book</span>
                <span>Panduan</span>
            </a>

            <a href="{{ route('status') }}" class="{{ request()->routeIs('status') ? $mobileActive : $mobileNav }}">
                <span class="material-symbols-outlined text-[20px] shrink-0">monitoring</span>
                <span>Status</span>
            </a>

            <a href="{{ route('bantuan') }}" class="{{ request()->routeIs('bantuan') ? $mobileActive : $mobileNav }}">
                <span class="material-symbols-outlined text-[20px] shrink-0">help</span>
                <span>Bantuan</span>
            </a>

            <div class="px-6 pt-4 pb-4 space-y-3 border-t border-slate-200">

                @auth

                    <a href="{{ url('/dashboard-user') }}"
                        class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all mb-4">
                        Register
                    </a>

                @endauth

            </div>
        </nav>
    </div>

    <!-- Dekstop -->
    <header class="hidden md:block fixed top-0 z-50 w-full h-16 bg-surface border-b border-border-subtle">
        <div class="h-full flex justify-between items-center px-gutter max-w-container-max mx-auto">
            <div class="flex items-center gap-4 cursor-pointer">
                <img src="{{ asset('logo-layanan-192x192.png') }}" alt="Logo" width="40" height="40"
                    class="h-10 w-auto object-contain">
                <span class="text-headline-md font-bold text-primary">Dinas Kominfo Murung Raya</span>
            </div>

            @php
                $navDefault = 'relative px-2 py-2 text-sm font-semibold text-on-surface-variant 
                border-b-2 border-transparent 
                transition-all duration-200 
                hover:text-primary hover:border-primary';

                $navActive = 'relative px-2 py-2 text-sm font-bold text-primary 
                border-b-2 border-primary 
                transition-all duration-200';
            @endphp

            <!-- Menu Navigasi -->
            <nav class="hidden md:flex items-center gap-8">

                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $navActive : $navDefault }}">
                    Layanan
                </a>

                <a href="{{ route('panduan') }}"
                    class="{{ request()->routeIs('panduan') ? $navActive : $navDefault }}">
                    Panduan
                </a>

                <a href="{{ route('status') }}" class="{{ request()->routeIs('status') ? $navActive : $navDefault }}">
                    Status
                </a>

                <a href="{{ route('bantuan') }}"
                    class="{{ request()->routeIs('bantuan') ? $navActive : $navDefault }}">
                    Bantuan
                </a>

            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard-user') }}"
                        class="flex items-center gap-2
                            px-4 py-2
                            rounded-lg
                            text-primary
                            font-label-md text-label-md
                            transition-colors duration-200
                            hover:bg-primary
                            hover:text-on-primary">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2
                            rounded-lg
                            text-primary
                            font-label-md text-label-md
                            transition-colors duration-200
                            hover:bg-primary
                            hover:text-on-primary">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="px-4 py-2
                            rounded-lg
                            text-primary
                            font-label-md text-label-md
                            transition-colors duration-200
                            hover:bg-primary
                            hover:text-on-primary">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-16">
        {{ $slot }}

    </main>

    <!-- ================= Footer Dekstop ================= -->
    <footer class="hidden md:block w-full py-8 px-gutter border-t border-border-subtle bg-surface-container-lowest">
        <div class="flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto gap-4">
            <div class="text-center md:text-left">
                <span class="text-label-md font-bold text-primary">Dinas Komunikasi dan Informatika Kabupaten Murung
                    Raya</span>

                <p class="flex items-center gap-1.5 text-caption font-semibold text-on-surface-variant mt-1">
                    <span class="material-symbols-outlined text-[16px] text-primary shrink-0">verified_user</span>
                    <span>Seluruh Hak Cipta Dilindungi.</span>
                </p>

                <p class="flex items-center gap-1.5 text-caption font-semibold text-on-surface-variant mt-1">
                    <span
                        class="material-symbols-outlined text-[16px] font-medium text-primary shrink-0">copyright</span>
                    <span>Tim Pengembang Dinas Kominfo Kabupaten Murung Raya.</span>
                </p>
            </div>
            <nav class="flex flex-wrap justify-center gap-6">
            </nav>
        </div>
    </footer>

    <!-- ================= Footer Mobile ================= -->
    <footer class="md:hidden w-full py-5 px-6 border-t border-border-subtle bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto flex flex-col items-center text-center">

            <span class="text-label-md font-bold text-primary">
                Dinas Komunikasi dan Informatika Kabupaten Murung Raya
            </span>

            <p class="mt-1 flex items-center justify-center gap-1.5 text-caption font-semibold text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary shrink-0">verified_user</span>
                <span>Seluruh Hak Cipta Dilindungi.</span>
            </p>

            <p class="mt-1 flex items-center justify-center gap-1.5 text-caption font-semibold text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] font-medium text-primary shrink-0">copyright</span>
                <span>Tim Pengembang Dinas Kominfo Kabupaten Murung Raya.</span>
            </p>

        </div>
    </footer>

    @stack('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const menu = document.getElementById("mobileMenu");
            const overlay = document.getElementById("mobileOverlay");
            const button = document.getElementById("mobileMenuButton");
            const icon = document.getElementById("mobileMenuIcon");

            if (!menu || !overlay || !button || !icon) return;

            function openMenu() {

                menu.classList.remove("opacity-0", "invisible", "-translate-y-2");
                overlay.classList.remove("opacity-0", "invisible");

                document.body.classList.add("overflow-hidden");

                icon.textContent = "close";

                button.setAttribute("aria-expanded", "true");

            }

            function closeMenu() {

                menu.classList.add("opacity-0", "invisible", "-translate-y-2");
                overlay.classList.add("opacity-0", "invisible");

                document.body.classList.remove("overflow-hidden");

                icon.textContent = "menu";

                button.setAttribute("aria-expanded", "false");

            }

            button.addEventListener("click", () => {

                if (menu.classList.contains("invisible")) {
                    openMenu();
                } else {
                    closeMenu();
                }

            });

            overlay.addEventListener("click", closeMenu);

            document.addEventListener("keydown", (e) => {

                if (e.key === "Escape") {
                    closeMenu();
                }

            });

            menu.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", closeMenu);
            });

        });
    </script>
</body>

</html>
