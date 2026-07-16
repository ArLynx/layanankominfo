@extends('user.layouts.app')

@section('content')

<main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">

    {{-- Header --}}
    <div class="mb-10">

        <h1 class="text-display-sm font-display-sm text-on-surface mb-3">

            Notifikasi

        </h1>

        <p class="text-body-lg font-body-lg text-on-surface-variant">

            Menampilkan seluruh notifikasi yang Anda terima.

        </p>

    </div>

    {{-- Filter --}}
    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-sm p-6 mb-8">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Search --}}
            <div>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari notifikasi..."

                    class="w-full px-4 py-3 rounded-lg
                    border border-outline-variant
                    bg-surface
                    focus:ring-2 focus:ring-primary
                    focus:border-primary">

            </div>

            {{-- Status --}}
            <div>

                <select
                    name="status"

                    class="w-full px-4 py-3 rounded-lg
                    border border-outline-variant
                    bg-surface">

                    <option value="">

                        Semua Status

                    </option>

                    <option
                        value="unread"
                        {{ request('status') == 'unread' ? 'selected' : '' }}>

                        Belum Dibaca

                    </option>

                    <option
                        value="read"
                        {{ request('status') == 'read' ? 'selected' : '' }}>

                        Sudah Dibaca

                    </option>

                </select>

            </div>

            {{-- Button --}}
            <div>

                <button
                    class="w-full bg-primary text-on-primary px-5 py-3 rounded-lg hover:opacity-90 transition">

                    Filter

                </button>

            </div>

        </form>

    </div>

    {{-- List --}}
    <div class="space-y-4">

        @forelse($notifications as $notification)

            <a
                href="{{ route('notifications.read', $notification->id) }}"

                class="block bg-surface-container-lowest
                border border-border-subtle
                rounded-xl
                shadow-sm
                hover:shadow-md
                transition">

                <div class="p-6 flex justify-between gap-6">

                    <div class="flex gap-4 flex-1">

                        {{-- Icon --}}
                        <div>

                            @switch($notification->type)

                                @case('subdomain')

                                    <span class="material-symbols-outlined text-blue-600 text-3xl">

                                        language

                                    </span>

                                @break

                                @case('email_satker')

                                    <span class="material-symbols-outlined text-purple-600 text-3xl">

                                        mail

                                    </span>

                                @break

                                @case('email_pribadi')

                                    <span class="material-symbols-outlined text-green-600 text-3xl">

                                        person

                                    </span>

                                @break

                                @default

                                    <span class="material-symbols-outlined text-primary text-3xl">

                                        notifications

                                    </span>

                            @endswitch

                        </div>

                        {{-- Content --}}
                        <div class="flex-1">

                            <div class="flex items-center gap-2">

                                <h2 class="font-semibold text-on-surface">

                                    {{ $notification->title }}

                                </h2>

                                @if(!$notification->is_read)

                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full
                                        bg-blue-100 text-blue-700 text-[11px] font-medium">

                                        Baru

                                    </span>

                                @endif

                            </div>

                            <p class="mt-2 text-body-md text-on-surface-variant">

                                {{ $notification->message }}

                            </p>

                            <p class="mt-3 text-caption text-on-surface-variant">

                                {{ $notification->created_at->locale('id')->diffForHumans() }}

                            </p>

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="hidden md:flex items-start">

                        @if($notification->is_read)

                            <span
                                class="px-3 py-1 rounded-full
                                bg-surface-container
                                text-on-surface-variant
                                text-xs">

                                Dibaca

                            </span>

                        @endif

                    </div>

                </div>

            </a>

        @empty

            <div
                class="bg-surface-container-lowest
                border border-border-subtle
                rounded-xl
                shadow-sm
                p-16">

                <div class="flex flex-col items-center">

                    <span
                        class="material-symbols-outlined
                        text-[72px]
                        text-outline">

                        notifications_off

                    </span>

                    <h3
                        class="mt-4
                        text-headline-md
                        font-headline-md
                        text-on-surface">

                        Belum Ada Notifikasi

                    </h3>

                    <p
                        class="mt-2
                        text-body-md
                        text-on-surface-variant
                        text-center">

                        Semua pemberitahuan mengenai status pengajuan layanan
                        akan muncul pada halaman ini.

                    </p>

                </div>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())

        <div class="mt-8">

            {{ $notifications->withQueryString()->links() }}

        </div>

    @endif

</main>

@endsection