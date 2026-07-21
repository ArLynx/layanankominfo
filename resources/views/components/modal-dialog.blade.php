<div id="{{ $id }}" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-surface rounded-xl border border-border-subtle shadow-xl max-w-md w-full p-6 transform transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-2xl text-primary" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface">{{ $title }}</h3>
                </div>
                <button type="button" onclick="closeModal('{{ $id }}')" class="text-on-surface-variant hover:text-on-surface transition-colors p-1">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="font-body-md text-body-md text-on-surface-variant mb-6">
                {{ $slot }}
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('{{ $id }}')"
                    class="bg-primary text-on-primary font-label-md text-label-md px-6 py-2 rounded-lg hover:bg-primary-container transition-all">
                    Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('click', function (e) {
        document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(function (modal) {
            if (e.target === modal || e.target === modal.querySelector('.fixed.inset-0.bg-black\\/50')) {
                closeModal(modal.id);
            }
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(function (modal) {
                closeModal(modal.id);
            });
        }
    });
</script>
@endpush