<x-public-layout>
    <section class="relative overflow-hidden border-b border-border-subtle" style="min-height: calc(100vh - 64px);">
        <div class="relative max-w-7xl mx-auto px-6 py-12 lg:py-24">

            <!-- HEADER MOBILE -->
            <div class="md:hidden flex flex-col items-center text-center max-w-3xl mb-10 z-10">
                <h1 class="text-[32px] leading-[40px] font-bold text-primary">
                    Status Pengajuan
                </h1>
                <p class="mt-4 text-base text-on-surface-variant">
                    Hasil pencarian berdasarkan nomor tiket :
                    <span class="font-semibold text-primary block mt-1 text-lg">
                        {{ $ticket }}
                    </span>
                </p>
            </div>

            <!-- HEADER DESKTOP (Original) -->
            <div class="hidden md:block max-w-3xl mb-10">
                <h1 class="text-headline-xl font-headline-xl text-primary">
                    Status Pengajuan
                </h1>
                <p class="mt-3 text-on-surface-variant text-body-lg">
                    Hasil pencarian berdasarkan nomor tiket :
                    <span class="font-semibold text-primary">
                        {{ $ticket }}
                    </span>
                </p>
            </div>

            @if ($subdomain)
                @php
                    $statusMap = [
                        'terbuka' => 1,
                        'baru' => 2,
                        'tunda' => 3,
                        'diproses' => 4,
                        'selesai' => 5,
                        'tutup' => 5,
                    ];
                    $currentStep = $statusMap[$subdomain->status] ?? 1;
                    $isRejected = $subdomain->status === 'tutup';
                    $steps = [
                        'Pengajuan',
                        'Pemeriksaan Dokumen',
                        'Persetujuan',
                        'Proses Pembuatan',
                        $isRejected ? 'Pengajuan Ditolak' : 'Selesai',
                    ];
                    $icons = ['description', 'fact_check', 'sync', 'verified', $isRejected ? 'cancel' : 'flag'];
                @endphp

                <!-- MOBILE ARTICLE - SUBDOMAIN -->
                <article
                    class="md:hidden bg-white rounded-2xl border border-border-subtle p-5 flex flex-col relative overflow-hidden shadow-sm">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $isRejected ? 'bg-red-500' : ($subdomain->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}">
                    </div>

                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="bg-surface-container-low text-primary text-xs font-semibold px-2 py-1 rounded border border-border-subtle">
                                {{ $subdomain->nomor_tiket }}
                            </span>
                            @switch($subdomain->status)
                                @case('terbuka')
                                    <span
                                        class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded border border-blue-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">description</span>Pengajuan</span>
                                @break

                                @case('baru')
                                    <span
                                        class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded border border-gray-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">fact_check</span>Pemeriksaan
                                        Dokumen</span>
                                @break

                                @case('tunda')
                                    <span
                                        class="bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded border border-orange-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">approval</span>Persetujuan
                                        Pimpinan</span>
                                @break

                                @case('diproses')
                                    <span
                                        class="bg-secondary-container/30 text-on-secondary-container text-xs font-semibold px-2 py-1 rounded border border-secondary-container/50 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">pending</span>Proses Pembuatan</span>
                                @break

                                @case('selesai')
                                    <span
                                        class="bg-success-emerald/10 text-success-emerald text-xs font-semibold px-2 py-1 rounded border border-success-emerald/20 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">check_circle</span>Selesai</span>
                                @break

                                @case('tutup')
                                    <span
                                        class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded border border-red-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">cancel</span>Pengajuan Dicancel</span>
                                @break
                            @endswitch
                        </div>
                        <h3 class="text-xl font-bold text-primary leading-tight">Pengajuan Subdomain Dinas/Unit Kerja
                            @murungrayakab.go.id</h3>
                        <p class="text-sm text-on-surface-variant">Diajukan:
                            {{ $subdomain->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- Progress Bar Horizontal Mobile -->
                    <div class="relative mt-8">

                        @php
                            $totalSteps = count($steps);
                            $progressPercent = $totalSteps > 1 ? (($currentStep - 1) / ($totalSteps - 1)) * 100 : 0;
                        @endphp

                        <!-- Garis -->
                        <div
                            class="absolute
                                top-[15px]
                                left-4
                                right-4
                                h-[2px]
                                bg-gray-200
                                z-0">

                            <!-- Progress -->
                            <div class="h-full transition-all duration-500
                                {{ $isRejected ? 'bg-red-500' : ($subdomain->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}"
                                style="width: {{ $progressPercent }}%;">
                            </div>

                        </div>

                        <!-- STEP -->
                        <div class="relative z-10 flex justify-between">

                            @foreach ($steps as $index => $step)
                                @php
                                    $number = $index + 1;
                                    $completed = $number < $currentStep;
                                    $active = $number == $currentStep;
                                @endphp

                                <div class="flex flex-col items-center w-16">

                                    <!-- ICON -->
                                    <div
                                        class="w-8 h-8 rounded-full border-2 bg-white flex items-center justify-center transition-all duration-300

                                        @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }}

                                        @elseif($active)

                                            {{ $isRejected
                                                ? 'bg-red-500 border-red-500 text-white'
                                                : ($subdomain->status == 'selesai'
                                                    ? 'bg-green-500 border-green-500 text-white'
                                                    : 'bg-yellow-500 border-yellow-500 text-white') }}

                                        @else

                                            border-gray-300 text-gray-400 @endif">

                                        @if ($completed)
                                            <span class="material-symbols-outlined text-[16px]">
                                                check
                                            </span>
                                        @elseif($active)
                                            <span
                                                class="material-symbols-outlined text-[16px] {{ $subdomain->status == 'diproses' ? 'animate-spin' : '' }}">
                                                {{ $icons[$index] }}
                                            </span>
                                        @elseif($isRejected && $number == $totalSteps)
                                            <span class="material-symbols-outlined text-[16px]">
                                                close
                                            </span>
                                        @else
                                            <span class="material-symbols-outlined text-[16px]">
                                                {{ $icons[$index] }}
                                            </span>
                                        @endif

                                    </div>

                                    <!-- LABEL -->
                                    <p
                                        class="mt-3
                                            text-[10px]
                                            leading-3
                                            text-center
                                            min-h-[28px]

                                        @if ($active && $isRejected) text-red-600 font-semibold

                                        @elseif($number <= $currentStep)

                                            text-primary font-semibold

                                        @else

                                            text-gray-500 @endif">

                                        {{ $step }}

                                    </p>

                                </div>
                            @endforeach

                        </div>

                    </div>
                </article>

                <!-- DESKTOP ARTICLE - SUBDOMAIN (Original) -->
                <article
                    class="hidden md:flex mt-10 bg-white rounded-2xl border border-border-subtle p-8 flex-col gap-10 relative overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $isRejected ? 'bg-red-500' : ($subdomain->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-surface-container-low text-primary text-label-sm font-label-sm px-2 py-0.5 rounded border border-border-subtle">{{ $subdomain->nomor_tiket }}</span>
                                @switch($subdomain->status)
                                    @case('terbuka')
                                        <span
                                            class="bg-blue-100 text-blue-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-blue-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">description</span>Pengajuan</span>
                                    @break

                                    @case('baru')
                                        <span
                                            class="bg-gray-100 text-gray-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-gray-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">fact_check</span>Pemeriksaan
                                            Dokumen</span>
                                    @break

                                    @case('tunda')
                                        <span
                                            class="bg-orange-100 text-orange-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-orange-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">approval</span>Persetujuan
                                            Pimpinan</span>
                                    @break

                                    @case('diproses')
                                        <span
                                            class="bg-secondary-container/30 text-on-secondary-container text-label-sm font-label-sm px-2 py-0.5 rounded border border-secondary-container/50 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">pending</span>Proses
                                            Pembuatan</span>
                                    @break

                                    @case('selesai')
                                        <span
                                            class="bg-success-emerald/10 text-success-emerald text-label-sm font-label-sm px-2 py-0.5 rounded border border-success-emerald/20 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">check_circle</span>Selesai</span>
                                    @break

                                    @case('tutup')
                                        <span
                                            class="bg-red-100 text-red-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-red-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">cancel</span>Pengajuan
                                            Dicancel</span>
                                    @break
                                @endswitch
                            </div>
                            <h3 class="text-headline-md font-headline-md text-primary">Pengajuan Subdomain Dinas/Unit
                                Kerja @murungrayakab.go.id</h3>
                            <p class="text-label-sm font-label-sm text-on-surface-variant mt-1">Diajukan:
                                {{ $subdomain->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="relative mt-6">
                        <div class="absolute top-5 left-5 right-5 h-1 bg-gray-200"></div>
                        <div class="absolute top-5 left-5 h-1 {{ $isRejected ? 'bg-red-500' : 'bg-blue-500' }}"
                            style="width: {{ (($currentStep - 1) / (count($steps) - 1)) * 100 }}%;"></div>
                        <div class="flex justify-between relative z-10">
                            @foreach ($steps as $index => $step)
                                @php
                                    $number = $index + 1;
                                    $completed = $number < $currentStep;
                                    $active = $number == $currentStep;
                                @endphp
                                <div class="flex flex-col items-center w-1/5">
                                    <div
                                        class="w-8 h-8 rounded-full border-2 border-surface flex items-center justify-center shrink-0 @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }} @elseif($active) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : ($subdomain->status == 'selesai' ? 'bg-green-500 border-green-500 text-white' : 'bg-yellow-500 border-yellow-500 text-white') }} @else bg-white border-gray-300 text-gray-400 @endif">
                                        @if ($completed)
                                            <span class="material-symbols-outlined text-[16px]">check</span>
                                        @elseif($active)
                                            <span
                                                class="material-symbols-outlined text-[16px] {{ $subdomain->status == 'diproses' ? 'animate-spin' : '' }}">{{ $icons[$index] }}</span>
                                        @elseif($isRejected && $number == count($steps))
                                            <span class="material-symbols-outlined text-[16px]">close</span>
                                        @else
                                            <span
                                                class="material-symbols-outlined text-[16px]">{{ $icons[$index] }}</span>
                                        @endif
                                    </div>
                                    <p
                                        class="text-label-sm font-label-sm text-center mt-2 @if ($active && $isRejected) text-red-600 font-semibold @elseif($number <= $currentStep) text-primary font-semibold @else text-gray-500 @endif">
                                        {{ $step }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            @elseif($emailSatker)
                @php
                    $statusMap = [
                        'terbuka' => 1,
                        'baru' => 2,
                        'tunda' => 3,
                        'diproses' => 4,
                        'selesai' => 5,
                        'tutup' => 5,
                    ];
                    $currentStep = $statusMap[$emailSatker->status] ?? 1;
                    $isRejected = $emailSatker->status === 'tutup';
                    $steps = [
                        'Pengajuan',
                        'Pemeriksaan Dokumen',
                        'Persetujuan',
                        'Proses Pembuatan',
                        $isRejected ? 'Pengajuan Ditolak' : 'Selesai',
                    ];
                    $icons = ['description', 'fact_check', 'sync', 'verified', $isRejected ? 'cancel' : 'flag'];
                @endphp


                <!-- MOBILE ARTICLE - EMAIL SATKER -->
                <article
                    class="md:hidden bg-surface rounded-2xl border border-border-subtle p-5 flex flex-col relative overflow-hidden shadow-sm">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $isRejected ? 'bg-red-500' : ($emailSatker->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}">
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="bg-surface-container-low text-primary text-xs font-semibold px-2 py-1 rounded border border-border-subtle">{{ $emailSatker->nomor_tiket }}</span>
                            @switch($emailSatker->status)
                                @case('terbuka')
                                    <span
                                        class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded border border-blue-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">description</span>Pengajuan</span>
                                @break

                                @case('baru')
                                    <span
                                        class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded border border-gray-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">fact_check</span>Pemeriksaan
                                        Dokumen</span>
                                @break

                                @case('tunda')
                                    <span
                                        class="bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded border border-orange-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">approval</span>Persetujuan
                                        Pimpinan</span>
                                @break

                                @case('diproses')
                                    <span
                                        class="bg-secondary-container/30 text-on-secondary-container text-xs font-semibold px-2 py-1 rounded border border-secondary-container/50 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">pending</span>Proses Pembuatan</span>
                                @break

                                @case('selesai')
                                    <span
                                        class="bg-success-emerald/10 text-success-emerald text-xs font-semibold px-2 py-1 rounded border border-success-emerald/20 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">check_circle</span>Selesai</span>
                                @break

                                @case('tutup')
                                    <span
                                        class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded border border-red-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">cancel</span>Pengajuan Dicancel</span>
                                @break
                            @endswitch
                        </div>
                        <h3 class="text-xl font-bold text-primary leading-tight">Pengajuan Email Dinas/Unit Kerja
                            @murungrayakab.go.id</h3>
                        <p class="text-sm text-on-surface-variant">Diajukan:
                            {{ $emailSatker->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- Progress Bar Horizontal Mobile -->
                    <div class="relative mt-8">

                        @php
                            $totalSteps = count($steps);
                            $progressPercent = $totalSteps > 1 ? (($currentStep - 1) / ($totalSteps - 1)) * 100 : 0;
                        @endphp

                        <!-- Garis -->
                        <div
                            class="absolute
                                top-[15px]
                                left-4
                                right-4
                                h-[2px]
                                bg-gray-200
                                z-0">

                            <!-- Progress -->
                            <div class="h-full transition-all duration-500
                                {{ $isRejected ? 'bg-red-500' : ($emailSatker->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}"
                                style="width: {{ $progressPercent }}%;">
                            </div>

                        </div>

                        <!-- STEP -->
                        <div class="relative z-10 flex justify-between">

                            @foreach ($steps as $index => $step)
                                @php
                                    $number = $index + 1;
                                    $completed = $number < $currentStep;
                                    $active = $number == $currentStep;
                                @endphp

                                <div class="flex flex-col items-center w-16">

                                    <!-- ICON -->
                                    <div
                                        class="w-8 h-8 rounded-full border-2 bg-white flex items-center justify-center transition-all duration-300

                                        @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }}

                                        @elseif($active)

                                            {{ $isRejected
                                                ? 'bg-red-500 border-red-500 text-white'
                                                : ($emailSatker->status == 'selesai'
                                                    ? 'bg-green-500 border-green-500 text-white'
                                                    : 'bg-yellow-500 border-yellow-500 text-white') }}

                                        @else

                                            border-gray-300 text-gray-400 @endif">

                                        @if ($completed)
                                            <span class="material-symbols-outlined text-[16px]">
                                                check
                                            </span>
                                        @elseif($active)
                                            <span
                                                class="material-symbols-outlined text-[16px] {{ $emailSatker->status == 'diproses' ? 'animate-spin' : '' }}">
                                                {{ $icons[$index] }}
                                            </span>
                                        @elseif($isRejected && $number == $totalSteps)
                                            <span class="material-symbols-outlined text-[16px]">
                                                close
                                            </span>
                                        @else
                                            <span class="material-symbols-outlined text-[16px]">
                                                {{ $icons[$index] }}
                                            </span>
                                        @endif

                                    </div>

                                    <!-- LABEL -->
                                    <p
                                        class="mt-3
                                            text-[10px]
                                            leading-3
                                            text-center
                                            min-h-[28px]

                                        @if ($active && $isRejected) text-red-600 font-semibold

                                        @elseif($number <= $currentStep)

                                            text-primary font-semibold

                                        @else

                                            text-gray-500 @endif">

                                        {{ $step }}

                                    </p>

                                </div>
                            @endforeach

                        </div>

                    </div>
                </article>


                <!-- DESKTOP ARTICLE - EMAIL SATKER -->
                <article
                    class="hidden md:flex bg-surface rounded-xl border border-border-subtle p-6 flex-col gap-8 relative overflow-hidden transition-all duration-300 hover:shadow-[0_4px_12px_rgba(0,30,64,0.04)]">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $isRejected ? 'bg-red-500' : ($emailSatker->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-surface-container-low text-primary text-label-sm font-label-sm px-2 py-0.5 rounded border border-border-subtle">{{ $emailSatker->nomor_tiket }}</span>
                                @switch($emailSatker->status)
                                    @case('terbuka')
                                        <span
                                            class="bg-blue-100 text-blue-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-blue-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">description</span>Pengajuan</span>
                                    @break

                                    @case('baru')
                                        <span
                                            class="bg-gray-100 text-gray-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-gray-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">fact_check</span>Pemeriksaan
                                            Dokumen</span>
                                    @break

                                    @case('tunda')
                                        <span
                                            class="bg-orange-100 text-orange-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-orange-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">approval</span>Persetujuan
                                            Pimpinan</span>
                                    @break

                                    @case('diproses')
                                        <span
                                            class="bg-secondary-container/30 text-on-secondary-container text-label-sm font-label-sm px-2 py-0.5 rounded border border-secondary-container/50 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">pending</span>Proses
                                            Pembuatan</span>
                                    @break

                                    @case('selesai')
                                        <span
                                            class="bg-success-emerald/10 text-success-emerald text-label-sm font-label-sm px-2 py-0.5 rounded border border-success-emerald/20 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">check_circle</span>Selesai</span>
                                    @break

                                    @case('tutup')
                                        <span
                                            class="bg-red-100 text-red-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-red-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">cancel</span>Pengajuan
                                            Dicancel</span>
                                    @break
                                @endswitch
                            </div>
                            <h3 class="text-headline-md font-headline-md text-primary">Pengajuan Email Dinas/Unit Kerja
                                @murungrayakab.go.id</h3>
                            <p class="text-label-sm font-label-sm text-on-surface-variant mt-1">Diajukan:
                                {{ $emailSatker->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="relative mt-6">
                        <div class="absolute top-5 left-5 right-5 h-1 bg-gray-200"></div>
                        <div class="absolute top-5 left-5 h-1 {{ $isRejected ? 'bg-red-500' : 'bg-blue-500' }}"
                            style="width: {{ (($currentStep - 1) / (count($steps) - 1)) * 100 }}%;"></div>
                        <div class="flex justify-between relative z-10">
                            @foreach ($steps as $index => $step)
                                @php
                                    $number = $index + 1;
                                    $completed = $number < $currentStep;
                                    $active = $number == $currentStep;
                                @endphp
                                <div class="flex flex-col items-center w-1/5">
                                    <div
                                        class="w-8 h-8 rounded-full border-2 border-surface flex items-center justify-center shrink-0 @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }} @elseif($active) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : ($emailSatker->status == 'selesai' ? 'bg-green-500 border-green-500 text-white' : 'bg-yellow-500 border-yellow-500 text-white') }} @else bg-white border-gray-300 text-gray-400 @endif">
                                        @if ($completed)
                                            <span class="material-symbols-outlined text-[16px]">check</span>
                                        @elseif($active)
                                            <span
                                                class="material-symbols-outlined text-[16px] {{ $emailSatker->status == 'diproses' ? 'animate-spin' : '' }}">{{ $icons[$index] }}</span>
                                        @elseif($isRejected && $number == count($steps))
                                            <span class="material-symbols-outlined text-[16px]">close</span>
                                        @else
                                            <span
                                                class="material-symbols-outlined text-[16px]">{{ $icons[$index] }}</span>
                                        @endif
                                    </div>
                                    <p
                                        class="text-label-sm font-label-sm text-center mt-2 @if ($active && $isRejected) text-red-600 font-semibold @elseif($number <= $currentStep) text-primary font-semibold @else text-gray-500 @endif">
                                        {{ $step }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            @elseif($emailPribadi)
                @php
                    $needApproval = $emailPribadi->jenis_layanan == 'baru';
                    if ($needApproval) {
                        $statusMap = [
                            'terbuka' => 1,
                            'baru' => 2,
                            'tunda' => 3,
                            'diproses' => 4,
                            'selesai' => 5,
                            'tutup' => 5,
                        ];
                        $steps = [
                            'Pengajuan',
                            'Pemeriksaan Dokumen',
                            'Persetujuan',
                            'Proses Pembuatan',
                            $emailPribadi->status == 'tutup' ? 'Pengajuan Ditolak' : 'Selesai',
                        ];
                        $icons = [
                            'description',
                            'fact_check',
                            'approval',
                            'pending',
                            $emailPribadi->status == 'tutup' ? 'cancel' : 'check_circle',
                        ];
                    } else {
                        $statusMap = ['terbuka' => 1, 'baru' => 2, 'diproses' => 3, 'selesai' => 4, 'tutup' => 4];
                        $steps = [
                            'Pengajuan',
                            'Pemeriksaan Dokumen',
                            'Proses Pembuatan',
                            $emailPribadi->status == 'tutup' ? 'Pengajuan Ditolak' : 'Selesai',
                        ];
                        $icons = [
                            'description',
                            'fact_check',
                            'pending',
                            $emailPribadi->status == 'tutup' ? 'cancel' : 'check_circle',
                        ];
                    }
                    $currentStep = $statusMap[$emailPribadi->status] ?? 1;
                    $isRejected = $emailPribadi->status == 'tutup';
                @endphp


                <!-- MOBILE ARTICLE - EMAIL PRIBADI -->
                <article
                    class="md:hidden bg-surface rounded-2xl border border-border-subtle p-5 flex flex-col relative overflow-hidden shadow-sm">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $isRejected ? 'bg-red-500' : ($emailPribadi->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}">
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="bg-surface-container-low text-primary text-xs font-semibold px-2 py-1 rounded border border-border-subtle">{{ $emailPribadi->nomor_tiket }}</span>
                            @switch($emailPribadi->status)
                                @case('terbuka')
                                    <span
                                        class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded border border-blue-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">description</span>Pengajuan</span>
                                @break

                                @case('baru')
                                    <span
                                        class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded border border-gray-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">fact_check</span>Pemeriksaan
                                        Dokumen</span>
                                @break

                                @case('tunda')
                                    <span
                                        class="bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded border border-orange-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">approval</span>Persetujuan
                                        Pimpinan</span>
                                @break

                                @case('diproses')
                                    <span
                                        class="bg-secondary-container/30 text-on-secondary-container text-xs font-semibold px-2 py-1 rounded border border-secondary-container/50 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">pending</span>Proses Pembuatan</span>
                                @break

                                @case('selesai')
                                    <span
                                        class="bg-success-emerald/10 text-success-emerald text-xs font-semibold px-2 py-1 rounded border border-success-emerald/20 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">check_circle</span>Selesai</span>
                                @break

                                @case('tutup')
                                    <span
                                        class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded border border-red-200 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">cancel</span>Pengajuan
                                        Dicancel</span>
                                @break
                            @endswitch
                        </div>
                        <h3 class="text-xl font-bold text-primary leading-tight">Pengajuan Email Pribadi
                            @murungrayakab.go.id</h3>
                        <p class="text-sm text-on-surface-variant">Diajukan:
                            {{ $emailPribadi->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- Progress Bar Horizontal Mobile -->
                    <div class="relative mt-8">

                        @php
                            $totalSteps = count($steps);
                            $progressPercent = $totalSteps > 1 ? (($currentStep - 1) / ($totalSteps - 1)) * 100 : 0;
                        @endphp

                        <!-- Garis -->
                        <div
                            class="absolute
                                top-[15px]
                                left-4
                                right-4
                                h-[2px]
                                bg-gray-200
                                z-0">

                            <!-- Progress -->
                            <div class="h-full transition-all duration-500
                                {{ $isRejected ? 'bg-red-500' : ($emailPribadi->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}"
                                style="width: {{ $progressPercent }}%;">
                            </div>

                        </div>

                        <!-- STEP -->
                        <div class="relative z-10 flex justify-between">

                            @foreach ($steps as $index => $step)
                                @php
                                    $number = $index + 1;
                                    $completed = $number < $currentStep;
                                    $active = $number == $currentStep;
                                @endphp

                                <div class="flex flex-col items-center w-16">

                                    <!-- ICON -->
                                    <div
                                        class="w-8 h-8 rounded-full border-2 bg-white flex items-center justify-center transition-all duration-300

                                        @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }}

                                        @elseif($active)

                                            {{ $isRejected
                                                ? 'bg-red-500 border-red-500 text-white'
                                                : ($emailPribadi->status == 'selesai'
                                                    ? 'bg-green-500 border-green-500 text-white'
                                                    : 'bg-yellow-500 border-yellow-500 text-white') }}

                                        @else

                                            border-gray-300 text-gray-400 @endif">

                                        @if ($completed)
                                            <span class="material-symbols-outlined text-[16px]">
                                                check
                                            </span>
                                        @elseif($active)
                                            <span
                                                class="material-symbols-outlined text-[16px] {{ $emailPribadi->status == 'diproses' ? 'animate-spin' : '' }}">
                                                {{ $icons[$index] }}
                                            </span>
                                        @elseif($isRejected && $number == $totalSteps)
                                            <span class="material-symbols-outlined text-[16px]">
                                                close
                                            </span>
                                        @else
                                            <span class="material-symbols-outlined text-[16px]">
                                                {{ $icons[$index] }}
                                            </span>
                                        @endif

                                    </div>

                                    <!-- LABEL -->
                                    <p
                                        class="mt-3
                                            text-[10px]
                                            leading-3
                                            text-center
                                            min-h-[28px]

                                        @if ($active && $isRejected) text-red-600 font-semibold

                                        @elseif($number <= $currentStep)

                                            text-primary font-semibold

                                        @else

                                            text-gray-500 @endif">

                                        {{ $step }}

                                    </p>

                                </div>
                            @endforeach

                        </div>

                    </div>
                </article>


                <!-- DESKTOP ARTICLE - EMAIL PRIBADI -->
                <article
                    class="hidden md:flex bg-surface rounded-xl border border-border-subtle p-6 flex-col gap-8 relative overflow-hidden transition-all duration-300 hover:shadow-[0_4px_12px_rgba(0,30,64,0.04)]">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $isRejected ? 'bg-red-500' : ($emailPribadi->status == 'selesai' ? 'bg-green-500' : 'bg-blue-500') }}">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-surface-container-low text-primary text-label-sm font-label-sm px-2 py-0.5 rounded border border-border-subtle">{{ $emailPribadi->nomor_tiket }}</span>
                                @switch($emailPribadi->status)
                                    @case('terbuka')
                                        <span
                                            class="bg-blue-100 text-blue-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-blue-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">description</span>Pengajuan</span>
                                    @break

                                    @case('baru')
                                        <span
                                            class="bg-gray-100 text-gray-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-gray-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">fact_check</span>Pemeriksaan
                                            Dokumen</span>
                                    @break

                                    @case('tunda')
                                        <span
                                            class="bg-orange-100 text-orange-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-orange-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">approval</span>Persetujuan
                                            Pimpinan</span>
                                    @break

                                    @case('diproses')
                                        <span
                                            class="bg-secondary-container/30 text-on-secondary-container text-label-sm font-label-sm px-2 py-0.5 rounded border border-secondary-container/50 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">pending</span>Proses
                                            Pembuatan</span>
                                    @break

                                    @case('selesai')
                                        <span
                                            class="bg-success-emerald/10 text-success-emerald text-label-sm font-label-sm px-2 py-0.5 rounded border border-success-emerald/20 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">check_circle</span>Selesai</span>
                                    @break

                                    @case('tutup')
                                        <span
                                            class="bg-red-100 text-red-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-red-200 flex items-center gap-1"><span
                                                class="material-symbols-outlined text-[14px]">cancel</span>Pengajuan
                                            Dicancel</span>
                                    @break
                                @endswitch
                            </div>
                            <h3 class="text-headline-md font-headline-md text-primary">Pengajuan Email Pribadi
                                @murungrayakab.go.id</h3>
                            <p class="text-label-sm font-label-sm text-on-surface-variant mt-1">Diajukan:
                                {{ $emailPribadi->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="relative mt-6">
                        <div class="absolute top-5 left-5 right-5 h-1 bg-gray-200"></div>
                        <div class="absolute top-5 left-5 h-1 {{ $isRejected ? 'bg-red-500' : 'bg-blue-500' }}"
                            style="width: {{ (($currentStep - 1) / (count($steps) - 1)) * 100 }}%;"></div>
                        <div class="flex justify-between relative z-10">
                            @foreach ($steps as $index => $step)
                                @php
                                    $number = $index + 1;
                                    $completed = $number < $currentStep;
                                    $active = $number == $currentStep;
                                @endphp
                                <div class="flex flex-col items-center flex-1">
                                    <div
                                        class="w-8 h-8 rounded-full border-2 border-surface flex items-center justify-center shrink-0 @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }} @elseif($active) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : ($emailPribadi->status == 'selesai' ? 'bg-green-500 border-green-500 text-white' : 'bg-yellow-500 border-yellow-500 text-white') }} @else bg-white border-gray-300 text-gray-400 @endif">
                                        @if ($completed)
                                            <span class="material-symbols-outlined text-[16px]">check</span>
                                        @elseif($active)
                                            <span
                                                class="material-symbols-outlined text-[16px] {{ $emailPribadi->status == 'diproses' ? 'animate-spin' : '' }}">{{ $icons[$index] }}</span>
                                        @elseif($isRejected && $number == count($steps))
                                            <span class="material-symbols-outlined text-[16px]">close</span>
                                        @else
                                            <span
                                                class="material-symbols-outlined text-[16px]">{{ $icons[$index] }}</span>
                                        @endif
                                    </div>
                                    <p
                                        class="text-label-sm font-label-sm text-center mt-2 @if ($active && $isRejected) text-red-600 font-semibold @elseif($number <= $currentStep) text-primary font-semibold @else text-gray-500 @endif">
                                        {{ $step }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            @else
                <!-- MOBILE ERROR STATE -->
                <div class="md:hidden w-full py-5 px-2">
                    <div class="rounded-2xl border border-border-subtle bg-white shadow-sm p-8 text-center">
                        <span class="material-symbols-outlined text-6xl text-red-500">error</span>
                        <h2 class="mt-4 text-2xl font-bold text-primary">Nomor Tiket Tidak Ditemukan</h2>
                        <p class="mt-2 text-sm text-gray-600">Pastikan nomor tiket yang Anda masukkan sudah benar.</p>
                        <a href="{{ route('status') }}"
                            class="mt-5 w-full flex justify-center items-center rounded-xl bg-primary py-3 min-h-[48px] font-semibold text-white shadow-md active:scale-[0.98] transition-all">
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- DESKTOP ERROR STATE -->
                <div class="hidden md:block max-w-5xl mx-auto py-10">
                    <div class="rounded-3xl border p-12 bg-white text-center">
                        <span class="material-symbols-outlined text-7xl text-red-500">error</span>
                        <h2 class="mt-5 text-3xl font-bold">Nomor Tiket Tidak Ditemukan</h2>
                        <p class="mt-3 text-gray-600">Pastikan nomor tiket yang Anda masukkan sudah benar.</p>
                        <a href="{{ route('status') }}"
                            class="inline-flex mt-8 rounded-xl bg-primary text-white px-6 py-3 hover:opacity-90 transition">
                            Kembali
                        </a>
                    </div>
                </div>
            @endif

            @if ($subdomain || $emailSatker || $emailPribadi)
                <!-- MOBILE BACK BUTTON -->
                <div class="md:hidden mt-8 flex w-full">
                    <a href="{{ route('status') }}"
                        class="w-full flex justify-center items-center gap-2 px-6 py-3 min-h-[48px] rounded-xl bg-primary text-white font-medium shadow-md active:scale-[0.98] transition-all">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- DESKTOP BACK BUTTON -->
                <div class="hidden md:flex mt-8 justify-start">
                    <a href="{{ route('status') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-white font-medium shadow-sm transition-all duration-200 hover:bg-primary/90 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/30 hover:opacity-90 transition">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        <span>Kembali</span>
                    </a>
                </div>
            @endif

        </div>
    </section>
</x-public-layout>
