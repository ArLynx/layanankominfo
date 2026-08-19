<x-public-layout>
    <!-- Header Section -->
    <section class="relative overflow-hidden border-b border-border-subtle">
        <div class="relative max-w-7xl mx-auto px-6 py-12 lg:py-24">

            <!-- MOBILE VIEW -->
            <div class="flex flex-col items-center text-center md:hidden z-10">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full border border-border-subtle">
                    <span class="material-symbols-outlined text-base">monitoring</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Status Pengajuan</span>
                </span>

                <h1 class="mt-6 font-headline-lg text-[32px] leading-[40px] font-bold text-primary px-2">
                    Cek Status Pengajuan Layanan
                </h1>

                <p class="mt-4 text-base leading-relaxed text-on-surface-variant">
                    Gunakan Nomor Tiket yang Anda terima setelah melakukan pengajuan layanan untuk melihat perkembangan
                    proses permohonan secara real-time.
                </p>
            </div>


            <!-- DESKTOP VIEW -->

            <div class="hidden md:block max-w-3xl">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high rounded-full border border-border-subtle">
                    <span class="material-symbols-outlined text-base">
                        monitoring
                    </span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Status Pengajuan</span>
                </span>

                <h1 class="mt-6 font-headline-xl text-headline-xl text-primary">
                    Cek Status Pengajuan Layanan
                </h1>

                <p class="mt-5 max-w-2xl text-body-lg text-on-surface-variant">
                    Gunakan Nomor Tiket yang Anda terima setelah melakukan
                    pengajuan layanan untuk melihat perkembangan proses
                    permohonan secara real-time.
                </p>
            </div>

        </div>
    </section>

    <section class="bg-surface py-12 md:py-16">
        <div class="max-w-3xl mx-auto px-gutter">

            <!-- MOBILE VIEW FORM -->
            <div class="md:hidden rounded-2xl border border-border-subtle bg-white shadow-sm p-6">
                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-3xl">
                            confirmation_number
                        </span>
                    </div>

                    <h2 class="mt-4 font-headline-md text-2xl font-bold text-primary">
                        Masukkan Nomor Tiket
                    </h2>

                    <p class="mt-2 text-sm text-on-surface-variant">
                        Contoh :
                        <span class="font-semibold text-primary">
                            TKT-2026-000123
                        </span>
                    </p>
                </div>

                <form action="{{ route('status.progres') }}" method="GET" class="mt-8">
                    <label class="block text-sm font-semibold mb-2">
                        Nomor Tiket
                    </label>

                    <input type="text" name="ticket" placeholder="Masukkan nomor tiket"
                        class="w-full rounded-xl border border-border-subtle px-4 py-3 min-h-[48px] text-base focus:border-primary focus:ring-primary">

                    <button
                        class="mt-5 w-full flex justify-center items-center rounded-xl bg-primary py-3 min-h-[48px] font-semibold text-white shadow-md active:scale-[0.98] transition-all">
                        Cek Status Pengajuan
                    </button>
                </form>
            </div>


            <!-- DESKTOP VIEW FORM -->
            <div class="hidden md:block rounded-3xl border border-border-subtle bg-white shadow-sm p-8">
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-4xl">
                            confirmation_number
                        </span>
                    </div>

                    <h2 class="font-headline-lg text-headline-lg text-primary">
                        Masukkan Nomor Tiket
                    </h2>

                    <p class="mt-3 text-on-surface-variant">
                        Contoh :
                        <span class="font-semibold">
                            TKT-2026-000123
                        </span>
                    </p>
                </div>

                <form action="{{ route('status.progres') }}" method="GET" class="mt-10">
                    <label class="block text-sm font-semibold mb-2">
                        Nomor Tiket
                    </label>

                    <input type="text" name="ticket" placeholder="Masukkan nomor tiket"
                        class="w-full rounded-xl border border-border-subtle px-5 py-4 focus:border-primary focus:ring-primary">

                    <button
                        class="mt-6 w-full rounded-xl bg-primary py-4 font-semibold text-white hover:opacity-90 transition">
                        Cek Status Pengajuan
                    </button>
                </form>
            </div>

        </div>
    </section>
</x-public-layout>
