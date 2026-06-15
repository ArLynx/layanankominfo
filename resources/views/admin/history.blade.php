<x-admin-layout title="Riwayat Permohonan">
    <div class="bg-surface border border-border-subtle rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border-subtle bg-surface-gray">
            <h3 class="text-headline-md font-headline-md text-on-surface">Riwayat Permohonan Terproses</h3>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Daftar semua permohonan yang telah disetujui atau ditolak.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Admin</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($applications as $app)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $app->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $app->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $app->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $app->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $app->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $app->admin_notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                Tidak ada riwayat permohonan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
