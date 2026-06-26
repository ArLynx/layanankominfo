<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (session('warning'))
                <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                    {{ session('warning') }}
                </div>
            @endif

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')

                    @if(auth()->user()->two_factor_secret)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <form method="POST" action="{{ route('2fa.reset.send') }}" class="space-y-3">
                                @csrf
                                <p class="text-sm text-gray-600">Kehilangan akses authenticator? Reset 2FA via email.</p>
                                <div class="flex items-center gap-3">
                                    <input type="password" name="password" placeholder="Masukkan password" required
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                    <button type="submit"
                                            class="px-4 py-2 bg-orange-500 text-white rounded-md text-sm font-medium hover:bg-orange-600">
                                        Kirim OTP
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </form>
                        </div>
                    @endif
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
