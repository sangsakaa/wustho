<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Tambah Anggota Asrama
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4 space-y-6">

        {{-- Data Anggota Asrama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-700">
                    Data Anggota Asrama
                </h3>
                <p class="text-sm text-gray-500">
                    Pilih siswa yang akan ditambahkan ke dalam asrama.
                </p>
            </div>

            <div class="p-6">
                <livewire:list-kolektif-asrama :asramasiswa="$asramasiswa->id" />
            </div>
        </div>

        {{-- Informasi --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50 shadow-sm">
            <div class="flex items-start gap-4 p-5">

                {{-- Icon --}}
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                    </svg>
                </div>

                {{-- Isi --}}
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-blue-800">
                        Informasi
                    </h3>

                    <p class="mt-2 text-sm text-blue-700">
                        Gunakan halaman ini untuk menambahkan anggota ke dalam asrama yang dipilih.
                    </p>

                    <ul class="mt-4 space-y-2 text-sm text-blue-700 list-disc list-inside">
                        <li>Pilih siswa yang belum terdaftar pada asrama.</li>
                        <li>Pastikan data siswa sudah benar sebelum disimpan.</li>
                        <li>Siswa yang berhasil ditambahkan akan langsung menjadi anggota asrama.</li>
                        <li>Data anggota dapat diubah atau dihapus melalui menu Data Asrama.</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>