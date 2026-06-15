<x-public-layout>
    <!-- Hero Section -->
    <section class="relative px-gutter py-16 md:py-24 max-w-container-max mx-auto overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
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
                        <a href="{{ url('/dashboard') }}"
                            class="bg-primary text-on-primary font-label-md text-label-md px-6 py-3 rounded-lg shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
                            Buka Dashboard
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="bg-primary text-on-primary font-label-md text-label-md px-6 py-3 rounded-lg shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
                            Mulai Pengajuan
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a href="#"
                            class="bg-surface text-primary border border-border-subtle font-label-md text-label-md px-6 py-3 rounded-lg shadow-sm hover:bg-surface-container-low transition-all flex items-center gap-2">
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
        <!-- Decorative background elements -->
        <div
            class="absolute top-0 right-0 -mr-[20%] -mt-[10%] w-[60%] h-[80%] rounded-full bg-surface-container-low blur-3xl -z-10 opacity-70 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-[10%] -mb-[10%] w-[40%] h-[60%] rounded-full bg-primary-fixed/30 blur-3xl -z-10 opacity-50 pointer-events-none">
        </div>
    </section>

    <!-- Primary Services Bento Grid -->
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

                <!-- Service Card 1: Subdomain -->
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
                    <div class="mt-auto pt-6 border-t border-border-subtle flex justify-between items-center">
                        <span
                            class="font-label-md text-label-md text-primary group-hover:text-primary-container transition-colors">Mulai
                            Pengajuan</span>
                        <span
                            class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </div>
                </div>

                <!-- Service Card 2: Email -->
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
                    <div class="mt-auto pt-6 border-t border-border-subtle flex justify-between items-center">
                        <span
                            class="font-label-md text-label-md text-primary group-hover:text-primary-container transition-colors">Mulai
                            Pengajuan</span>
                        <span
                            class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>