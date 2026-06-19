<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Pengaturan')

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Dashboard Pengaturan
            </h2>
        </div>
    </x-slot>

    <div class="p-4 space-y-5">

        {{-- MENU --}}
        <div class="bg-white dark:bg-dark-bg rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">

                @php
                $menus = [

                ['url' => '/semester', 'label' => 'Semester'],
                ['url' => '/raportkelas', 'label' => 'Raport'],
                ['url' => '/presensikelas', 'label' => 'Presensi'],
                ['url' => '/plotingkelas', 'label' => 'Ploting'],
                ['url' => '/validasi-data', 'label' => 'Validasi'],
                ];
                @endphp

                @foreach ($menus as $menu)
                <a href="{{ $menu['url'] }}"
                    class="flex items-center justify-center h-11 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold shadow hover:shadow-lg hover:scale-105 transition-all duration-300">
                    {{ $menu['label'] }}
                </a>
                @endforeach

            </div>
        </div>

        {{-- CARD --}}
        <div class="bg-white dark:bg-dark-bg rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

            {{-- HEADER --}}
            <div class="px-5 py-4 border-b dark:border-gray-700">
                <h3 class="text-center text-lg font-bold tracking-wide text-gray-800 dark:text-white">
                    LIST CETAK RAPORT
                </h3>
                <p class="text-center text-xs text-gray-500 mt-1">
                    Data siswa yang siap dicetak raport
                </p>
            </div>

            {{-- FILTER --}}
            <div class="p-4 flex flex-col lg:flex-row gap-3 justify-between">

                {{-- SEARCH --}}
                <form action="/pengaturan" method="get"
                    class="flex flex-col sm:flex-row gap-2 w-full lg:w-1/2">

                    <input type="text"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Cari nama siswa..."
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-dark-bg">

                    <button type="submit"
                        class="px-5 py-2 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>

                {{-- DELETE --}}
                <form action="/delete-records" method="post"
                    class="flex flex-col sm:flex-row gap-2">
                    @csrf

                    <input type="text"
                        name="idsql"
                        placeholder="ID SQL"
                        class="rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-dark-bg">

                    <button
                        class="px-5 py-2 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition">
                        Hapus
                    </button>
                </form>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-100 dark:bg-purple-800 sticky top-0 z-10">
                        <tr class="text-xs uppercase tracking-wider">

                            <th class="px-3 py-3 border-b text-center">
                                No
                            </th>

                            <th class="px-3 py-3 border-b text-left">
                                Nama Siswa
                            </th>

                            <th class="px-3 py-3 border-b text-center">
                                Periode
                            </th>

                            <th class="px-3 py-3 border-b text-center">
                                Kelas
                            </th>

                            <th class="px-3 py-3 border-b text-center">
                                Nama Kelas
                            </th>

                            <th class="px-3 py-3 border-b text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($raport as $list)

                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-purple-900/40 transition">

                            <td class="px-3 py-3 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-3 py-3 font-medium uppercase">
                                {{ $list->nama_siswa }}
                            </td>

                            <td class="px-3 py-3 text-center">
                                {{ $list->periode }} {{ $list->ket_semester }}
                            </td>

                            <td class="px-3 py-3 text-center">
                                {{ $list->kelas }}
                            </td>

                            <td class="px-3 py-3 text-center">
                                {{ $list->nama_kelas }}
                            </td>

                            <td class="px-3 py-3 text-center">
                                <a href="/report/{{ $list->id }}"
                                    class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-500 text-white text-xs font-semibold hover:bg-purple-600 transition">
                                    Cetak
                                </a>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6"
                                class="py-10 text-center text-gray-500">
                                Data tidak ditemukan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</x-app-layout>