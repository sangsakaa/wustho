<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Tambah Peserta Kelas')

        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Tambah Peserta Kelas
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola peserta kelas secara kolektif dengan lebih cepat dan efisien.
                </p>
            </div>

            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Card Form --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Data Peserta Kelas
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan peserta ke dalam kelas secara kolektif.
                    </p>
                </div>

                <div class="p-6">
                    <livewire:list-kolektif-kelas :kelasmi="$kelasmi->id" />
                </div>
            </div>

            {{-- Information Card --}}
            <div
                class="overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-r from-blue-50 to-sky-50 shadow-sm">
                <div class="flex items-start gap-4 p-6">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <div>
                        <h4 class="text-base font-semibold text-blue-900">
                            Keterangan
                        </h4>

                        <ul class="mt-2 space-y-2 text-sm text-blue-800">
                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-blue-500"></span>
                                Fitur ini digunakan untuk menambah peserta kelas secara kolektif.
                            </li>

                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-blue-500"></span>
                                Pastikan data peserta sudah tersedia sebelum ditambahkan ke kelas.
                            </li>

                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-blue-500"></span>
                                Gunakan pencarian untuk mempercepat proses pemilihan peserta.
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>