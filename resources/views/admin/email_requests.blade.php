<x-admin-layout title="Manajemen Permohonan Email Resmi">
    <header class="mb-8">
        <div class="flex items-center text-label-sm font-label-sm text-on-surface-variant mb-2">
            <a class="hover:text-primary transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
            <span class="text-primary font-semibold">Email Resmi</span>
        </div>
        <h1 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-2">Manajemen Permohonan Email Resmi</h1>
        <p class="text-body-md font-body-md text-on-surface-variant max-w-3xl">Kelola permohonan pembuatan akun email resmi berdomain @murungrayakab.go.id untuk ASN dan pegawai di lingkungan Pemerintah Kabupaten Murung Raya.</p>
    </header>

    <!-- Summary Cards -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Total Permohonan</h3>
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">mail</span>
                </div>
            </div>
            <div class="text-headline-xl font-headline-xl text-primary">{{ $totalRequests }}</div>
            <div class="text-caption font-caption text-success-emerald mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                <span>Aktif dan terverifikasi</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-sm ring-1 ring-status-pending/20">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Menunggu Verifikasi</h3>
                <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center text-status-pending">
                    <span class="material-symbols-outlined">hourglass_empty</span>
                </div>
            </div>
            <div class="text-headline-xl font-headline-xl text-status-pending">{{ $pendingVerification }}</div>
            <div class="text-caption font-caption text-on-surface-variant mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">info</span>
                <span>Memerlukan otorisasi</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Akun Aktif</h3>
                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-success-emerald">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
            </div>
            <div class="text-headline-xl font-headline-xl text-primary">{{ $activeEmails }}</div>
            <div class="text-caption font-caption text-on-surface-variant mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">storage</span>
                <span>Terdistribusi di seluruh OPD</span>
            </div>
        </div>
    </section>

    <!-- Main Data Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Table Section -->
        <section class="xl:col-span-2 bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm overflow-hidden flex flex-col h-full">
            <div class="p-6 border-b border-border-subtle flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-gray">
                <h2 class="text-headline-md font-headline-md text-primary">Daftar Antrean Permohonan</h2>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                        <input class="w-full pl-10 pr-4 py-2 bg-surface border border-border-subtle rounded-lg text-body-md font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="Cari NIP atau Nama..." type="text">
                    </div>
                    <button class="p-2 border border-border-subtle rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors" title="Filter">
                        <span class="material-symbols-outlined">filter_list</span>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-border-subtle bg-surface-container-low/50">
                            <th class="p-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Pemohon</th>
                            <th class="p-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Jabatan & Instansi</th>
                            <th class="p-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Email Diinginkan</th>
                            <th class="p-4 text-label-sm font-label-sm text-on-surface-variant font-semibold">Status</th>
                            <th class="p-4 text-label-sm font-label-sm text-on-surface-variant font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        @forelse($applications as $app)
                            <tr class="hover:bg-surface-gray transition-colors">
                                 <td class="p-4">
                                     <div class="text-label-md font-label-md text-on-surface">{{ $app->details['nama'] ?? $app->user->name ?? 'Unknown' }}</div>
                                     <div class="text-caption font-caption text-on-surface-variant">NIP: {{ $app->details['nip'] ?? '-' }}</div>
                                 </td>
                                 <td class="p-4">
                                     <div class="text-body-md font-body-md text-on-surface">{{ $app->details['jabatan'] ?? '-' }}</div>
                                     <div class="text-caption font-caption text-on-surface-variant">{{ $app->details['instansi'] ?? '-' }}</div>
                                 </td>
                                 <td class="p-4 text-body-md font-body-md text-primary">{{ $app->details['nama_akun'] ?? '-' }}</td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-caption font-caption 
                                        {{ $app->status === 'pending' ? 'bg-secondary-fixed text-on-secondary-container border border-secondary-container' : '' }}
                                        {{ $app->status === 'approved' ? 'bg-surface-container-highest text-success-emerald border border-success-emerald/30' : '' }}
                                        {{ $app->status === 'rejected' ? 'bg-error-container text-error border border-error/20' : '' }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('admin.process', $app->id) }}" class="text-primary hover:text-on-primary-fixed-variant p-2 rounded-lg hover:bg-surface-container-high transition-colors">
                                        <span class="material-symbols-outlined">edit_document</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-on-surface-variant">Tidak ada permohonan email.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-border-subtle flex justify-between items-center text-caption font-caption text-on-surface-variant bg-surface-gray">
                <span>Menampilkan {{ $applications->firstItem() }} - {{ $applications->lastItem() }} dari {{ $applications->total() }} permohonan</span>
                <div class="flex gap-2">
                    {{ $applications->links() }}
                </div>
            </div>
        </section>

        <!-- Detail & Auth Section (Bento style) -->
        <section class="flex flex-col gap-6">
            <!-- Otorisasi Card -->
            <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-status-pending"></div>
                <h2 class="text-headline-md font-headline-md text-primary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-status-pending">verified_user</span>
                    Otorisasi Kepala Dinas
                </h2>
                
                @php
                    $featuredApp = $applications->where('status', 'pending')->first();
                @endphp

                @if($featuredApp)
                    <p class="text-body-md font-body-md text-on-surface-variant mb-6">Permohonan atas nama <strong>{{ $featuredApp->user->name }}</strong> memerlukan unggahan surat rekomendasi yang ditandatangani oleh Kepala Dinas terkait.</p>
                    <div class="border border-dashed border-outline-variant rounded-lg p-8 flex flex-col items-center justify-center text-center bg-surface hover:bg-surface-container-low transition-colors cursor-pointer mb-4">
                        <span class="material-symbols-outlined text-outline text-[32px] mb-2">upload_file</span>
                        <span class="text-label-md font-label-md text-primary">Unggah Surat Rekomendasi (PDF)</span>
                        <span class="text-caption font-caption text-on-surface-variant mt-1">Maks 2MB</span>
                    </div>
                    <div class="flex gap-3">
                        <button class="flex-1 bg-surface border border-outline-variant text-primary py-2 rounded-lg text-label-md font-label-md hover:bg-surface-container-low transition-colors">Tolak</button>
                        <button class="flex-1 bg-primary text-on-primary py-2 rounded-lg text-label-md font-label-md hover:bg-on-primary-fixed-variant transition-colors shadow-sm opacity-50 cursor-not-allowed" disabled="">Verifikasi</button>
                    </div>
                @else
                    <div class="py-8 text-center">
                        <span class="material-symbols-outlined text-outline text-4xl mb-2">check_circle</span>
                        <p class="text-body-md text-on-surface-variant">Tidak ada permohonan yang menunggu otorisasi saat ini.</p>
                    </div>
                @endif
            </div>

            <!-- Info Card -->
            <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm p-6">
                <h3 class="text-label-md font-label-md text-on-surface-variant mb-4 uppercase tracking-wider">Persyaratan Email Resmi</h3>
                <ul class="space-y-3 text-body-md font-body-md text-on-surface-variant">
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-success-emerald text-[20px] shrink-0">check_circle</span>
                        <span>Format email standar: nama.lengkap@murungrayakab.go.id</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-success-emerald text-[20px] shrink-0">check_circle</span>
                        <span>SK Pengangkatan / CPNS valid dilampirkan.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-status-pending text-[20px] shrink-0">pending</span>
                        <span>Surat tugas / Rekomendasi pimpinan unit kerja.</span>
                    </li>
                </ul>
            </div>
        </section>
    </div>
</x-admin-layout>
