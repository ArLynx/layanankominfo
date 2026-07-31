<x-guest-layout>
    <div class="flex flex-col items-center text-center gap-2 mb-6">
        <div class="h-16 w-16 bg-surface-container rounded-full flex items-center justify-center mb-2 border border-border-subtle">
            <span class="material-symbols-outlined text-primary"
                style="font-size: 32px; font-variation-settings: 'FILL' 1;">verified_user</span>
        </div>
        <h1 class="font-headline-md text-headline-md text-primary">Verifikasi OTP</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Masukkan 6 digit kode OTP yang dikirim ke email Anda.
        </p>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('admin.2fa.reset.verify') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
            <input type="text" id="otp" name="otp" maxlength="6" required autofocus autocomplete="off"
                inputmode="numeric"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant tracking-widest text-center text-lg"
                placeholder="••••••">
            @error('otp')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full py-3 px-4 flex items-center justify-center space-x-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <span>Verifikasi & Reset 2FA</span>
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
            </button>
        </div>
    </form>

    <div class="text-center mt-6 pt-4 border-t border-border-subtle">
        <a href="{{ route('admin.login') }}"
            class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors inline-flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke halaman login admin
        </a>
    </div>
</x-guest-layout>