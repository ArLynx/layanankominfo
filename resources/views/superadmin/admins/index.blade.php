<x-admin-layout title="Manajemen Admin">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-headline-large font-bold text-on-surface">Manajemen Admin</h1>
            <p class="mt-1 text-on-surface-variant">Kelola akun admin, superadmin, dan pimpinan</p>
        </div>
        <a href="{{ route('admin.admins.create') }}"
            class="bg-primary text-on-primary px-4 py-2 rounded-lg text-label-md font-label-md hover:bg-primary-container transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Admin
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800 text-body-md">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-body-md">
            {{ session('error') }}
        </div>
    @endif

    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-gray border-b border-border-subtle text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface divide-y divide-border-subtle">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-surface-gray transition-colors">
                            <td class="px-6 py-4 font-medium">{{ $admin->name }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $admin->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $admin->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $admin->role === 'admin' ? 'bg-primary-container text-on-primary-container' : '' }}
                                    {{ $admin->role === 'pimpinan' ? 'bg-amber-100 text-amber-800' : '' }}">
                                    {{ ucfirst($admin->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $admin->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-status-pending' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="text-secondary font-label-md text-label-md hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.admins.reset-password', $admin) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-amber-600 font-label-md text-label-md hover:underline">Reset Password</button>
                                </form>
                                @if($admin->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" class="inline" onsubmit="return confirm('Hapus admin {{ $admin->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-error font-label-md text-label-md hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-on-surface-variant">Belum ada admin</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-border-subtle bg-surface">
            {{ $admins->links() }}
        </div>
    </section>
</x-admin-layout>
