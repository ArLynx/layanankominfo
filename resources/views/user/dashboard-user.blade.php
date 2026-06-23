@extends('user.layouts.app')

@section('content')
    <header
        class="md:hidden fixed top-0 w-full z-50 bg-surface border-b border-border-subtle flex justify-between items-center px-margin-mobile py-4 shadow-sm">
        <div class="flex items-center gap-3">
            <button class="text-primary p-1">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>
            <span class="text-headline-lg-mobile font-headline-lg-mobile text-primary">Dinas Kominfo</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-surface-container-high overflow-hidden border border-border-subtle">
            <!-- Placeholder Avatar -->
        </div>
    </header>
    <!-- Subtle Background Pattern/Gradient -->
    <div
        class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-surface-container-highest/40 via-transparent to-transparent opacity-50">
    </div>

    <div class="p-margin-mobile md:p-margin-desktop max-w-container-max mx-auto relative z-10 flex flex-col gap-8">
        <!-- Page Header -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-border-subtle pb-6">
            <div>
                <h2
                    class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                    Status Pengajuan</h2>
                <p class="text-body-md font-body-md text-on-surface-variant">Pantau progres layanan administratif
                    Anda saat ini.</p>
                <h2>Selamat Datang, {{ $user->name }}</h2>
            </div>
        </header>
        <div class="bg-primary-container/10 border-l-4 border-primary p-4 rounded-r-lg mb-4">
            <div class="flex gap-3"><span class="material-symbols-outlined text-primary">info</span>
                <p class="text-label-md text-primary font-medium">Kebijakan Layanan: Subdomain dan email di bawah
                    domain murungrayakab.go.id hanya tersedia untuk Dinas/Unit Kerja di lingkungan Pemerintah
                    Kabupaten Murung Raya. Layanan untuk tingkat Desa tidak tersedia melalui jalur ini.</p>
            </div>
        </div>

        <section class="flex flex-col gap-6">

            @if ($subdomains->count())
                @foreach ($subdomains as $subdomain)
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

                    <!-- Card Line -->

                    <!--SUbdomain Line -->
                    <article
                        class="bg-surface rounded-xl border border-border-subtle p-6 flex flex-col gap-8 relative overflow-hidden transition-all duration-300 hover:shadow-[0_4px_12px_rgba(0,30,64,0.04)]">

                        {{-- garis kiri --}}
                        <div
                            class="absolute left-0 top-0 bottom-0 w-1
        {{ $isRejected ? 'bg-red-500' : ($subdomain->status == 'selesai' ? 'bg-green-500' : 'bg-yellow-500') }}">
                        </div>

                        <div class="flex justify-between items-start">

                            <div>

                                <div class="flex items-center gap-2 mb-2">

                                    <span
                                        class="bg-surface-container-low text-primary text-label-sm font-label-sm px-2 py-0.5 rounded border border-border-subtle">
                                        {{ $subdomain->nomor_tiket }}
                                    </span>

                                    @switch($subdomain->status)
                                        @case('terbuka')
                                            <span
                                                class="bg-blue-100 text-blue-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-blue-200 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    description
                                                </span>
                                                Pengajuan
                                            </span>
                                        @break

                                        @case('baru')
                                            <span
                                                class="bg-gray-100 text-gray-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-gray-200 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    fact_check
                                                </span>
                                                Pemeriksaan Dokumen
                                            </span>
                                        @break

                                        @case('tunda')
                                            <span
                                                class="bg-orange-100 text-orange-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-orange-200 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    approval
                                                </span>
                                                Persetujuan Pimpinan
                                            </span>
                                        @break

                                        @case('diproses')
                                            <span
                                                class="bg-secondary-container/30 text-on-secondary-container text-label-sm font-label-sm px-2 py-0.5 rounded border border-secondary-container/50 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    pending
                                                </span>
                                                Proses Pembuatan
                                            </span>
                                        @break

                                        @case('selesai')
                                            <span
                                                class="bg-success-emerald/10 text-success-emerald text-label-sm font-label-sm px-2 py-0.5 rounded border border-success-emerald/20 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    check_circle
                                                </span>
                                                Selesai
                                            </span>
                                        @break

                                        @case('tutup')
                                            <span
                                                class="bg-red-100 text-red-700 text-label-sm font-label-sm px-2 py-0.5 rounded border border-red-200 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    cancel
                                                </span>
                                                Pengajuan Dicancel
                                            </span>
                                        @break
                                    @endswitch

                                </div>

                                <h3 class="text-headline-md font-headline-md text-primary">
                                    Pengajuan Subdomain Dinas/Unit Kerja @murungrayakab.go.id
                                </h3>

                                <p class="text-label-sm font-label-sm text-on-surface-variant mt-1">
                                    Diajukan:
                                    {{ $subdomain->created_at->format('d M Y') }}
                                </p>

                            </div>

                            <a href="{{ route('subdomain.show', $subdomain->id) }}"
                                class="bg-primary text-on-primary text-label-md font-label-md px-5 py-2.5 rounded-lg shadow-sm hover:bg-primary-container transition-colors">

                                Detail

                            </a>

                        </div>

                        {{-- TRACKER --}}
                        <div class="relative mt-6">

                            <div class="absolute top-5 left-5 right-5 h-1 bg-gray-200"></div>

                            <div class="absolute top-5 left-5 h-1
                {{ $isRejected ? 'bg-red-500' : 'bg-blue-500' }}"
                                style="width: {{ (($currentStep - 1) / 4) * 100 }}%;">
                            </div>

                            <div class="flex justify-between relative z-10">

                                @foreach ($steps as $index => $step)
                                    @php
                                        $number = $index + 1;
                                        $completed = $number < $currentStep;
                                        $active = $number == $currentStep;
                                    @endphp

                                    <div class="flex flex-col items-center w-1/5">

                                        <div
                                            class="w-8 h-8 rounded-full border-2 border-surface flex items-center justify-center shrink-0

                        @if ($completed) {{ $isRejected ? 'bg-red-500 border-red-500 text-white' : 'bg-blue-500 border-blue-500 text-white' }}

                        @elseif($active)

                            @if ($isRejected)
                                bg-red-500 border-red-500 text-white
                            @else
                                bg-yellow-500 border-yellow-500 text-white @endif
@else
bg-white border-gray-300 text-gray-400
@endif
                            ">

                                            @if ($completed)

                                                <span class="material-symbols-outlined text-[16px]">
                                                    check
                                                </span>
                                            @elseif($active)
                                                <span
                                                    class="material-symbols-outlined text-[16px]
        {{ $subdomain->status == 'diproses' ? 'animate-spin' : '' }}">
                                                    {{ $icons[$index] }}
                                                </span>
                                            @elseif($isRejected && $number == 5)
                                                <span class="material-symbols-outlined text-[16px]">
                                                    close
                                                </span>
                                            @else
                                                <span class="material-symbols-outlined text-[16px]">
                                                    {{ $icons[$index] }}
                                                </span>

                                            @endif

                                        </div>

                                        <p
                                            class="text-label-sm font-label-sm text-center mt-2

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
                @endforeach
            @else
                <div class="bg-surface rounded-xl border border-border-subtle p-12 text-center">

                    <span class="material-symbols-outlined text-[72px] text-outline mb-4">
                        assignment_late
                    </span>

                    <h3 class="text-headline-md font-headline-md text-primary mb-2">
                        Belum Ada Pengajuan
                    </h3>

                    <p class="text-body-md font-body-md text-on-surface-variant mb-6">
                        Anda belum mengajukan permohonan layanan apapun.
                    </p>

                    <a href="{{ route('jenis-layanan') }}"
                        class="bg-primary text-on-primary px-6 py-3 rounded-lg text-label-lg font-label-lg">

                        Buat Pengajuan Sekarang

                    </a>

                </div>

            @endif

        </section>
    </div>
@endsection
