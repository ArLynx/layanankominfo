<x-admin-layout title="Tambah Admin">
    <div class="mb-6">
        <h1 class="text-headline-large font-bold text-on-surface">Tambah Admin Baru</h1>
        <p class="mt-1 text-on-surface-variant">Buat akun admin, superadmin, atau pimpinan baru</p>
    </div>

    <form method="POST" action="{{ route('admin.admins.store') }}" class="bg-surface-container-lowest rounded-xl border border-border-subtle p-6 space-y-6 max-w-2xl">
        @csrf

        <div>
            <label class="block text-label-md font-label-md text-on-surface mb-2" for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
            @error('name') <p class="mt-1 text-error text-body-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-label-md font-label-md text-on-surface mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
            @error('email') <p class="mt-1 text-error text-body-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-label-md font-label-md text-on-surface mb-2" for="password">Password</label>
            <input type="password" name="password" id="password" required minlength="8"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
            @error('password') <p class="mt-1 text-error text-body-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-label-md font-label-md text-on-surface mb-2" for="role">Role</label>
                <select name="role" id="role" required
                    class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="pimpinan" {{ old('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                </select>
                @error('role') <p class="mt-1 text-error text-body-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-label-md font-label-md text-on-surface mb-2" for="status">Status</label>
                <select name="status" id="status" required
                    class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <p class="mt-1 text-error text-body-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-label-md font-label-md text-on-surface mb-2" for="nik">NIK <span class="text-on-surface-variant">(opsional)</span></label>
            <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
        </div>

        <div>
            <label class="block text-label-md font-label-md text-on-surface mb-2" for="instansi">Instansi <span class="text-on-surface-variant">(opsional)</span></label>
            <input type="text" name="instansi" id="instansi" value="{{ old('instansi') }}"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
        </div>

        <div>
            <label class="block text-label-md font-label-md text-on-surface mb-2" for="no_hp_wa">No. HP/WA <span class="text-on-surface-variant">(opsional)</span></label>
            <input type="text" name="no_hp_wa" id="no_hp_wa" value="{{ old('no_hp_wa') }}"
                class="w-full px-3 py-2.5 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none text-body-md">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg text-label-md font-label-md hover:bg-primary-container transition-colors">Simpan</button>
            <a href="{{ route('admin.admins') }}" class="text-on-surface-variant hover:text-on-surface transition-colors text-label-md">Batal</a>
        </div>
    </form>
</x-admin-layout>
