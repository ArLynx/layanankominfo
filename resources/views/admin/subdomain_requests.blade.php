<x-admin-layout title="Subdomain Requests">
    <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-headline-lg font-headline-lg text-on-surface">Subdomain Requests</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Manage and track new subdomain applications from various agencies.</p>
        </div>
    </header>

    <!-- Summary Cards Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Total Requests</p>
                <p class="text-headline-xl font-headline-xl text-primary">{{ $totalRequests }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">list_alt</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Pending Verification</p>
                <p class="text-headline-xl font-headline-xl text-status-pending">{{ $pendingVerification }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center text-status-pending">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pending_actions</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Active Subdomains</p>
                <p class="text-headline-xl font-headline-xl text-success-emerald">{{ $activeSubdomains }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center text-success-emerald">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>
        </div>
    </div>

    <!-- Filter & Table Section -->
    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm overflow-hidden">
        <!-- Header & Filters -->
        <div class="p-6 border-b border-border-subtle bg-surface-gray flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="text-headline-md font-headline-md text-on-surface">Application List</h3>
            <div class="flex flex-wrap gap-2">
                <button class="px-4 py-2 text-label-sm font-label-sm rounded-full bg-primary text-on-primary">All</button>
                <button class="px-4 py-2 text-label-sm font-label-sm rounded-full bg-surface text-on-surface-variant border border-border-subtle hover:bg-surface-container-low transition-colors">Pending</button>
                <button class="px-4 py-2 text-label-sm font-label-sm rounded-full bg-surface text-on-surface-variant border border-border-subtle hover:bg-surface-container-low transition-colors">Verified</button>
                <button class="px-4 py-2 text-label-sm font-label-sm rounded-full bg-surface text-on-surface-variant border border-border-subtle hover:bg-surface-container-low transition-colors">Rejected</button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle bg-surface-gray/50">
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Nama Instansi</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Subdomain Diinginkan</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">PIC Teknis</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
                        <th class="px-6 py-4 text-label-sm font-label-sm text-on-surface-variant text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface">
                    @forelse($applications as $app)
                        <tr class="border-b border-border-subtle hover:bg-surface-gray/30 transition-colors {{ $app->status === 'pending' ? 'bg-surface-gray/10' : '' }}">
                            <td class="px-6 py-4 font-medium">{{ $app->details['instansi'] ?? $app->user->instansi ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-mono text-sm">{{ $app->details['proposed_subdomain'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                {{ $app->details['pic_name'] ?? $app->user->name ?? 'Unknown' }}<br>
                                <span class="text-caption text-on-surface-variant">{{ $app->details['pic_contact'] ?? $app->user->email ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-label-sm font-label-sm 
                                    {{ $app->status === 'pending' ? 'bg-surface-container text-status-pending border border-status-pending/20' : '' }}
                                    {{ $app->status === 'approved' ? 'bg-surface-container text-success-emerald border border-success-emerald/20' : '' }}
                                    {{ $app->status === 'rejected' ? 'bg-surface-container text-error border border-error/20' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $app->status === 'pending' ? 'bg-status-pending' : ($app->status === 'approved' ? 'bg-success-emerald' : 'bg-error') }}"></span>
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($app->status === 'pending')
                                    <a href="{{ route('admin.process', $app->id) }}" class="text-primary hover:text-primary-fixed-dim transition-colors px-3 py-1 text-label-sm font-label-sm border border-primary rounded hover:bg-primary/5">Review</a>
                                @elseif($app->status === 'approved')
                                    <button class="text-primary hover:text-primary-fixed-dim transition-colors px-3 py-1 text-label-sm font-label-sm border border-border-subtle rounded hover:bg-surface-container-low text-on-surface-variant">Manage</button>
                                @else
                                    <a href="{{ route('admin.process.history', $app->id) }}" class="text-primary hover:text-primary-fixed-dim transition-colors px-3 py-1 text-label-sm font-label-sm border border-border-subtle rounded hover:bg-surface-container-low text-on-surface-variant">View</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                                Tidak ada permintaan subdomain.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($applications->hasPages())
        <div class="p-4 border-t border-border-subtle flex justify-between items-center text-caption font-caption text-on-surface-variant">
            <span>Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} entries</span>
            <div>
                {{ $applications->links() }}
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>
