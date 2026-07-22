<x-app-layout>
    <!-- Page Header -->
    <header
        class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-border-subtle pb-6">
        <div>
            <h2
                class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                Status Pengajuan</h2>
            <p class="text-body-md font-body-md text-on-surface-variant">Pantau progres layanan administratif Anda saat ini.</p>
        </div>
    </header>

    <!-- Info Banner -->
    <div class="bg-primary-container/10 border-l-4 border-primary p-4 rounded-r-lg">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-primary">info</span>
            <p class="text-label-md text-primary font-medium">Kebijakan Layanan: Subdomain dan email di bawah domain murungrayakab.go.id hanya tersedia untuk Dinas/Unit Kerja di lingkungan Pemerintah Kabupaten Murung Raya. Layanan untuk tingkat Desa tidak tersedia melalui jalur ini.</p>
        </div>
    </div>

    <!-- Active Applications List -->
    <section class="flex flex-col gap-6">
        @forelse($applications as $app)
            <article
                class="bg-surface rounded-xl border border-border-subtle p-6 flex flex-col gap-8 relative overflow-hidden transition-all duration-300 hover:shadow-[0_4px_12px_rgba(0,30,64,0.04)]">
                
                 <!-- Status Indicator Line -->
                 <div class="absolute left-0 top-0 bottom-0 w-1 {{ 
                     $app->status === 'selesai' || $app->status === 'tutup' ? 'bg-success-emerald' : 
                     ($app->status === 'rejected' ? 'bg-error' : 
                     ($app->status === 'proses' ? 'bg-yellow-500' : 
                     ($app->status === 'ditunda' ? 'bg-orange-500' : 'bg-blue-500'))) 
                 }}"></div>


                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="bg-surface-container-low text-primary text-label-sm font-label-sm px-2 py-0.5 rounded border border-border-subtle">ID:
                                APP-{{ str_pad($app->id, 4, '0', STR_PAD_LEFT) }}-{{ date('Y') }}</span>
                             <span
                                 class="bg-{{ 
                                     $app->status === 'selesai' || $app->status === 'tutup' ? 'success-emerald' : 
                                     ($app->status === 'rejected' ? 'error' : 
                                     ($app->status === 'proses' ? 'yellow-500' : 
                                     ($app->status === 'ditunda' ? 'orange-500' : 'blue-500'))) 
                                 }}/10 text-{{ 
                                     $app->status === 'selesai' || $app->status === 'tutup' ? 'success-emerald' : 
                                     ($app->status === 'rejected' ? 'error' : 
                                     ($app->status === 'proses' ? 'yellow-600' : 
                                     ($app->status === 'ditunda' ? 'orange-600' : 'blue-600'))) 
                                 }} text-label-sm font-label-sm px-2 py-0.5 rounded border border-{{ 
                                     $app->status === 'selesai' || $app->status === 'tutup' ? 'success-emerald' : 
                                     ($app->status === 'rejected' ? 'error' : 
                                     ($app->status === 'proses' ? 'yellow-500' : 
                                     ($app->status === 'ditunda' ? 'orange-500' : 'blue-500'))) 
                                 }}/20 flex items-center gap-1">
                                 <span class="material-symbols-outlined text-[14px]">
                                     {{ 
                                         $app->status === 'selesai' || $app->status === 'tutup' ? 'check_circle' : 
                                         ($app->status === 'rejected' ? 'cancel' : 
                                         ($app->status === 'proses' ? 'settings' : 
                                         ($app->status === 'ditunda' ? 'pause_circle' : 'pending'))) 
                                     }}
                                 </span> 
                                 {{ ucfirst($app->status) }}
                             </span>
                        </div>
                        <h3 class="text-headline-md font-headline-md text-primary">Pengajuan {{ $app->type === 'subdomain' ? 'Subdomain' : 'Email Resmi' }} {{ $app->unit_work ?? 'Dinas/Unit Kerja' }} @murungrayakab.go.id</h3>
                        <p class="text-label-sm font-label-sm text-on-surface-variant mt-1">Diajukan: {{ $app->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                 <!-- Dynamic Stepper -->
                 <div class="relative w-full pt-2">
                     <!-- Connecting Lines -->
                     <div class="absolute top-[15px] left-4 right-4 h-0.5 bg-border-subtle hidden md:block z-0"></div>
                     
                     @php
                         $statusMap = [
                             'terbuka' => 1,
                             'proses' => 3,
                             'ditunda' => 2,
                             'selesai' => 5,
                             'tutup' => 5,
                             'rejected' => 2,
                         ];
                         $currentStep = $statusMap[$app->status] ?? 1;
                     @endphp

                     <div class="absolute top-[15px] left-4 h-[2px] {{ $currentStep > 1 ? 'bg-primary' : 'bg-border-subtle' }} hidden md:block z-0" 
                          style="width: calc(({{ $currentStep - 1 }} / 4) * 100% + 1rem);"></div>
                     
                     <div class="flex flex-col md:flex-row justify-between relative z-10 gap-6 md:gap-2">
                         @php
                             $steps = [
                                 ['label' => 'Pengajuan', 'icon' => 'add_circle'],
                                 ['label' => 'Pemeriksaan Dokumen', 'icon' => 'fact_check'],
                                 ['label' => 'Proses Pembuatan', 'icon' => 'settings'],
                                 ['label' => 'Persetujuan', 'icon' => 'edit_document'],
                                 ['label' => 'Selesai', 'icon' => 'task_alt'],
                             ];
                         @endphp
                         
                         @foreach($steps as $index => $step)
                                 @php
                                     $stepNum = $index + 1;
                                     $isCompleted = ($currentStep > $stepNum && $app->status !== 'rejected') || 
                                                   ($currentStep === $stepNum && ($app->status === 'selesai' || $app->status === 'tutup'));
                                     $isActive = $currentStep === $stepNum && !($app->status === 'selesai' || $app->status === 'tutup');
                                     $isRejected = $app->status === 'rejected' && $stepNum === 2;
                                 @endphp
                             <div class="flex md:flex-col items-center md:items-center gap-3 md:gap-2 w-full md:w-1/5 relative">
                                 <div class="w-8 h-8 rounded-full {{ 
                                     $isRejected ? 'bg-error text-white' : 
                                     ($isCompleted ? 'bg-success-emerald text-white' : 
                                     ($isActive ? 'bg-status-pending text-on-secondary animate-pulse' : 'bg-surface text-on-surface-variant border-2 border-border-subtle')) 
                                 }} flex items-center justify-center shrink-0 shadow-sm">
                                     @if($isRejected)
                                         <span class="material-symbols-outlined text-[16px]">cancel</span>
                                     @elseif($isCompleted)
                                         <span class="material-symbols-outlined text-[16px]">check</span>
                                     @else
                                         <span class="material-symbols-outlined text-[16px]">{{ $step['icon'] }}</span>
                                     @endif
                                 </div>
                                  <div class="text-left md:text-center">
                                      <p class="text-label-sm font-label-sm {{ $isCompleted || $isActive ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
                                          {{ $step['label'] }}
                                      </p>
                                      @if($isRejected)
                                          <p class="text-caption font-caption text-error hidden md:block">Ditolak</p>
                                      @elseif($isCompleted)
                                          <p class="text-caption font-caption text-success-emerald hidden md:block">Selesai</p>
                                      @elseif($isActive)
                                          <p class="text-caption font-caption {{ $app->status === 'selesai' || $app->status === 'tutup' ? 'text-success-emerald' : 'text-status-pending' }} hidden md:block">
                                              {{ $app->status === 'selesai' || $app->status === 'tutup' ? 'Selesai' : 'Diproses' }}
                                          </p>
                                      @endif
                                  </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
            </article>
        @empty
            <div class="bg-surface border border-border-subtle rounded-xl p-12 text-center shadow-sm">
                <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">assignment_late</span>
                <h3 class="text-headline-md font-headline-md text-on-surface">Belum Ada Pengajuan</h3>
                <p class="text-body-md text-on-surface-variant mt-2">Anda belum mengajukan permohonan layanan apapun.</p>
            </div>
        @endforelse
    </section>

    <!-- Footer Spacer -->
    <div class="h-24"></div>
</x-app-layout>
