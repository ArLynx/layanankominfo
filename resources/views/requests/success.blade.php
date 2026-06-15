<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Berhasil - Dinas Kominfo Murung Raya</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    "colors": {
                        "primary": "#001e40",
                        "primary-container": "#003366",
                        "success-emerald": "#059669",
                        "status-pending": "#D97706",
                        "surface": "#ffffff",
                        "surface-container": "#eff4ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-gray": "#f8f9ff",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#43474f",
                        "border-subtle": "#E2E8F0",
                        "outline-variant": "#c3c6d1",
                    },
                    "borderRadius": {
                        "xl": "0.75rem",
                        "full": "9999px"
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes entry {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-entry {
            animation: entry 0.6s ease-out forwards;
        }
        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.6; }
        }
        .animate-pulse-glow {
            animation: pulse-glow 3s infinite ease-in-out;
        }
    </style>
</head>
<body class="bg-surface-container-low min-h-screen flex items-center justify-center p-4 md:p-12 font-body-md text-body-md antialiased text-on-surface">

    <main class="w-full max-w-[540px] mx-auto opacity-0 animate-entry">
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle p-8 md:p-12 text-center shadow-[0px_4px_6px_rgba(0,51,102,0.05)] flex flex-col items-center relative overflow-hidden">
            <!-- Decorative background element -->
            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-success-emerald/5 to-transparent pointer-events-none"></div>

            <!-- Success Icon -->
            <div class="relative w-24 h-24 mb-8">
                <div class="absolute inset-0 bg-success-emerald/10 rounded-full animate-pulse-glow"></div>
                <div class="relative w-full h-full flex items-center justify-center bg-surface-container-lowest rounded-full z-10 border-4 border-success-emerald/20">
                    <span class="material-symbols-outlined text-[48px] text-success-emerald" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
            </div>

            <!-- Heading & Message -->
            <h1 class="text-headline-lg font-headline-lg text-on-surface mb-4">Pengajuan Berhasil Dikirim</h1>
            <p class="text-body-md text-on-surface-variant mb-10 max-w-[400px]">
                Dokumen aplikasi Anda telah berhasil kami terima. Tim administrasi kami akan segera melakukan verifikasi terhadap data yang dilampirkan.
            </p>

            <!-- Ticket Information Card -->
            <div class="w-full bg-surface-gray border border-border-subtle rounded-lg p-6 mb-10 text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-in-out pointer-events-none"></div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-widest mb-2">Nomor Tiket</p>
                <div class="flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 0;">confirmation_number</span>
                    <p class="text-headline-md text-primary font-bold tracking-tight">REQ-{{ date('Y') }}-{{ str_pad($application->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-border-subtle/50 flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-[16px] text-status-pending" style="font-variation-settings: 'FILL' 1;">pending</span>
                    <p class="text-caption text-on-surface-variant">Status Saat Ini: {{ ucfirst($application->status) }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="w-full flex flex-col md:flex-row gap-4">
                <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center gap-2 py-4 px-6 bg-primary text-on-primary font-label-md text-label-md rounded-full hover:bg-primary-container transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-surface">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    Ke Dashboard Saya
                </a>
                <button class="flex-1 flex items-center justify-center gap-2 py-4 px-6 bg-transparent border border-outline-variant text-primary font-label-md text-label-md rounded-full hover:bg-surface-container transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-surface">
                    <span class="material-symbols-outlined text-[20px]">download</span>
                    Unduh Bukti Pengajuan
                </button>
            </div>
        </div>

        <!-- Subtle Footer/Help link -->
        <div class="mt-8 text-center">
            <p class="text-caption text-on-surface-variant">
                Butuh bantuan terkait pengajuan ini? <a class="text-primary font-bold hover:underline transition-all" href="#">Hubungi Dukungan</a>
            </p>
        </div>
    </main>
</body>
</html>
