<x-simple-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-container text-on-primary-container mb-4">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">lock_reset</span>
        </div>
        <h3 class="text-xl font-semibold text-gray-900">Verifikasi Kode OTP</h3>
        <p class="text-sm text-gray-600 mt-2">
            Kode OTP telah dikirim ke email <strong>{{ $email }}</strong>. Masukkan kode tersebut untuk mereset Two-Factor Authentication Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('2fa.reset.verify') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
            <input type="text" id="otp" name="otp" maxlength="6" required autocomplete="off"
                   class="w-full text-center text-2xl tracking-[8px] px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="000000">
            @error('otp')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors">
            Verifikasi & Reset 2FA
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">Kode OTP berlaku selama 10 menit.</p>
        <a href="{{ route('login') }}" class="text-sm text-primary hover:underline mt-2 inline-block">Kembali ke halaman login</a>
    </div>
</x-simple-layout>
