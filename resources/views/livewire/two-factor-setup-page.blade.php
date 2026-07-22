<div>
    @livewire('profile.two-factor-authentication-form')

    @if($enabled)
        @php
            $dashboardRoute = auth()->user() instanceof \App\Models\Admin
                ? (auth()->user()->role === 'pimpinan' ? route('pimpinan.dashboard') : route('admin.dashboard'))
                : route('dashboard-user');
        @endphp
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <a href="{{ $dashboardRoute }}"
               class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary-dark transition-all duration-200 w-full shadow-sm">
                Lanjutkan ke Dashboard
                <span class="material-symbols-outlined ml-2 text-sm">arrow_forward</span>
            </a>
        </div>
    @endif

    <div wire:poll.500ms="checkStatus"></div>
</div>
