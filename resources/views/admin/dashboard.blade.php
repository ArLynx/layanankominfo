<x-admin-layout title="Manajemen User Superadmin">
    <!-- Statistics Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-surface-container-lowest rounded-xl p-6 border border-border-subtle flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Total Pengguna</p>
                <p class="text-headline-lg font-headline-lg text-primary">{{ $totalUsers ?? '1,248' }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">group</span>
            </div>
        </div>
        <div
            class="bg-surface-container-lowest rounded-xl p-6 border border-border-subtle flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Admin Aktif</p>
                <p class="text-headline-lg font-headline-lg text-success-emerald">{{ $activeAdmins ?? '42' }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-success-emerald">
                <span class="material-symbols-outlined text-3xl">admin_panel_settings</span>
            </div>
        </div>
        <div
            class="bg-surface-container-lowest rounded-xl p-6 border border-border-subtle flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">User Biasa</p>
                <p class="text-headline-lg font-headline-lg text-surface-tint">{{ $regularUsers ?? '1,206' }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-surface-tint">
                <span class="material-symbols-outlined text-3xl">person</span>
            </div>
        </div>
    </section>

    <!-- User Management Table -->
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
        <div
            class="px-6 py-4 border-b border-border-subtle bg-surface flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="text-headline-md font-headline-md text-on-surface">Daftar Manajemen Pengguna</h3>
            <div class="flex gap-2 w-full md:w-auto">
                <input type="text" placeholder="Cari pengguna..."
                    class="flex-1 md:flex-none border border-border-subtle rounded-lg px-4 py-2 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                <button
                    class="bg-primary text-on-primary px-4 py-2 rounded-lg text-label-md font-label-md hover:bg-primary-container transition-colors whitespace-nowrap">Tambah
                    User</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-surface-gray border-b border-border-subtle text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Peran</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface divide-y divide-border-subtle">
                    @forelse($users ?? [] as $user)
                        <tr class="hover:bg-surface-gray transition-colors">
                            <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container text-surface-tint' }}">
                                    {{ ucfirst($user->role ?? 'user') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-status-pending' }}">
                                    {{ ucfirst($user->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button class="text-secondary font-label-md text-label-md hover:underline">Edit</button>
                                <button class="text-error font-label-md text-label-md hover:underline">Reset
                                    Password</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-on-surface-variant">Belum ada data pengguna
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div
            class="px-6 py-4 border-t border-border-subtle bg-surface flex flex-col md:flex-row justify-between items-center gap-4 text-body-md">
            <span class="text-on-surface-variant">Menampilkan {{ $users->firstItem() ?? 0 }} hingga
                {{ $users->lastItem() ?? 0 }} dari {{ $users->total() ?? 0 }} pengguna</span>
            @if(isset($users) && $users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $users->links() }}
            @else
                <div class="flex gap-1">
                    <button
                        class="px-3 py-1 border border-border-subtle rounded text-on-surface hover:bg-surface-container">Prev</button>
                    <button class="px-3 py-1 bg-primary text-on-primary rounded">1</button>
                    <button
                        class="px-3 py-1 border border-border-subtle rounded text-on-surface hover:bg-surface-container">2</button>
                    <button
                        class="px-3 py-1 border border-border-subtle rounded text-on-surface hover:bg-surface-container">Next</button>
                </div>
            @endif
        </div>
    </section>

    <!-- SOP Section -->
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6">
        <h3 class="text-headline-md font-headline-md text-on-surface mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">policy</span>
            Standar Operasional Prosedur (SOP) Superadmin
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-surface p-4 rounded-lg border border-border-subtle">
                <h4 class="text-label-md font-label-md text-on-surface mb-2 font-bold">1. Pengelolaan Akun Baru</h4>
                <p class="text-body-md text-on-surface-variant">Pastikan memverifikasi identitas pengguna sebelum
                    memberikan akses Admin. Akun User biasa dapat di-approve setelah email terverifikasi oleh sistem
                    otomatis.</p>
            </div>
            <div class="bg-surface p-4 rounded-lg border border-border-subtle">
                <h4 class="text-label-md font-label-md text-on-surface mb-2 font-bold">2. Keamanan Data (Reset Password)
                </h4>
                <p class="text-body-md text-on-surface-variant">Gunakan fitur 'Reset Password' hanya atas permintaan
                    resmi dari pengguna. Sistem akan mengirimkan link reset sekali pakai ke email terdaftar untuk
                    menghindari akses tidak sah.</p>
            </div>
            <div class="bg-surface p-4 rounded-lg border border-border-subtle">
                <h4 class="text-label-md font-label-md text-on-surface mb-2 font-bold">3. Audit Log Periodik</h4>
                <p class="text-body-md text-on-surface-variant">Lakukan pengecekan log aktivitas Admin setiap minggu.
                    Laporkan anomali akses ke Kepala Divisi IT untuk tindakan preventif lebih lanjut.</p>
            </div>
            <div class="bg-surface p-4 rounded-lg border border-border-subtle">
                <h4 class="text-label-md font-label-md text-on-surface mb-2 font-bold">4. Penonaktifan Akun</h4>
                <p class="text-body-md text-on-surface-variant">Akun pegawai yang mutasi atau resign harus segera diubah
                    statusnya menjadi 'Nonaktif' dalam waktu maksimal 1x24 jam kerja.</p>
            </div>
        </div>
    </section>
</x-admin-layout>