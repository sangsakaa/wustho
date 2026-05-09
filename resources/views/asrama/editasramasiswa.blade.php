<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                    Dashboard Asrama Siswa
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kelola data asrama siswa dengan lebih mudah
                </p>
            </div>

            <a href="/addasramasiswa"
                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm shadow-sm transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4" />

                </svg>

                Tambah Data

            </a>

        </div>

    </x-slot>

    <div class="p-3 sm:p-5 space-y-5">

        {{-- CARD FORM --}}
        <div
            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm rounded-2xl overflow-hidden">

            {{-- HEADER --}}
            <div
                class="border-b border-gray-100 dark:border-gray-800 px-5 py-4 bg-gray-50 dark:bg-gray-800/50">

                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    Edit Data Asrama Siswa
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Perbarui data asrama dan kuota siswa
                </p>

            </div>

            {{-- BODY --}}
            <div class="p-5">

                <form action="/asramasiswa/{{$asramasiswa->id}}"
                    method="post"
                    class="space-y-5">

                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- ASRAMA --}}
                        <div class="space-y-2">

                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Asrama
                            </label>

                            <div class="text-xs text-blue-600 font-medium">
                                Type Asrama: {{ strtoupper($typeAsrama) }}
                            </div>

                            <select name="asrama_id"
                                class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm uppercase focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                @foreach($dataasrama as $asrama)

                                <option value="{{ $asrama->id }}"
                                    {{ old('asrama_id', $asramasiswa->asrama_id) == $asrama->id ? 'selected' : '' }}>

                                    {{ $asrama->nama_asrama }}

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
                                value="{{$asramasiswa->kuota}}"
                                placeholder="Contoh: 40"
                                class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div
                        class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">

                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-medium shadow-sm transition">

                            Update Data

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
        <div
            class="bg-gradient-to-r from-blue-50 to-sky-50 border border-blue-200 rounded-2xl p-5">

            <div class="flex items-start gap-3">

                <div
                    class="bg-blue-100 text-blue-600 p-2 rounded-xl">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z" />

                    </svg>

                </div>

                <div>

                    <h4 class="font-semibold text-blue-700 mb-2">
                        Informasi Penting
                    </h4>

                    <ul class="space-y-2 text-sm text-gray-700">

                        <li class="flex gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            Penambahan anggota asrama wajib memiliki
                            <b>NIS aktif</b>
                        </li>

                        <li class="flex gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            Jika siswa belum memiliki NIS, silakan
                            konfirmasi ke bagian
                            <b>kesiswaan atau kepala sekolah</b>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>