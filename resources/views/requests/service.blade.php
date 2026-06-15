<x-app-layout>
    <div class="flex-1 p-margin-mobile md:p-margin-desktop max-w-container-max mx-auto relative z-10 flex flex-col gap-8">
        <div class="mb-8">
            <h2 class="text-headline-md font-headline-md md:text-headline-lg md:font-headline-lg text-on-surface">Formulir Layanan KOMINFO</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mt-2">Lengkapi tahapan di bawah untuk mengajukan layanan Subdomain atau Email Kedinasan.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-error-container text-on-error-container p-4 rounded-lg border border-error flex items-start gap-3 animate-pulse">
                <span class="material-symbols-outlined text-[24px]">error</span>
                <div>
                    <p class="font-bold">Terjadi kesalahan saat pengajuan:</p>
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Stepper -->
        <div class="mb-10">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-[2px] bg-border-subtle z-0"></div>
                <div class="relative z-10 flex flex-col items-center group cursor-default">
                    <div class="w-10 h-10 rounded-full bg-status-pending text-on-secondary flex items-center justify-center border-4 border-surface-gray transition-colors" id="step-circle-1">
                        <span class="text-label-md font-label-md">1</span>
                    </div>
                    <span class="mt-2 text-label-sm font-label-sm text-on-surface font-bold">Layanan</span>
                </div>
                <div class="relative z-10 flex flex-col items-center group cursor-default">
                    <div class="w-10 h-10 rounded-full bg-surface text-on-surface-variant border-2 border-border-subtle flex items-center justify-center transition-colors" id="step-circle-2">
                        <span class="text-label-md font-label-md">2</span>
                    </div>
                    <span class="mt-2 text-label-sm font-label-sm text-on-surface-variant">Data Pemohon</span>
                </div>
                <div class="relative z-10 flex flex-col items-center group cursor-default">
                    <div class="w-10 h-10 rounded-full bg-surface text-on-surface-variant border-2 border-border-subtle flex items-center justify-center transition-colors" id="step-circle-3">
                        <span class="text-label-md font-label-md">3</span>
                    </div>
                    <span class="mt-2 text-label-sm font-label-sm text-on-surface-variant">Detail & Dokumen</span>
                </div>
            </div>
        </div>

        <!-- Form Card Container -->
        <div class="bg-surface border border-border-subtle rounded-xl shadow-sm overflow-hidden">
            <form method="POST" action="{{ route('requests.store') }}" enctype="multipart/form-data" class="p-6 md:p-8" id="multi-step-form">
                @csrf
                <!-- Step 1: Service Selection -->
                <div class="block animate-fade-in" id="step-content-1">
                    <h3 class="text-headline-md font-headline-md mb-6">Pilih Jenis Layanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Subdomain -->
                        <label class="cursor-pointer">
                            <input class="peer sr-only service-type-input" name="type" type="radio" value="subdomain" required>
                            <div class="p-6 border-2 border-border-subtle rounded-xl peer-checked:border-primary peer-checked:bg-primary-fixed/20 hover:border-outline-variant transition-all h-full flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4 text-primary">
                                    <span class="material-symbols-outlined text-[32px]">language</span>
                                </div>
                                <h4 class="text-label-md font-label-md text-on-surface">Subdomain</h4>
                                <p class="text-caption font-caption text-on-surface-variant mt-2">Pembuatan alamat website unit kerja (misal: dinas.murungrayakab.go.id).</p>
                            </div>
                        </label>
                        <!-- Email Pribadi -->
                        <label class="cursor-pointer">
                            <input class="peer sr-only service-type-input" name="type" type="radio" value="email_pribadi">
                            <div class="p-6 border-2 border-border-subtle rounded-xl peer-checked:border-primary peer-checked:bg-primary-fixed/20 hover:border-outline-variant transition-all h-full flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4 text-primary">
                                    <span class="material-symbols-outlined text-[32px]">person</span>
                                </div>
                                <h4 class="text-label-md font-label-md text-on-surface">Email Pribadi</h4>
                                <p class="text-caption font-caption text-on-surface-variant mt-2">Email resmi ASN (@murungrayakab.go.id) untuk kebutuhan individu.</p>
                            </div>
                        </label>
                        <!-- Email Satker -->
                        <label class="cursor-pointer">
                            <input class="peer sr-only service-type-input" name="type" type="radio" value="email_satker">
                            <div class="p-6 border-2 border-border-subtle rounded-xl peer-checked:border-primary peer-checked:bg-primary-fixed/20 hover:border-outline-variant transition-all h-full flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4 text-primary">
                                    <span class="material-symbols-outlined text-[32px]">corporate_fare</span>
                                </div>
                                <h4 class="text-label-md font-label-md text-on-surface">Email Satker</h4>
                                <p class="text-caption font-caption text-on-surface-variant mt-2">Email resmi untuk unit kerja/satker (@murungrayakab.go.id).</p>
                            </div>
                        </label>
                    </div>
                    @error('type') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Step 2: Common User Details -->
                <div class="hidden animate-fade-in" id="step-content-2">
                    <h3 class="text-headline-md font-headline-md mb-6">Informasi Pemohon</h3>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-label-md font-label-md text-on-surface mb-1">Nama Lengkap Pemohon</label>
                            <input class="w-full px-4 py-2 bg-surface border border-border-subtle rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow text-body-md" name="details[nama_pemohon]" placeholder="Masukkan nama lengkap" type="text">
                        </div>
                        <div>
                            <label class="block text-label-md font-label-md text-on-surface mb-1">Alasan Pengajuan <span class="text-error">*</span></label>
                            <textarea class="w-full px-4 py-2 bg-surface border border-border-subtle rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow text-body-md min-h-[100px]" name="reason" placeholder="Jelaskan alasan kebutuhan layanan ini secara detail (min 10 karakter)" required></textarea>
                            @error('reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 3: Service Specific Details -->
                <div class="hidden animate-fade-in" id="step-content-3">
                    <div id="step-3-header" class="mb-6">
                        <h3 class="text-headline-md font-headline-md">Detail Layanan & Dokumen</h3>
                    </div>

                    <!-- Subdomain Form -->
                    <div id="form-subdomain" class="hidden space-y-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">Nama Subdomain <span class="text-error">*</span></label>
                            <div class="flex">
                                <input class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[proposed_subdomain]" placeholder="misal: dpmptsp" required type="text">
                                <span class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg text-label-md text-on-surface-variant">.murungrayakab.go.id</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Nama PJ Teknis <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[pic_name]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Kontak PJ (WhatsApp) <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[pic_contact]" required type="text">
                            </div>
                        </div>
                    </div>

                    <!-- Email Pribadi Form -->
                    <div id="form-email_pribadi" class="hidden space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nama]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">NIP <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nip]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Jabatan <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[jabatan]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Instansi <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[instansi]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Email Pribadi <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[email]" required type="email">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">No. HP WA Aktif <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[no_hp_wa]" required type="text">
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-label-md font-label-md text-on-surface">Nama Akun yang Diinginkan <span class="text-error">*</span></label>
                            <div class="flex">
                                <input class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nama_akun]" placeholder="nama.pegawai" required type="text">
                                <span class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg text-label-md text-on-surface-variant">@murungrayakab.go.id</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Jenis Layanan <span class="text-error">*</span></label>
                                <select class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[jenis_layanan]" required>
                                    <option value="baru">Permohonan Baru</option>
                                    <option value="reset">Reset Password</option>
                                    <option value="hapus">Hapus Akun</option>
                                    <option value="ganti">Ganti Nama Akun</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Pengajuan Untuk <span class="text-error">*</span></label>
                                <select class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[pengajuan_untuk]" required>
                                    <option value="diri_sendiri">Diri Sendiri</option>
                                    <option value="orang_lain">Orang Lain</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Email Satker Form -->
                    <div id="form-email_satker" class="hidden space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Nama Instansi <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nama_instansi]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Nama Akun Dinas <span class="text-error">*</span></label>
                                <div class="flex">
                                    <input class="flex-grow px-4 py-3 bg-surface border border-outline-variant rounded-l-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nama_akun]" placeholder="nama.satker" required type="text">
                                    <span class="px-4 py-3 bg-surface-container border border-l-0 border-outline-variant rounded-r-lg text-label-md text-on-surface-variant">@murungrayakab.go.id</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Nama Penanggung Jawab <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nama_pj]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">NIP PJ <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[nip]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Jabatan PJ <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[jabatan]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Email Pribadi PJ <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[email_pribadi]" required type="email">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">No. HP WA Aktif PJ <span class="text-error">*</span></label>
                                <input class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[no_hp_wa]" required type="text">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-label-md font-label-md text-on-surface">Jenis Layanan <span class="text-error">*</span></label>
                                <select class="w-full px-4 py-3 bg-surface border border-outline-variant rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" name="details[jenis_layanan]" required>
                                    <option value="reset">Reset Password</option>
                                    <option value="ganti">Ganti Nama Akun</option>
                                    <option value="pj">Pergantian Penanggung Jawab</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Common Upload Section -->
                    <div class="mt-10 flex flex-col gap-2">
                        <label class="text-label-md font-label-md text-on-surface">Upload Dokumen Pendukung (SK/Surat Permohonan) <span class="text-error">*</span></label>
                        <div class="border-2 border-dashed border-outline-variant hover:border-primary bg-surface hover:bg-surface-container-low transition-colors rounded-xl p-8 flex flex-col items-center justify-center gap-4 cursor-pointer group" id="drop-zone-common">
                            <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center group-hover:bg-primary-fixed transition-colors">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                            </div>
                            <div class="text-center">
                                <p class="text-body-md font-body-md text-on-surface mb-1">Tarik &amp; lepas file di sini, atau <span class="text-primary font-semibold hover:underline">klik untuk memilih</span></p>
                                <p class="text-caption font-caption text-on-surface-variant">Format yang didukung: PDF, JPG, PNG (Maks. 5MB)</p>
                            </div>
                            <input accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="file-upload-common" name="document" required type="file">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 pt-6 border-t border-border-subtle flex justify-between items-center">
            <button class="invisible px-6 py-2 rounded-lg text-primary text-label-md font-label-md hover:bg-surface-container transition-colors" id="btn-prev" type="button">
                Kembali
            </button>
            <button class="px-6 py-2 rounded-lg bg-primary text-on-primary text-label-md font-label-md hover:bg-primary-container transition-colors shadow-sm" id="btn-next" type="button">
                Lanjut
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentStep = 1;
            const totalSteps = 3;
            
            const btnNext = document.getElementById('btn-next');
            const btnPrev = document.getElementById('btn-prev');
            const form = document.getElementById('multi-step-form');
            
            const updateStep3Layout = () => {
                const typeInput = document.querySelector('input[name="type"]:checked');
                const forms = {
                    'subdomain': document.getElementById('form-subdomain'),
                    'email_pribadi': document.getElementById('form-email_pribadi'),
                    'email_satker': document.getElementById('form-email_satker')
                };
                const header = document.getElementById('step-3-header');
                
                if (!typeInput) return;

                // Hide all
                Object.values(forms).forEach(f => f.classList.add('hidden'));

                // Show selected
                const selectedForm = forms[typeInput.value];
                if (selectedForm) {
                    selectedForm.classList.remove('hidden');
                }

                const titles = {
                    'subdomain': 'Detail Pengajuan Subdomain',
                    'email_pribadi': 'Detail Pengajuan Email Pribadi',
                    'email_satker': 'Detail Pengajuan Email Satker'
                };
                header.innerHTML = '<h3 class="text-headline-md font-headline-md">' + (titles[typeInput.value] || 'Detail Layanan') + '</h3>';
            };

            document.querySelectorAll('.service-type-input').forEach(input => {
                input.addEventListener('change', updateStep3Layout);
            });

            const updateUI = () => {
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
                
                if (currentStep === 3) {
                    updateStep3Layout();
                }

                for (let i = 1; i <= totalSteps; i++) {
                    const circle = document.getElementById(`step-circle-${i}`);
                    const label = circle.nextElementSibling;
                    circle.className = "w-10 h-10 rounded-full flex items-center justify-center transition-colors";
                    label.className = "mt-2 text-label-sm font-label-sm";
                    if (i < currentStep) {
                        circle.classList.add('bg-primary', 'text-on-primary', 'border-4', 'border-surface-gray');
                        circle.innerHTML = '<span class="material-symbols-outlined text-[20px]">check</span>';
                        label.classList.add('text-primary');
                    } else if (i === currentStep) {
                        circle.classList.add('bg-status-pending', 'text-on-secondary', 'border-4', 'border-surface-gray');
                        circle.innerHTML = `<span class="text-label-md font-label-md">${i}</span>`;
                        label.classList.add('text-on-surface', 'font-bold');
                    } else {
                        circle.classList.add('bg-surface', 'text-on-surface-variant', 'border-2', 'border-border-subtle');
                        circle.innerHTML = `<span class="text-label-md font-label-md">${i}</span>`;
                        label.classList.add('text-on-surface-variant');
                    }
                }

                if (currentStep === 1) {
                    btnPrev.classList.add('invisible');
                } else {
                    btnPrev.classList.remove('invisible');
                }

                if (currentStep === totalSteps) {
                    btnNext.textContent = 'Kirim Pengajuan';
                } else {
                    btnNext.textContent = 'Lanjut';
                }
            };

            btnNext.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    if (currentStep === 1) {
                        const typeSelected = document.querySelector('input[name="type"]:checked');
                        if (!typeSelected) {
                            alert('Silakan pilih jenis layanan terlebih dahulu.');
                            return;
                        }
                    }
                    if (currentStep === 2) {
                        const inputs = document.querySelectorAll('#step-content-2 input, #step-content-2 textarea');
                        let isValid = true;
                        inputs.forEach(input => {
                            if (!input.checkValidity()) {
                                input.reportValidity();
                                isValid = false;
                            }
                        });
                        if (!isValid) return;
                    }
                    currentStep++;
                    updateUI();
                } else {
                    // Final validation for Step 3
                    const activeFormId = document.querySelector('input[name="type"]:checked').value === 'subdomain' ? 'form-subdomain' : 
                                      (document.querySelector('input[name="type"]:checked').value === 'email_pribadi' ? 'form-email_pribadi' : 'form-email_satker');
                    const step3Inputs = document.querySelectorAll(`#${activeFormId} input, #${activeFormId} select`);
                    let isValid = true;
                    step3Inputs.forEach(input => {
                        if (!input.checkValidity()) {
                            input.reportValidity();
                            isValid = false;
                        }
                    });
                    
                    const docInput = document.getElementById('file-upload-common');
                    if(!docInput.value) {
                        alert('Silakan upload dokumen pendukung terlebih dahulu.');
                        isValid = false;
                    }

                    if (isValid) {
                        form.submit();
                    }
                }
            });

            btnPrev.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                }
            });

            updateUI();
        });

        const dropZoneCommon = document.getElementById('drop-zone-common');
        const fileInputCommon = document.getElementById('file-upload-common');
        if(dropZoneCommon) {
            dropZoneCommon.addEventListener('click', () => fileInputCommon.click());
        }
    </script>
    @endpush
</x-app-layout>
