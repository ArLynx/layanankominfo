<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Permohonan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('requests.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="type" class="block font-medium text-sm text-gray-700">Tipe Permohonan</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="aktifkan_2fa">Aktivasi Two-Factor Authentication (2FA)</option>
                                <option value="reset_akun">Reset Akun</option>
                                <option value="pembuatan_email">Pembuatan Email Dinas</option>
                                <option value="pembuatan_subdomain">Pembuatan Subdomain</option>
                            </select>
                            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="reason" class="block font-medium text-sm text-gray-700">Alasan Permohonan</label>
                            <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan alasan Anda mengajukan permohonan ini..." required></textarea>
                            @error('reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                                Kirim Permohonan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
