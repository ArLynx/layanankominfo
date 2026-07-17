<header
    class="bg-surface border-b border-border-subtle py-4 px-gutter md:px-margin-desktop sticky top-0 z-40 w-full shadow-sm">

    <div class="max-w-container-max mx-auto flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex items-center gap-4">

            <span class="material-symbols-outlined text-primary text-4xl"
                style="font-variation-settings:'FILL' 1;">

                account_balance

            </span>

            <div>

                <h1 class="text-headline-lg font-headline-lg text-primary tracking-tight">

                    Dinas Kominfo Murung Raya

                </h1>

                <p class="text-label-md font-label-md text-on-surface-variant">

                    Portal Layanan Digital

                </p>

            </div>

        </div>

        {{-- Right --}}
        <div class="flex items-center gap-4">

            {{-- Notification --}}
            <div x-data="{ open: false }" class="relative">

                <button
                    @click="open = !open"
                    class="relative w-11 h-11 rounded-full hover:bg-surface-container flex items-center justify-center">

                    <span class="material-symbols-outlined text-[24px]">

                        notifications

                    </span>

                    @if ($unreadNotifications > 0)

                        <span
                            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] rounded-full bg-red-600 text-white text-[10px] flex items-center justify-center">

                            {{ $unreadNotifications }}

                        </span>

                    @endif

                </button>

                {{-- Dropdown --}}
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-[420px] bg-white rounded-xl border border-outline-variant shadow-2xl z-50">

                    <div class="px-4 py-3 border-b flex items-center justify-between">

                        <h3 class="font-semibold">

                            🔔 Notifikasi

                        </h3>

                        <a href="{{ route('notifications.index') }}"
                            class="text-xs text-primary hover:underline">

                            Lihat Semua

                        </a>

                    </div>

                    <div class="divide-y divide-outline-variant max-h-[420px] overflow-y-auto">

                        @forelse($headerNotifications as $notification)

                            <a
                                href="{{ route('notifications.read', $notification) }}"
                                class="flex gap-3 px-4 py-3 transition
                                {{ !$notification->is_read
                                    ? 'bg-blue-50 border-l-4 border-blue-600 hover:bg-blue-100'
                                    : 'hover:bg-surface-container-low' }}">

                                <div class="mt-1">

                                    @switch($notification->type)

                                        @case('subdomain')
                                            <span class="material-symbols-outlined text-blue-600">
                                                language
                                            </span>
                                        @break

                                        @case('email_satker')
                                            <span class="material-symbols-outlined text-purple-600">
                                                mail
                                            </span>
                                        @break

                                        @case('email_pribadi')
                                            <span class="material-symbols-outlined text-green-600">
                                                person
                                            </span>
                                        @break

                                        @default
                                            <span class="material-symbols-outlined text-primary">
                                                notifications
                                            </span>

                                    @endswitch

                                </div>

                                <div class="flex-1">

                                    <p class="font-medium text-sm">

                                        {{ $notification->title }}

                                    </p>

                                    <p class="text-xs text-on-surface-variant">

                                        {{ $notification->message }}

                                    </p>

                                    <p class="text-[11px] text-on-surface-variant mt-1">

                                        {{ $notification->created_at->locale('id')->diffForHumans() }}

                                    </p>

                                </div>

                            </a>

                        @empty

                            <div class="py-10 text-center text-sm text-on-surface-variant">

                                Belum ada notifikasi.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

            {{-- Avatar --}}
            <div
                class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">

                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}

            </div>

        </div>

    </div>

</header>