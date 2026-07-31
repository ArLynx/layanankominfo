<x-guest-layout>
    <div class="flex flex-col items-center text-center gap-2 mb-6">
        <div class="h-16 w-16 bg-surface-container rounded-full flex items-center justify-center mb-2 border border-border-subtle">
            <span class="material-symbols-outlined text-primary"
                style="font-size: 32px; font-variation-settings: 'FILL' 1;">lock_reset</span>
        </div>
        <h1 class="font-headline-md text-headline-md text-primary">Reset 2FA Admin</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Masukkan email admin Anda. Kami akan mengirim kode OTP ke email tersebut.
        </p>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('admin.2fa.reset.send-email') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email Admin</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="masukkan email admin">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full py-3 px-4 flex items-center justify-center space-x-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <span>Kirim Kode OTP</span>
                <span class="material-symbols-outlined text-[18px]">send</span>
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