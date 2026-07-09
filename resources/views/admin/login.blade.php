<x-guest-layout>
    <x-validation-errors class="mb-4" />

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-success-emerald bg-surface-container-low p-3 rounded-lg border border-border-subtle flex items-start gap-2">
            <span class="material-symbols-outlined shrink-0" style="font-size: 18px;">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
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

        <div>
            <label class="block font-label-md text-label-md text-on-surface mb-2" for="password">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-10 pr-10 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder-outline-variant"
                    placeholder="••••••••">
                <button type="button" x-data="{ show: false }"
                    x-on:click="show = !show; $el.previousElementSibling.type = show ? 'text' : 'password'"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[20px]"
                        x-text="show ? 'visibility' : 'visibility_off'">visibility_off</span>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary h-4 w-4">
                <span class="ml-2 font-label-sm text-label-sm text-on-surface-variant">Remember me</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full py-3 px-4 flex items-center justify-center space-x-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <span>Masuk sebagai Admin</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">Kembali ke halaman login user</a>
    </div>
</x-guest-layout>
