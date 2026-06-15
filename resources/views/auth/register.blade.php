<x-guest-layout>
    <!-- Validasi Error -->
    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="name">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="Nama sesuai KTP">
            </div>
        </div>

        <!-- Email -->
        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="Alamat email aktif">
            </div>
        </div>

        <!-- Password -->
        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="password">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full pl-10 pr-10 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="Minimal 8 karakter">
                <button type="button" x-data="{ show: false }"
                    x-on:click="show = !show; $el.previousElementSibling.type = show ? 'text' : 'password'"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[20px]"
                        x-text="show ? 'visibility' : 'visibility_off'">visibility_off</span>
                </button>
            </div>
        </div>

        <!-- Konfirmasi Password (Wajib untuk Jetstream) -->
        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="password_confirmation">Konfirmasi
                Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="Ulangi password">
            </div>
        </div>

        <!-- Terms & Conditions -->
        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-2">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="terms" id="terms" required
                            class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary h-4 w-4 mt-1">
                        <span class="ml-2 font-label-sm text-label-sm text-on-surface-variant">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="text-primary hover:underline">' . __('Terms of Service') . '</a>',
                'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="text-primary hover:underline">' . __('Privacy Policy') . '</a>',
            ]) !!}
                        </span>
                    </label>
                </div>
        @endif

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full py-3 px-4 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Daftar Akun
            </button>
        </div>
    </form>
</x-guest-layout>