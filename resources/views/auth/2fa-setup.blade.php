<x-simple-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-container text-on-primary-container mb-4">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">assured_workload</span>
        </div>
        <h3 class="text-xl font-semibold text-gray-900">Setup Two-Factor Authentication</h3>
        <p class="text-sm text-gray-600 mt-2">
            Demi keamanan akun Anda, Anda diwajibkan untuk mengaktifkan autentikasi dua faktor (2FA) sebelum melanjutkan.
        </p>
    </div>

    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
        <p class="font-medium mb-1">Cara menggunakan 2FA:</p>
        <ol class="list-decimal list-inside space-y-1">
            <li>Klik tombol <strong>"Enable"</strong> untuk memulai.</li>
            <li>Scan <strong>QR code</strong> yang muncul menggunakan aplikasi authenticator (Google Authenticator, Microsoft Authenticator, Authy, dll).</li>
            <li>Masukkan <strong>kode 6 digit</strong> yang ditampilkan di aplikasi authenticator Anda.</li>
            <li>Klik <strong>"Confirm"</strong> untuk menyelesaikan pengaturan.</li>
            <li>Simpan <strong>recovery codes</strong> yang diberikan di tempat yang aman untuk berjaga-jaga jika Anda kehilangan akses ke aplikasi authenticator.</li>
        </ol>
    </div>

    @livewire('two-factor-setup-page')
</x-simple-layout>

