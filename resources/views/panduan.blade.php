<x-public-layout>
    <section class="relative overflow-hidden border-b border-border-subtle">
        <div class="relative max-w-7xl mx-auto px-6 py-12 lg:py-24">

            <!-- MOBILE VIEW -->
            <div class="flex flex-col items-center text-center md:hidden z-10">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full border border-border-subtle">
                    <span class="material-symbols-outlined text-base">menu_book</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Dokumentasi Portal Layanan</span>
                </span>

                <h1 class="mt-6 font-headline-lg text-[32px] leading-[40px] font-bold text-primary px-2">
                    Panduan Portal Layanan
                </h1>

                <p class="mt-4 text-base leading-relaxed text-on-surface-variant">
                    Pelajari seluruh proses penggunaan Portal Layanan Dinas Komunikasi dan Informatika Kabupaten Murung
                    Raya mulai dari registrasi akun, pengajuan layanan, upload dokumen hingga proses persetujuan.
                </p>

                <div class="mt-8 flex flex-col w-full gap-3">
                    <a href="https://youtu.be/pGum4S-NRlE?si=0uMVP_XMKv2DEPai" target="_blank" rel="noopener noreferrer"
                        class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all">
                        <span class="material-symbols-outlined text-[20px]">play_circle</span>
                        Tonton Video
                    </a>

                    <a href="https://drive.google.com/file/d/14VkHuQ7qrrc8_jBurRRoEDduvEq91COZ/view?usp=sharing"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                        Buka PDF
                    </a>
                </div>
            </div>

            <!-- DESKTOP VIEW -->
            <div class="hidden md:grid lg:grid-cols-2 gap-14 items-center">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high rounded-full border border-border-subtle">
                        <span class="material-symbols-outlined text-base">
                            menu_book
                        </span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Dokumentasi Portal
                            Layanan</span>
                    </span>

                    <h1 class="mt-6 font-headline-xl text-headline-xl text-primary">
                        Panduan Portal Layanan
                    </h1>

                    <p class="mt-6 text-lg leading-8 text-on-surface-variant max-w-xl">
                        Pelajari seluruh proses penggunaan Portal Layanan
                        Dinas Komunikasi dan Informatika Kabupaten Murung Raya
                        mulai dari registrasi akun, pengajuan layanan,
                        upload dokumen hingga proses persetujuan.
                    </p>

                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="https://youtu.be/pGum4S-NRlE?si=0uMVP_XMKv2DEPai" target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface text-primary border border-border-subtle font-label-md text-label-md shadow-sm transition-colors duration-200 hover:bg-primary hover:text-on-primary hover:border-primary">
                            <span class="material-symbols-outlined">
                                play_circle
                            </span>
                            Tonton Video
                        </a>

                        <a href="https://drive.google.com/file/d/14VkHuQ7qrrc8_jBurRRoEDduvEq91COZ/view?usp=sharing"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface text-primary border border-border-subtle font-label-md text-label-md shadow-sm transition-colors duration-200 hover:bg-primary hover:text-on-primary hover:border-primary">
                            <span class="material-symbols-outlined">
                                download
                            </span>
                            Buka PDF
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="video" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-4 mt-4">
                    Pelajari Melalui Video
                </h2>
                <p class="max-w-2xl mx-auto text-on-surface-variant">
                    Tonton video berikut agar memahami seluruh proses
                    penggunaan Portal Layanan dengan benar.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 mt-12 items-stretch">
                <div class="lg:col-span-2 h-full">
                    <div class="rounded-3xl overflow-hidden shadow-xl border bg-black h-full">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/pGum4S-NRlE"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <div class="h-full">
                    <div class="rounded-3xl bg-surface border shadow-sm p-8 h-full flex flex-col">
                        <h3 class="text-xl font-bold">
                            Materi Video
                        </h3>
                        <ul class="space-y-4 mt-6 flex-grow">
                            <li class="flex gap-3">
                                <span class="text-green-600 font-bold">✔</span>
                                Registrasi akun
                            </li>
                            <li class="flex gap-3">
                                <span class="text-green-600 font-bold">✔</span>
                                Login pengguna
                            </li>
                            <li class="flex gap-3">
                                <span class="text-green-600 font-bold">✔</span>
                                Pengajuan layanan
                            </li>
                            <li class="flex gap-3">
                                <span class="text-green-600 font-bold">✔</span>
                                Upload dokumen
                            </li>
                            <li class="flex gap-3">
                                <span class="text-green-600 font-bold">✔</span>
                                Monitoring status
                            </li>
                            <li class="flex gap-3">
                                <span class="text-green-600 font-bold">✔</span>
                                Download hasil
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
