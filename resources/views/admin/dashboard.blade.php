<x-admin-layout title="Dashboard Admin">
    <!-- Statistics Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-surface-container-lowest rounded-xl p-6 border border-border-subtle flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Total Pengajuan</p>
                <p class="text-headline-lg font-headline-lg text-primary">{{ $totalPengajuan ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">assignment</span>
            </div>
        </div>
        <div
            class="bg-surface-container-lowest rounded-xl p-6 border border-border-subtle flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Menunggu Proses</p>
                <p class="text-headline-lg font-headline-lg text-status-pending">{{ $totalPending ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-status-pending">
                <span class="material-symbols-outlined text-3xl">hourglass_empty</span>
            </div>
        </div>
        <div
            class="bg-surface-container-lowest rounded-xl p-6 border border-border-subtle flex items-center justify-between">
            <div>
                <p class="text-label-md font-label-md text-on-surface-variant mb-1">Telah Diproses</p>
                <p class="text-headline-lg font-headline-lg text-success-emerald">{{ $totalProcessed ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-success-emerald">
                <span class="material-symbols-outlined text-3xl">check_circle</span>
            </div>
        </div>
    </section>

    <!-- Detail Stats per Layanan -->
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
        <div class="px-6 py-4 border-b border-border-subtle bg-surface">
            <h3 class="text-headline-md font-headline-md text-on-surface">Rincian Pengajuan per Layanan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-surface-gray border-b border-border-subtle text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider">
                        <th class="px-6 py-3">Layanan</th>
                        <th class="px-6 py-3 text-center">Total</th>
                        <th class="px-6 py-3 text-center">Menunggu</th>
                        <th class="px-6 py-3 text-center">Diproses</th>
                    </tr>
                </thead>
                <tbody class="text-body-md font-body-md text-on-surface divide-y divide-border-subtle">
                    <tr class="hover:bg-surface-gray transition-colors">
                        <td class="px-6 py-4 font-medium">Subdomain</td>
                        <td class="px-6 py-4 text-center">{{ $totalSubdomain ?? 0 }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-status-pending">
                                {{ $pendingSubdomain ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $processedSubdomain ?? 0 }}
                            </span>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-gray transition-colors">
                        <td class="px-6 py-4 font-medium">Email Satker</td>
                        <td class="px-6 py-4 text-center">{{ $totalEmailSatker ?? 0 }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-status-pending">
                                {{ $pendingEmailSatker ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $processedEmailSatker ?? 0 }}
                            </span>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-gray transition-colors">
                        <td class="px-6 py-4 font-medium">Email Pribadi</td>
                        <td class="px-6 py-4 text-center">{{ $totalEmailPribadi ?? 0 }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-status-pending">
                                {{ $pendingEmailPribadi ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $processedEmailPribadi ?? 0 }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</x-admin-layout>
