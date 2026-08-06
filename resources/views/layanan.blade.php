<x-public-layout>
    <!-- Hero Section -->
    <section class="relative w-full flex flex-col justify-center overflow-hidden" style="min-height: calc(100vh - 64px);">
        <div class="w-full px-gutter max-w-container-max mx-auto py-8">

            <!-- MOBILE VIEW -->
            <div class="flex flex-col items-center text-center gap-6 md:hidden z-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full border border-border-subtle">
                    <span class="material-symbols-outlined text-primary text-sm"
                        style="font-variation-settings: 'FILL' 1;">verified</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Portal Layanan Resmi</span>
                </div>

                <h1 class="font-headline-lg text-[32px] leading-[40px] font-bold text-primary px-2">
                    Transformasi Digital Pelayanan Publik Murung Raya
                </h1>

                <p class="font-body-md text-body-md text-on-surface-variant">
                    Akses cepat dan mudah untuk pengajuan layanan TIK Pemerintah Kabupaten Murung Raya. Mulai dari
                    pengajuan subdomain hingga email resmi instansi, semua dalam satu portal terpadu.
                </p>

                <div
                    class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-surface-container shadow-sm border border-border-subtle relative mt-2">
                    <img alt="Modern government office working environment" class="w-full h-full object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAHq0IiaeUcGDtU1j9JAsEioKhEtN6RV5eAHjh2bjYQJ_dZFf8F15_HXNfo2g1Sx1MN9pUblOeakmIYy52V_nXa_sG0Coyhuh6IX8ps-OnnFfEdTxQWQSnzVyJz5vUUCcmZjsWkgJpCaS-eXlzG9tPgxc86WUWUFpRLTrm1xIgmLdXAKZLGYuSHlHOetopQdYbFXobPr8t69muQ2ohIgNpNxf_Ek6yAW0xJ5wiFP8WdFSbZ0gUI3zea3cO5gpPvdp4BSlmNCslybC8">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/30 to-transparent"></div>
                </div>
                <div class="flex flex-col w-full gap-3 mt-6">
                    @auth
                        <a href="{{ url('/dashboard-user') }}"
                            class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all">
                            Buka Dashboard
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-all">
                            Mulai Pengajuan
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>

                        <a href="{{ route('panduan') }}"
                            class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium text-base shadow-md active:scale-[0.98] transition-alll">
                            Panduan Penggunaan
                            <span class="material-symbols-outlined text-[20px]">menu_book</span>
                        </a>
                    @endauth
                </div>
            </div>


            <!-- DESKTOP VIEW -->
            <div class="hidden md:grid grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                <div class="z-10 flex flex-col items-start gap-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high rounded-full border border-border-subtle">
                        <span class="material-symbols-outlined text-primary text-sm"
                            style="font-variation-settings: 'FILL' 1;">verified</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Portal Layanan Resmi</span>
                    </div>

                    <h1 class="font-headline-xl text-headline-xl md:text-[48px] md:leading-[56px] text-primary">
                        Transformasi Digital Pelayanan Publik Murung Raya
                    </h1>

                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-[540px]">
                        Akses cepat dan mudah untuk pengajuan layanan TIK Pemerintah Kabupaten Murung Raya. Mulai dari
                        pengajuan subdomain hingga email resmi instansi, semua dalam satu portal terpadu.
                    </p>

                    <div class="flex flex-wrap gap-4 mt-4">
                        @auth
                            <a href="{{ url('/dashboard-user') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface text-primary border border-border-subtle font-label-md text-label-md shadow-sm transition-colors duration-200 hover:bg-primary hover:text-on-primary hover:border-primary">
                                Buka Dashboard
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface text-primary border border-border-subtle font-label-md text-label-md shadow-sm transition-colors duration-200 hover:bg-primary hover:text-on-primary hover:border-primary">
                                Mulai Pengajuan
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>

                            <a href="{{ route('panduan') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface text-primary border border-border-subtle font-label-md text-label-md shadow-sm transition-colors duration-200 hover:bg-primary hover:text-on-primary hover:border-primary">
                                Panduan Penggunaan
                                <span class="material-symbols-outlined">menu_book</span>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="relative z-10 hidden md:block">
                    <div
                        class="aspect-[4/3] rounded-xl overflow-hidden bg-surface-container shadow-sm border border-border-subtle relative">
                        <img alt="Modern government office working environment" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAHq0IiaeUcGDtU1j9JAsEioKhEtN6RV5eAHjh2bjYQJ_dZFf8F15_HXNfo2g1Sx1MN9pUblOeakmIYy52V_nXa_sG0Coyhuh6IX8ps-OnnFfEdTxQWQSnzVyJz5vUUCcmZjsWkgJpCaS-eXlzG9tPgxc86WUWUFpRLTrm1xIgmLdXAKZLGYuSHlHOetopQdYbFXobPr8t69muQ2ohIgNpNxf_Ek6yAW0xJ5wiFP8WdFSbZ0gUI3zea3cO5gpPvdp4BSlmNCslybC8">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent"></div>
                    </div>
                </div>

            </div>
        </div>

        <div
            class="absolute top-0 right-0 -mr-[20%] -mt-[10%] w-[60%] h-[80%] rounded-full bg-surface-container-low blur-3xl -z-10 opacity-70 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-[10%] -mb-[10%] w-[40%] h-[60%] rounded-full bg-primary-fixed/30 blur-3xl -z-10 opacity-50 pointer-events-none">
        </div>
    </section>

    <section class="px-gutter py-16 bg-surface-gray border-t border-border-subtle">
        <div class="max-w-container-max mx-auto">
            <div class="text-center mb-12">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Layanan Utama Kami</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">
                    Pilih layanan yang Anda butuhkan. Kami menyediakan infrastruktur digital yang andal untuk mendukung
                    kinerja instansi Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div
                    class="group bg-surface rounded-xl border border-border-subtle p-8 hover:shadow-lg transition-all duration-300 relative overflow-hidden flex flex-col h-full cursor-pointer">
                    <div
                        class="w-16 h-16 bg-surface-container-low rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <span
                            class="material-symbols-outlined text-[32px] text-primary group-hover:text-on-primary transition-colors"
                            style="font-variation-settings: 'FILL' 1;">language</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Pengajuan Subdomain</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-8 flex-grow">
                        Fasilitas pembuatan alamat website resmi (subdomain) di bawah domain murungrayakab.go.id untuk
                        OPD, Kecamatan, Desa, dan unit kerja lainnya di lingkungan Pemerintah Kabupaten Murung Raya.
                    </p>
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-success-emerald text-sm">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant text-sm">Proses pengajuan
                                terintegrasi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-success-emerald text-sm">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant text-sm">Validasi dokumen
                                digital</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-success-emerald text-sm">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant text-sm">Tracking status
                                pengajuan real-time</span>
                        </div>
                    </div>
                </div>

                <div
                    class="group bg-surface rounded-xl border border-border-subtle p-8 hover:shadow-lg transition-all duration-300 relative overflow-hidden flex flex-col h-full cursor-pointer">
                    <div
                        class="w-16 h-16 bg-surface-container-low rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <span
                            class="material-symbols-outlined text-[32px] text-primary group-hover:text-on-primary transition-colors"
                            style="font-variation-settings: 'FILL' 1;">mail</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Pengajuan Email Resmi</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-8 flex-grow">
                        Layanan pembuatan akun email resmi berakhiran @murungrayakab.go.id untuk ASN dan Perangkat
                        Daerah guna mendukung komunikasi kedinasan yang aman dan profesional.
                    </p>
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-success-emerald text-sm">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant text-sm">Keamanan data
                                terjamin</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-success-emerald text-sm">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant text-sm">Kapasitas
                                penyimpanan besar</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-success-emerald text-sm">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant text-sm">Dukungan teknis
                                responsif</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-public-layout>
