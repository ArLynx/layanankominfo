<x-admin-layout title="Proses Permohonan">
    <!-- Master-Detail Split Layout -->
    <div class="flex flex-1 overflow-hidden p-gutter gap-gutter bg-surface-container-lowest rounded-xl"
        style="height: calc(100vh - 200px);">

        <!-- LEFT COLUMN: Master List (Pending Applications) -->
        <section
            class="w-1/3 min-w-[320px] flex flex-col bg-surface rounded-xl border border-border-subtle overflow-hidden shadow-sm flex-shrink-0">
            <div class="p-4 border-b border-border-subtle bg-surface-gray flex items-center justify-between">
                <h3 class="text-label-md font-label-md text-on-surface">Antrean Pengajuan ({{ $pendingCount }})
                </h3>
                <button class="text-outline hover:text-primary transition-colors">
                    <span class="material-symbols-outlined" style="font-size: 20px;">filter_list</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-2 space-y-2 bg-surface-container-low">
                @forelse($applications as $index => $app)
                    <!-- Application Item -->
                    <a href="{{ route('admin.process', request('id', $app->id)) }}"
                        class="block p-4 rounded-lg {{ $app->id == request('id', $applications->first()->id ?? null) ? 'bg-primary-fixed border border-primary-fixed' : 'bg-surface border border-border-subtle hover:border-outline-variant' }} cursor-pointer transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <span
                                class="text-caption font-caption {{ $app->id == request('id', $applications->first()->id ?? null) ? 'text-primary bg-primary-container/20' : 'text-secondary bg-secondary-container/20' }} px-2 py-0.5 rounded text-[10px] font-semibold tracking-wider uppercase">
                                {{ $app->type }}
                            </span>
                            <span
                                class="text-caption font-caption text-on-surface-variant">{{ $app->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-label-md font-label-md text-on-surface mb-1">
                            {{ $app->user->name }}
                        </h4>
                        <p class="text-caption font-caption text-on-surface-variant mb-3">
                            {{ $app->user->email }}
                        </p>
                         <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full {{ 
                                 $app->status === 'terbuka' ? 'bg-blue-500' : 
                                 ($app->status === 'proses' ? 'bg-yellow-500' : 
                                 ($app->status === 'ditunda' ? 'bg-orange-500' : 
                                 ($app->status === 'selesai' ? 'bg-green-500' : 
                                 ($app->status === 'tutup' ? 'bg-gray-500' : 'bg-red-500')))) 
                             }}"></div>
                              <span
                                  class="text-caption font-caption {{ 
                                      $app->status === 'terbuka' ? 'text-blue-600' : 
                                      ($app->status === 'proses' ? 'text-yellow-600' : 
                                      ($app->status === 'ditunda' ? 'text-orange-600' : 
                                      ($app->status === 'selesai' ? 'text-green-600' : 
                                      ($app->status === 'tutup' ? 'text-gray-600' : 'text-red-600')))) 
                                  }} font-medium uppercase">{{ $app->status }}</span>
                         </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-caption text-on-surface-variant">
                        Tidak ada permohonan pending.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- RIGHT COLUMN: Detail View -->
        <section
            class="flex-1 flex flex-col bg-surface rounded-xl border border-border-subtle overflow-hidden shadow-sm">
            @if($application)
                <!-- Detail Header & Stepper -->
                <div class="p-6 border-b border-border-subtle bg-surface">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-headline-md font-headline-md text-on-surface">
                                    #{{ $application->id }}
                                </h3>
                                <span
                                    class="bg-secondary-container text-on-secondary-container text-label-sm font-label-sm px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">pending_actions</span>
                                    Persetujuan
                                </span>
                            </div>
                            <p class="text-body-md font-body-md text-on-surface-variant">
                                {{ $application->reason ?? 'Tidak ada alasan yang diberikan' }}
                            </p>
                        </div>
                        <button
                            class="p-2 text-outline hover:text-primary hover:bg-primary-fixed rounded-lg transition-colors">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>

                    <!-- Horizontal Stepper (Simplified) -->
                    <div class="flex items-center w-full mt-4">
                        @php
                            $steps = ['Pengajuan', 'Verifikasi', 'Persetujuan', 'Distribusi'];
                            $currentStep = 3; // Static for now as we are in Process screen
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="flex items-center relative">
                                <div
                                    class="w-8 h-8 rounded-full {{ $index + 1 < $currentStep ? 'bg-primary text-on-primary' : ($index + 1 === $currentStep ? 'bg-secondary border-2 border-secondary-container text-on-secondary relative' : 'bg-surface-gray border border-border-subtle text-outline') }} flex items-center justify-center z-10 shadow-sm">
                                    @if($index + 1 < $currentStep)
                                        <span class="material-symbols-outlined" style="font-size: 16px;">check</span>
                                    @elseif($index + 1 === $currentStep)
                                        <span
                                            class="absolute inline-flex h-full w-full rounded-full bg-secondary-container opacity-50 animate-ping"></span>
                                        <span class="material-symbols-outlined relative" style="font-size: 16px;">edit_document</span>
                                    @else
                                        <span class="material-symbols-outlined" style="font-size: 16px;">circle</span>
                                    @endif
                                </div>
                                <div
                                    class="absolute top-10 left-1/2 -translate-x-1/2 whitespace-nowrap text-caption font-caption {{ $index + 1 === $currentStep ? 'text-secondary font-bold' : ($index + 1 < $currentStep ? 'text-on-surface' : 'text-outline') }}">
                                    {{ $step }}
                                </div>
                            </div>

                            @if(!$loop->last)
                                <div
                                    class="flex-1 h-1 {{ $index + 1 < $currentStep ? 'bg-primary' : 'bg-border-subtle' }} mx-2 rounded-full">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="h-6"></div>
                </div>

                <!-- Detail Content Scrollable Area -->
                <div class="flex-1 overflow-y-auto p-6 bg-surface-gray">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Bento Box 1: Data Pemohon -->
                        <div
                            class="col-span-1 md:col-span-2 bg-surface rounded-xl border border-border-subtle p-5 shadow-sm">
                            <div class="flex items-center gap-2 mb-4 pb-3 border-b border-border-subtle">
                                <span class="material-symbols-outlined text-primary">person</span>
                                <h4 class="text-label-md font-label-md text-on-surface">Data Pemohon</h4>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                                <div>
                                    <p class="text-caption font-caption text-on-surface-variant mb-1">Nama Lengkap</p>
                                    <p class="text-body-md font-body-md text-on-surface font-medium">
                                        {{ $application->user->name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-caption font-caption text-on-surface-variant mb-1">Email</p>
                                    <p class="text-body-md font-body-md text-on-surface font-medium">
                                        {{ $application->user->email }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-caption font-caption text-on-surface-variant mb-1">Tipe Permohonan</p>
                                    <p class="text-body-md font-body-md text-on-surface font-medium">
                                        {{ $application->type }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Bento Box 2: Dokumen Lampiran (Placeholder) -->
                        <div
                            class="col-span-1 bg-surface rounded-xl border border-border-subtle p-5 shadow-sm flex flex-col">
                            <div class="flex items-center gap-2 mb-4 pb-3 border-b border-border-subtle">
                                <span class="material-symbols-outlined text-primary">badge</span>
                                <h4 class="text-label-md font-label-md text-on-surface">Dokumen Identitas</h4>
                            </div>
                            <div
                                class="flex-1 bg-surface-container-low rounded-lg border border-border-subtle overflow-hidden relative group flex items-center justify-center p-4">
                                <p class="text-caption text-on-surface-variant text-center">Tidak ada lampiran dokumen.</p>
                            </div>
                        </div>

                         <!-- Bento Box 3: Area Pemrosesan (Admin Inputs) -->
                         <div
                             class="col-span-1 bg-surface-bright rounded-xl border-2 border-primary-fixed p-5 shadow-sm relative">
                             <div
                                 class="absolute top-0 right-5 -translate-y-1/2 bg-primary text-on-primary text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">
                                 Tindakan Diperlukan
                             </div>
                             <div class="flex items-center gap-2 mb-4 pb-3 border-b border-border-subtle">
                                 <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                                 <h4 class="text-label-md font-label-md text-on-surface">Update Status & Catatan</h4>
                             </div>
                             
                             <form method="POST" action="{{ route('admin.process.update', $application->id) }}" id="status-update-form">
                                 @csrf
                                 @method('PATCH')
                                 <div class="space-y-4">
                                     <div>
                                         <label class="block text-label-sm font-label-sm text-on-surface mb-1">Ubah Status</label>
                                         <select name="status" class="w-full px-3 py-2 bg-surface border border-border-subtle rounded-lg text-body-md font-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface">
                                             <option value="terbuka" {{ $application->status === 'terbuka' ? 'selected' : '' }}>Terbuka</option>
                                             <option value="proses" {{ $application->status === 'proses' ? 'selected' : '' }}>Sedang Proses</option>
                                             <option value="ditunda" {{ $application->status === 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                                             <option value="selesai" {{ $application->status === 'selesai' ? 'selected' : '' }}>Terselesaikan</option>
                                             <option value="tutup" {{ $application->status === 'tutup' ? 'selected' : '' }}>Ditutup</option>
                                             <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Tolak</option>
                                         </select>
                                     </div>
                                     <div>
                                         <label class="block text-label-sm font-label-sm text-on-surface mb-1">Catatan Admin</label>
                                         <textarea name="admin_notes"
                                             class="w-full px-3 py-2 bg-surface border border-border-subtle rounded-lg text-body-md font-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface"
                                             rows="3" placeholder="Masukkan alasan atau catatan..." >{{ $application->admin_notes }}</textarea>
                                     </div>
                                 </div>
                             </form>
                         </div>
                    </div>
                </div>

                <!-- Sticky Footer Actions -->
                <div
                    class="p-4 border-t border-border-subtle bg-surface-container-lowest flex items-center justify-between mt-auto">
                    <button
                        disabled
                        class="flex items-center gap-2 px-4 py-2 text-outline bg-surface-gray cursor-not-allowed rounded-lg text-label-md font-label-md transition-colors border border-transparent">
                        <span class="material-symbols-outlined" style="font-size: 20px;">picture_as_pdf</span>
                        Buat Dokumen PDF
                    </button>

                    <button type="submit" form="status-update-form"
                        class="px-6 py-2 bg-primary hover:bg-primary-container text-on-primary rounded-lg text-label-md font-label-md transition-colors shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined"
                            style="font-size: 20px; font-variation-settings: 'FILL' 1;">update</span>
                        Update Status
                    </button>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-on-surface-variant text-label-md">
                    Silakan pilih permohonan dari daftar di samping.
                </div>
            @endif
        </section>
    </div>
</x-admin-layout>
