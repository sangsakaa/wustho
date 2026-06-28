<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Siswa')

        <div class="flex flex-col gap-4">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Data Siswa
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Manajemen data siswa / santri pondok
                    </p>
                </div>
            </div>

            {{-- TOAST IMPORT --}}
            @if (session('import_result'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const result = @json(session('import_result'));
                    let message = `Total: ${result.summary.total} data\n✅ Berhasil: ${result.summary.success}\n⚠️ Dilewati: ${result.summary.skipped}\n❌ Error: ${result.summary.errors}`;
                    if (result.detail.errors.length > 0) {
                        message += `\n\nContoh Error:\n${result.detail.errors[0]}`;
                    }
                    Toastify({
                        text: message,
                        duration: 6000,
                        gravity: "top",
                        position: window.innerWidth < 640 ? "center" : "right",
                        close: true,
                        stopOnFocus: true,
                        style: {
                            background: result.summary.errors > 0 ?
                                "linear-gradient(to right, #ff5f6d, #ffc371)" : "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                });
            </script>
            @endif

        </div>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen">

        <livewire:mahasiswa-table />

        {{-- KETERANGAN --}}
        <div class="mt-5 bg-gradient-to-r from-blue-50 to-sky-50 dark:from-blue-950/30 dark:to-sky-950/30 border border-blue-200/60 dark:border-blue-800/30 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 p-2.5 rounded-xl shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-700 dark:text-blue-400 mb-2">Keterangan</h4>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex gap-2"><span class="text-emerald-600 font-bold">•</span> Siswa <strong>Aktif</strong> masih mengikuti pembelajaran.</li>
                        <li class="flex gap-2"><span class="text-blue-600 font-bold">•</span> Siswa <strong>Lulus</strong> telah menyelesaikan pembelajaran.</li>
                        <li class="flex gap-2"><span class="text-red-600 font-bold">•</span> Siswa <strong>Boyong</strong> sudah tidak aktif.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>