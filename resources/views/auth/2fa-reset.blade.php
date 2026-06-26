<x-guest-layout>
    <x-validation-errors class="mb-4" />

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-success-emerald bg-surface-container-low p-3 rounded-lg border border-border-subtle flex items-start gap-2">
            <span class="material-symbols-outlined shrink-0" style="font-size: 18px;">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-container text-on-primary-container mb-3">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">lock_reset</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900">Reset Two-Factor Authentication</h3>
        <p class="text-sm text-gray-600 mt-1">Masukkan email Anda untuk menerima kode OTP reset 2FA.</p>
    </div>

    <form method="POST" action="{{ route('2fa.reset.send-email') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="masukkan email anda">
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full py-3 px-4 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container transition-colors shadow-sm">
            Kirim Kode OTP
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">Kembali ke halaman login</a>
    </div>
</x-guest-layout>
