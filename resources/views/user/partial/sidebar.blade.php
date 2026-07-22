<!-- SideNavBar (Shared Component) - Hidden on Mobile, Fixed Left on Desktop -->
<aside
    class="bg-surface-container-low dark:bg-inverse-surface fixed left-0 top-0 h-full w-[280px] border-r border-border-subtle dark:border-outline-variant flex flex-col py-6 z-40 shadow-[4px_0_12px_rgba(0,30,64,0.02)]">
    <!-- Header -->
    <div class="px-gutter mb-8 flex items-center gap-3">
        <div
            class="w-10 h-10 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[20px]"
                style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
        </div>
        <div>
            <h1 class="text-headline-md font-headline-md text-primary dark:text-inverse-primary truncate">Portal
                Pemohon</h1>
            <p class="text-label-sm font-label-sm text-on-surface-variant truncate">Dinas Kominfo</p>
        </div>
    </div>
    <!-- Main Navigation Links -->
    <nav class="flex-1 flex flex-col gap-1 px-3">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard-user') }}"
            class="flex items-center gap-3 px-4 py-3 mx-2 my-1 rounded-lg transition-all
        {{ request()->routeIs('dashboard-user')
            ? 'bg-primary dark:bg-primary-container text-on-primary dark:text-on-primary-container translate-x-1 shadow-sm'
            : 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-highest dark:hover:bg-surface-variant hover:text-primary' }}">

            <span class="material-symbols-outlined text-[20px]"
                style="font-variation-settings: 'FILL' {{ request()->routeIs('dashboard-user') ? 1 : 0 }};">
                dashboard
            </span>

            <span class="text-label-md font-label-md">
                Dashboard
            </span>
        </a>

        {{-- Layanan Baru --}}
        <a href="{{ route('jenis-layanan') }}"
            class="flex items-center gap-3 px-4 py-3 mx-2 my-1 rounded-lg transition-all
        {{ request()->routeIs('jenis-layanan')
            ? 'bg-primary dark:bg-primary-container text-on-primary dark:text-on-primary-container translate-x-1 shadow-sm'
            : 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-highest dark:hover:bg-surface-variant hover:text-primary' }}">

            <span class="material-symbols-outlined text-[20px]"
                style="font-variation-settings: 'FILL' {{ request()->routeIs('jenis-layanan') ? 1 : 0 }};">
                add_circle
            </span>

            <span class="text-label-md font-label-md">
                Layanan Baru
            </span>
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('riwayat.index') }}"
            class="flex items-center gap-3 px-4 py-3 mx-2 my-1 rounded-lg transition-all
        {{ request()->routeIs('riwayat.*')
            ? 'bg-primary dark:bg-primary-container text-on-primary dark:text-on-primary-container translate-x-1 shadow-sm'
            : 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-highest dark:hover:bg-surface-variant hover:text-primary' }}">

            <span class="material-symbols-outlined text-[20px]"
                style="font-variation-settings: 'FILL' {{ request()->routeIs('riwayat.*') ? 1 : 0 }};">
                history
            </span>

            <span class="text-label-md font-label-md">
                Riwayat
            </span>
        </a>

        {{-- Profil --}}
        <a href="{{ route('profile.show') }}"
            class="flex items-center gap-3 px-4 py-3 mx-2 my-1 rounded-lg transition-all
        {{ request()->routeIs('profile.*')
            ? 'bg-primary dark:bg-primary-container text-on-primary dark:text-on-primary-container translate-x-1 shadow-sm'
            : 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-highest dark:hover:bg-surface-variant hover:text-primary' }}">

            <span class="material-symbols-outlined text-[20px]"
                style="font-variation-settings: 'FILL' {{ request()->routeIs('profile.*') ? 1 : 0 }};">
                person
            </span>

            <span class="text-label-md font-label-md">
                Profil Saya
            </span>
        </a>

    </nav>
    <!-- CTA & Footer Nav -->
    <div class="px-5 mt-auto pt-4 border-t border-border-subtle flex flex-col gap-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high px-2 py-2 rounded-lg flex items-center gap-3 transition-all hover:text-error w-full text-left">
                <span class="material-symbols-outlined text-[20px]">
                    logout
                </span>

                <span class="text-label-md font-label-md">
                    Keluar
                </span>
            </button>
        </form>
    </div>
</aside>
