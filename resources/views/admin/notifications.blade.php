<x-admin-layout title="Notifikasi">

    {{-- Header --}}
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 mb-8">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-headline-large font-headline-large text-on-surface">

                    Notifikasi

                </h1>

                <p class="mt-2 text-on-surface-variant">

                    Menampilkan seluruh notifikasi yang diterima oleh akun Anda.

                </p>

            </div>

        </div>

    </section>

    {{-- Filter --}}
    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle p-5 mb-6">

        <form method="GET" class="grid gap-4 md:grid-cols-3">

            {{-- Search --}}
            <div>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari notifikasi..."

                    class="w-full rounded-lg border border-border-subtle px-4 py-2
                    bg-surface-container-lowest
                    focus:border-primary focus:ring-primary">

            </div>

            {{-- Status --}}
            <div>

                <select
                    name="status"
                    class="w-full rounded-lg border border-border-subtle px-4 py-2
                    bg-surface-container-lowest">

                    <option value="">Semua</option>

                    <option value="unread"
                        {{ request('status')=='unread' ? 'selected' : '' }}>

                        Belum Dibaca

                    </option>

                    <option value="read"
                        {{ request('status')=='read' ? 'selected' : '' }}>

                        Sudah Dibaca

                    </option>

                </select>

            </div>

            {{-- Button --}}
            <div>

                <button
                    class="bg-primary text-white px-5 py-2 rounded-lg hover:opacity-90 transition">

                    Filter

                </button>

            </div>

        </form>

    </section>

    {{-- List Notifikasi --}}
    <section class="space-y-4">

        @forelse($notifications as $notification)

            <a
                href="{{ route('admin.notifications.read', $notification->id) }}"
                class="block bg-surface-container-lowest rounded-xl border border-border-subtle p-5 transition hover:shadow-md">

                <div class="flex justify-between items-start gap-5">

                    <div class="flex gap-4">

                        {{-- Icon --}}
                        <div>

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

                                    <span class="material-symbols-outlined">

                                        notifications

                                    </span>

                            @endswitch

                        </div>

                        {{-- Content --}}
                        <div>

                            <h2 class="font-semibold text-on-surface">

                                {{ $notification->title }}

                            </h2>

                            <p class="text-sm text-on-surface-variant mt-1">

                                {{ $notification->message }}

                            </p>

                            <p class="text-xs text-on-surface-variant mt-3">

                                {{ $notification->created_at->diffForHumans() }}

                            </p>

                        </div>

                    </div>

                    {{-- Status --}}
                    <div>

                        @if(!$notification->is_read)

                            <span
                                class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-medium">

                                Baru

                            </span>

                        @else

                            <span
                                class="inline-flex items-center rounded-full bg-surface-container text-on-surface-variant px-3 py-1 text-xs">

                                Dibaca

                            </span>

                        @endif

                    </div>

                </div>

            </a>

        @empty

            <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-12 text-center">

                <span class="material-symbols-outlined text-5xl text-outline">

                    notifications_off

                </span>

                <p class="mt-4 text-on-surface-variant">

                    Belum ada notifikasi.

                </p>

            </div>

        @endforelse

    </section>

    {{-- Pagination --}}
    <div class="mt-8">

        {{ $notifications->withQueryString()->links() }}

    </div>

</x-admin-layout>