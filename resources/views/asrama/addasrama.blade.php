<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Tambah Asrama')

        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Form Tambah Asrama
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Tambahkan data asrama putra atau putri
            </p>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6">

        <div class="max-w-xl mx-auto space-y-5">

            {{-- CARD FORM --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                {{-- HEADER CARD --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-semibold text-gray-800 dark:text-white">
                        Form Tambah Daftar Asrama
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Isi data asrama dengan lengkap
                    </p>
                </div>

                {{-- BODY --}}
                <div class="p-6">
                    <form action="/asrama" method="POST" class="space-y-5">
                        @csrf

                        {{-- NAMA ASRAMA --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Asrama
                            </label>

                            <input type="text"
                                name="nama_asrama"
                                value="{{ old('nama_asrama') }}"
                                placeholder="Contoh: Al Hikam"
                                required
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        {{-- TYPE --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Type Asrama
                            </label>

                            <select name="type_asrama"
                                required
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                <option value="">-- Pilih Type Asrama --</option>
                                <option value="Putra" {{ old('type_asrama') == 'Putra' ? 'selected' : '' }}>
                                    Asrama Putra
                                </option>
                                <option value="Putri" {{ old('type_asrama') == 'Putri' ? 'selected' : '' }}>
                                    Asrama Putri
                                </option>
                            </select>
                        </div>

                        {{-- BUTTON --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">

                            <button type="submit"
                                class="inline-flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-medium shadow-sm transition">

                                <x-icons.save />
                                Simpan Data
                            </button>

                            <a href="/asramasiswa"
                                class="inline-flex justify-center items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl text-sm font-medium transition">

                                <x-icons.add />
                                Asrama Siswa
                            </a>

                        </div>
                    </form>
                </div>
            </div>

            {{-- INFO --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
                <h4 class="font-semibold text-blue-700 mb-2">
                    Informasi
                </h4>

                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2">
                        <span class="text-blue-600">•</span>
                        Nama asrama harus unik dan mudah dikenali
                    </li>

                    <li class="flex gap-2">
                        <span class="text-blue-600">•</span>
                        Pilih tipe asrama sesuai kategori <b>Putra</b> atau <b>Putri</b>
                    </li>

                    <li class="flex gap-2">
                        <span class="text-blue-600">•</span>
                        Setelah dibuat, data bisa dikelola di menu <b>Asrama Siswa</b>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>