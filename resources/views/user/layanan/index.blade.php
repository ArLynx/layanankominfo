@extends('user.layouts.app')

@section('content')
    <div class="flex-1 p-margin-mobile md:p-margin-desktop max-w-container-max w-full mx-auto">
        <div class="mb-8">
            <h2 class="text-headline-md font-headline-md md:text-headline-lg md:font-headline-lg text-on-surface">Formulir
                Layanan</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-2">Lengkapi tahapan di bawah untuk mengajukan
                pembuatan Subdomain atau Email instansi.</p>
        </div>
        <!-- Stepper -->
        <div class="mb-10">
            <div class="flex items-center justify-between relative">
                <!-- Connecting Line -->
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-[2px] bg-border-subtle z-0"></div>
                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center group cursor-default">
                    <div class="w-10 h-10 rounded-full bg-status-pending text-on-secondary flex items-center justify-center border-4 border-surface-gray transition-colors"
                        id="step-circle-1">
                        <span class="text-label-md font-label-md">1</span>
                    </div>
                    <span class="mt-2 text-label-sm font-label-sm text-on-surface font-bold">Pilih Layanan</span>
                </div>
                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center group cursor-default">
                    <div class="w-10 h-10 rounded-full bg-surface text-on-surface-variant border-2 border-border-subtle flex items-center justify-center transition-colors"
                        id="step-circle-2">
                        <span class="text-label-md font-label-md">2</span>
                    </div>
                    <span class="mt-2 text-label-sm font-label-sm text-on-surface-variant">Data Pemohon</span>
                </div>
                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center group cursor-default">
                    <div class="w-10 h-10 rounded-full bg-surface text-on-surface-variant border-2 border-border-subtle flex items-center justify-center transition-colors"
                        id="step-circle-3">
                        <span class="text-label-md font-label-md">3</span>
                    </div>
                    <span class="mt-2 text-label-sm font-label-sm text-on-surface-variant">Detail &amp; Dokumen</span>
                </div>
            </div>
        </div>
        <!-- Form Card Container -->
        <div class="bg-surface border border-border-subtle rounded-xl shadow-sm overflow-hidden">
            <form class="p-6 md:p-8" id="multi-step-form">
                <!-- Step 1: Service Selection -->
                <div class="block animate-fade-in" id="step-content-1">
                    <h3 class="text-headline-md font-headline-md mb-6">Pilih Jenis Layanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Subdomain -->
                        <label class="cursor-pointer">
                            <a href="{{ route('subdomain.create') }}" class="block">
                                <div
                                    class="p-6 border-2 border-border-subtle rounded-xl hover:border-primary hover:bg-primary-fixed/20 transition-all h-full flex flex-col items-center text-center">

                                    <div
                                        class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4 text-primary">
                                        <span class="material-symbols-outlined text-[32px]">language</span>
                                    </div>

                                    <h4 class="text-label-md font-label-md text-on-surface">
                                        Subdomain
                                    </h4>

                                    <p class="text-caption font-caption text-on-surface-variant mt-2">
                                        Untuk website unit kerja atau program khusus.
                                    </p>
                                </div>
                            </a>
                        </label>

                        <!-- Email Pribadi -->
                        <label class="cursor-pointer">
                            <a href="{{ route('email-pribadi.create') }}" class="block">
                                <div
                                    class="p-6 border-2 border-border-subtle rounded-xl peer-checked:border-primary peer-checked:bg-primary-fixed/20 hover:border-outline-variant transition-all h-full flex flex-col items-center text-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4 text-primary">
                                        <span class="material-symbols-outlined text-[32px]">mail</span>
                                    </div>
                                    <h4 class="text-label-md font-label-md text-on-surface">Email Kedinasan (Personal)</h4>
                                    <p class="text-caption font-caption text-on-surface-variant mt-2">Alamat email resmi
                                        dengan
                                        domain @murungrayakab.go.id untuk ASN.</p>
                                </div>
                        </label>

                        <!-- Email Satker -->
                        <label class="cursor-pointer">
                            <a href="{{ route('email-satker.create') }}" class="block">
                                <div
                                    class="p-6 border-2 border-border-subtle rounded-xl peer-checked:border-primary peer-checked:bg-primary-fixed/20 hover:border-outline-variant transition-all h-full flex flex-col items-center text-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4 text-primary">
                                        <span class="material-symbols-outlined text-[32px]">corporate_fare</span>
                                    </div>
                                    <h4 class="text-label-md font-label-md text-on-surface">Email Satker</h4>
                                    <p class="text-caption font-caption text-on-surface-variant mt-2">Email resmi untuk unit
                                        kerja/satker (@murungrayakab.go.id).</p>
                                </div>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
            </form>
        </div>
    </div>

    <!-- Script for Stepper Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentStep = 1;
            const totalSteps = 3;

            const btnNext = document.getElementById('btn-next');
            const btnPrev = document.getElementById('btn-prev');

            const updateUI = () => {
                // Update Content Visibility
                for (let i = 1; i <= totalSteps; i++) {
                    const content = document.getElementById(`step-content-${i}`);
                    if (i === currentStep) {
                        content.classList.remove('hidden');
                        content.classList.add('block');
                    } else {
                        content.classList.remove('block');
                        content.classList.add('hidden');
                    }
                }

                // Update Stepper Visuals
                for (let i = 1; i <= totalSteps; i++) {
                    const circle = document.getElementById(`step-circle-${i}`);
                    const label = circle.nextElementSibling;

                    // Reset classes
                    circle.className =
                        "w-10 h-10 rounded-full flex items-center justify-center transition-colors";
                    label.className = "mt-2 text-label-sm font-label-sm";

                    if (i < currentStep) {
                        // Completed
                        circle.classList.add('bg-primary', 'text-on-primary', 'border-4',
                            'border-surface-gray');
                        circle.innerHTML = '<span class="material-symbols-outlined text-[20px]">check</span>';
                        label.classList.add('text-primary');
                    } else if (i === currentStep) {
                        // Active (Gold/Pending status color based on design guidelines)
                        circle.classList.add('bg-status-pending', 'text-on-secondary', 'border-4',
                            'border-surface-gray');
                        circle.innerHTML = `<span class="text-label-md font-label-md">${i}</span>`;
                        label.classList.add('text-on-surface', 'font-bold');
                    } else {
                        // Upcoming
                        circle.classList.add('bg-surface', 'text-on-surface-variant', 'border-2',
                            'border-border-subtle');
                        circle.innerHTML = `<span class="text-label-md font-label-md">${i}</span>`;
                        label.classList.add('text-on-surface-variant');
                    }
                }

                // Update Buttons
                if (currentStep === 1) {
                    btnPrev.classList.add('invisible');
                } else {
                    btnPrev.classList.remove('invisible');
                }

                if (currentStep === totalSteps) {
                    btnNext.textContent = 'Kirim Pengajuan';
                    // Here you would change type to submit or handle form submission logic
                } else {
                    btnNext.textContent = 'Lanjut';
                }
            };

            btnNext.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateUI();
                } else {
                    alert('Form Submitted successfully! (Simulation)');
                    // Reset for demo purposes
                    currentStep = 1;
                    updateUI();
                }
            });

            btnPrev.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                }
            });

            // Initial UI Setup
            updateUI();
        });
    </script>
@endsection
