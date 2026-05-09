<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-col gap-4">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-white">
                        Data Siswa
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Manajemen data siswa pondok
                    </p>
                </div>

            </div>

            {{-- TOAST IMPORT --}}
            @if (session('import_result'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    const result = @json(session('import_result'));

                    let message = `
Total: ${result.summary.total} data
✅ Berhasil: ${result.summary.success}
⚠️ Dilewati: ${result.summary.skipped}
❌ Error: ${result.summary.errors}
`;

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

    <div class="p-2 sm:p-4 space-y-4">

        {{-- TABLE --}}
        <div
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl p-2 sm:p-4 border border-gray-200 dark:border-gray-700 overflow-x-auto">

            <div class="min-w-full">
                <livewire:mahasiswa-table />
            </div>

        </div>

        {{-- KETERANGAN --}}
        <div
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl p-4 border border-gray-200 dark:border-gray-700">

            <h3 class="font-medium text-sm sm:text-base mb-3 text-gray-700 dark:text-gray-200">
                Keterangan
            </h3>

            <div class="space-y-3 text-xs sm:text-sm text-gray-600 dark:text-gray-300">

                <div class="flex items-start gap-2">
                    <span class="text-green-600 font-semibold shrink-0">1.</span>
                    <p>
                        Siswa <b>Aktif</b> masih mengikuti pembelajaran.
                    </p>
                </div>

                <div class="flex items-start gap-2">
                    <span class="text-blue-600 font-semibold shrink-0">2.</span>
                    <p>
                        Siswa <b>Lulus</b> telah menyelesaikan pembelajaran.
                    </p>
                </div>

                <div class="flex items-start gap-2">
                    <span class="text-red-600 font-semibold shrink-0">3.</span>
                    <p>
                        Siswa <b>Boyong</b> sudah tidak aktif.
                    </p>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>