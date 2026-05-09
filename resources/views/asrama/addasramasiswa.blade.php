<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Form Tambah Asrama
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Tambahkan data asrama baru beserta kuota penghuni
            </p>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6">

        <div class="max-w-3xl mx-auto space-y-5">

            {{-- CARD FORM --}}
            <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Tambah Data Asrama
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Isi form berikut untuk menambahkan asrama baru
                    </p>
                </div>

                {{-- BODY --}}
                <div class="p-6">

                    <form action="/asramasiswa" method="post" class="space-y-5">
                        @csrf

                        {{-- PILIH ASRAMA --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Asrama
                            </label>

                            <select name="asrama_id"
                                class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                <option value="">-- Pilih Asrama --</option>

                                @foreach($datasrama as $item)
                                <option value="{{ $item->id }}">
                                    Asrama - {{ $item->nama_asrama }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- KUOTA --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kuota Asrama
                            </label>

                            <input type="number"
                                name="kuota"
                                placeholder="Contoh: 40"
                                class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">

                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-medium shadow-sm transition">

                                Simpan Data

                            </button>

                            <a href="/asramasiswa"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl text-sm font-medium text-center transition">

                                Kembali

                            </a>

                        </div>

                    </form>

                </div>

            </div>

            {{-- INFO --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">

                <h4 class="font-semibold text-blue-700 mb-3">
                    Informasi
                </h4>

                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        Pastikan asrama belum pernah ditambahkan sebelumnya
                    </li>

                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        Isi kuota sesuai kapasitas maksimal kamar/asrama
                    </li>
                </ul>

            </div>

        </div>

    </div>

</x-app-layout>