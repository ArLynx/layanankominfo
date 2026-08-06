<x-public-layout>
    <section class="flex flex-col justify-center w-full" style="min-height: calc(100vh - 64px);">

        <!-- DESKTOP VIEW -->
        <div class="hidden md:block max-w-xl mx-auto px-6 text-center py-24">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-600" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M20.52 3.48A11.86 11.86 0 0 0 12.04 0C5.4 0 .01 5.39.01 12.04c0 2.12.56 4.19 1.62 6.02L0 24l6.11-1.6a11.95 11.95 0 0 0 5.93 1.52h.01c6.64 0 12.03-5.39 12.03-12.04 0-3.21-1.25-6.22-3.56-8.4ZM12.05 21.9a9.92 9.92 0 0 1-5.05-1.38l-.36-.21-3.63.95.97-3.54-.24-.37A9.88 9.88 0 0 1 2.04 12C2.04 6.5 6.53 2.01 12.04 2.01c2.66 0 5.16 1.03 7.04 2.91A9.9 9.9 0 0 1 22 12c0 5.5-4.47 9.9-9.95 9.9Zm5.43-7.44c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.47-2.4-1.5-.89-.79-1.49-1.77-1.67-2.07-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.08-.79.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.06 2.88 1.21 3.08.15.2 2.09 3.18 5.07 4.46.71.31 1.27.49 1.7.63.72.23 1.38.2 1.9.12.58-.09 1.77-.72 2.02-1.42.25-.69.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z" />
                </svg>
            </div>

            <h2 class="mt-8 text-2xl font-bold text-primary">
                Hubungi Admin
            </h2>

            <p class="mt-3 text-gray-600">
                Apabila mengalami kendala saat menggunakan layanan, klik tombol di bawah untuk menghubungi admin melalui
                WhatsApp.
            </p>

            <a href="https://wa.me/6281255606609" target="_blank"
                class="mt-8 inline-flex items-center justify-center gap-2
               rounded-lg border border-green-700
               bg-green-600 px-6 py-3
               text-label-md font-label-md text-white
               shadow-sm transition-all
               hover:bg-green-700 hover:border-green-800">

                <span class="material-symbols-outlined text-[20px]">
                    forum
                </span>

                <span>Chat via WhatsApp</span>
            </a>

            <div class="mt-8 text-sm text-gray-500 space-y-1">
                <p>Jam layanan:</p>
                <p>Senin – Jumat</p>
                <p>07.30 – 15.30 WIB</p>
            </div>
        </div>

        <!-- MOBILE VIEW -->
        <div class="md:hidden flex flex-col items-center text-center px-6 py-12 max-w-sm mx-auto w-full">

            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-600" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M20.52 3.48A11.86 11.86 0 0 0 12.04 0C5.4 0 .01 5.39.01 12.04c0 2.12.56 4.19 1.62 6.02L0 24l6.11-1.6a11.95 11.95 0 0 0 5.93 1.52h.01c6.64 0 12.03-5.39 12.03-12.04 0-3.21-1.25-6.22-3.56-8.4ZM12.05 21.9a9.92 9.92 0 0 1-5.05-1.38l-.36-.21-3.63.95.97-3.54-.24-.37A9.88 9.88 0 0 1 2.04 12C2.04 6.5 6.53 2.01 12.04 2.01c2.66 0 5.16 1.03 7.04 2.91A9.9 9.9 0 0 1 22 12c0 5.5-4.47 9.9-9.95 9.9Zm5.43-7.44c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.47-2.4-1.5-.89-.79-1.49-1.77-1.67-2.07-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.08-.79.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.06 2.88 1.21 3.08.15.2 2.09 3.18 5.07 4.46.71.31 1.27.49 1.7.63.72.23 1.38.2 1.9.12.58-.09 1.77-.72 2.02-1.42.25-.69.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z" />
                </svg>
            </div>

            <h2 class="mt-6 font-headline-lg text-[32px] leading-[40px] font-bold text-primary px-2">
                Hubungi Admin
            </h2>

            <p class="mt-2 font-body-md text-body-md text-on-surface-variant">
                Apabila mengalami kendala saat menggunakan layanan, klik tombol di bawah untuk menghubungi admin melalui
                WhatsApp.
            </p>

            <a href="https://wa.me/6281255606609" target="_blank"
                class="mt-10 flex w-full items-center justify-center gap-2
               rounded-xl border border-green-700
               bg-green-600 px-6 py-3 min-h-[48px]
               text-base font-medium text-white
               shadow-md active:scale-[0.98] transition-all">

                <span class="material-symbols-outlined text-[20px]">
                    forum
                </span>

                <span>Chat via WhatsApp</span>
            </a>

            <div class="mt-10 font-body-md text-body-md text-on-surface-variant">
                <div class="flex items-center gap-1 font-medium text-gray-600 mb-1">
                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                    <span>Jam Layanan:</span>
                </div>
                <p>Senin – Jumat</p>
                <p>07.30 – 15.30 WIB</p>
            </div>

        </div>
    </section>
</x-public-layout>
