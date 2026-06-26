@extends('user.layouts.app')

@section('content')
    <div class="p-margin-mobile md:p-margin-desktop max-w-container-max mx-auto relative z-10">
        @if (session('warning'))
            <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-r-lg">
                <div class="flex gap-3 items-center">
                    <span class="material-symbols-outlined text-yellow-600">warning</span>
                    <p class="text-label-md font-medium">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-border-subtle pb-6 mb-8">
            <div>
                <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-1">
                    Profil Saya
                </h2>
                <p class="text-body-md font-body-md text-on-surface-variant">Kelola informasi akun dan pengaturan keamanan Anda.</p>
            </div>
        </header>

        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="bg-surface rounded-xl border border-border-subtle p-6 mb-6">
                @livewire('profile.update-profile-information-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="bg-surface rounded-xl border border-border-subtle p-6 mb-6">
                @livewire('profile.update-password-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="bg-surface rounded-xl border border-border-subtle p-6 mb-6">
                @livewire('profile.two-factor-authentication-form')

                @if(auth()->user()->two_factor_secret)
                    <div class="mt-6 pt-4 border-t border-border-subtle">
                        <form method="POST" action="{{ route('2fa.reset.send') }}" class="space-y-3">
                            @csrf
                            <p class="text-sm text-gray-600">Jika Anda kehilangan akses ke aplikasi authenticator, Anda dapat mereset 2FA melalui email.</p>
                            <div class="flex items-center gap-3">
                                <input type="password" name="password" placeholder="Masukkan password Anda" required
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                                <button type="submit"
                                        class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600 transition-colors whitespace-nowrap">
                                    Kirim OTP Reset
                                </button>
                            </div>
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-surface rounded-xl border border-border-subtle p-6 mb-6">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="bg-surface rounded-xl border border-border-subtle p-6">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>
@endsection
