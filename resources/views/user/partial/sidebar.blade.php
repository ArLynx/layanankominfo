<!-- SideNavBar (Shared Component) - Hidden on Mobile, Fixed Left on Desktop -->
<aside
    class="hidden md:flex bg-surface-container-low dark:bg-inverse-surface fixed left-0 top-0 h-full w-[280px] border-r border-border-subtle dark:border-outline-variant flex flex-col py-6 z-40 shadow-[4px_0_12px_rgba(0,30,64,0.02)]">
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
            <a class="text-caption font-caption text-primary hover:underline mt-0.5 inline-block" href="#">Edit
                Profil</a>
        </div>
    </div>
    <!-- Main Navigation Links -->
    <nav class="flex-1 flex flex-col gap-1 px-3">
        <!-- Active Item: Dashboard -->
        <a class="bg-primary dark:bg-primary-container text-on-primary dark:text-on-primary-container rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 hover:bg-surface-container-highest dark:hover:bg-surface-variant transition-all translate-x-1 shadow-sm"
            href="{{ route('dashboard-user') }}">
            <span class="material-symbols-outlined text-[20px]"
                style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="text-label-md font-label-md">Dashboard</span>
        </a>
        <!-- Inactive Items -->
        <a class="text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 hover:bg-surface-container-highest dark:hover:bg-surface-variant transition-all hover:text-primary"
            href="{{ route('jenis-layanan') }}">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            <span class="text-label-md font-label-md">Layanan Baru</span>
        </a>
        <a class="text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 hover:bg-surface-container-highest dark:hover:bg-surface-variant transition-all hover:text-primary"
            href="{{ route('riwayat.index') }}">
            <span class="material-symbols-outlined text-[20px]">history</span>
            <span class="text-label-md font-label-md">Riwayat</span>
        </a>
        <a class="text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 hover:bg-surface-container-highest dark:hover:bg-surface-variant transition-all hover:text-primary"
            href="{{ route('profile.show') }}">
            <span class="material-symbols-outlined text-[20px]">person</span>
            <span class="text-label-md font-label-md">Profil Saya</span>
        </a>
    </nav>
    <!-- CTA & Footer Nav -->
    <div class="px-5 mt-auto pt-4 border-t border-border-subtle flex flex-col gap-4"><button
            class="w-full bg-primary text-on-primary text-label-md font-label-md py-3 rounded-lg shadow-[0_4px_6px_rgba(0,51,102,0.1)] hover:bg-primary-container transition-colors flex justify-center items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">edit_document</span>
            Buat Laporan
        </button>
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