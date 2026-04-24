<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Pengaturan')
        <h2 class="font-semibold text-xl">
            Dashboard Pengaturan
        </h2>
    </x-slot>

    <div class="p-3 space-y-4">

        {{-- MENU --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-xl p-3">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2 text-xs uppercase">

                @php
                $menus = [
                ['url' => '/periode', 'label' => 'Periode'],
                ['url' => '/semester', 'label' => 'Semester'],
                ['url' => '/raportkelas', 'label' => 'Raport'],
                ['url' => '/presensikelas', 'label' => 'Presensi'],
                ['url' => '/plotingkelas', 'label' => 'Ploting'],
                ['url' => '/validasi-data', 'label' => 'Validasi'],
                ];
                @endphp

                @foreach ($menus as $menu)
                <a href="{{ $menu['url'] }}"
                    class="text-center py-2 rounded-lg bg-blue-600 text-white hover:bg-purple-600 transition">
                    {{ $menu['label'] }}
                </a>
                @endforeach

            </div>
        </div>

        {{-- CARD --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-xl p-4 space-y-3">

            {{-- HEADER --}}
            <div>
                <h3 class="font-semibold text-center text-sm tracking-wide">
                    LIST CETAK RAPORT
                </h3>
                <hr class="mt-2">
            </div>

            {{-- FILTER --}}
            <div class="flex flex-col md:flex-row gap-2 justify-between">

                {{-- SEARCH --}}
                <form action="/pengaturan" method="get" class="flex gap-2 w-full md:w-1/2">
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        class="w-full border rounded-lg px-3 py-1 text-sm focus:ring focus:ring-blue-300 dark:bg-dark-bg"
                        placeholder="Cari siswa...">

                    <button type="submit"
                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Cari
                    </button>
                </form>

                {{-- DELETE --}}
                <form action="/delete-records" method="post" class="flex gap-2">
                    @csrf
                    <input type="text" name="idsql"
                        class="border rounded-lg px-2 py-1 text-sm dark:bg-dark-bg"
                        placeholder="ID SQL">

                    <button
                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Hapus
                    </button>
                </form>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">

                    <thead class="bg-gray-100 dark:bg-purple-700 text-xs uppercase">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border text-left">Nama</th>
                            <th class="p-2 border">Periode</th>
                            <th class="p-2 border">Kelas</th>
                            <th class="p-2 border">Nama Kelas</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($raport as $list)
                        <tr class="hover:bg-gray-50 dark:hover:bg-purple-800 transition">

                            <td class="border text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-2 uppercase">
                                {{ $list->nama_siswa }}
                            </td>

                            <td class="border text-center">
                                {{ $list->periode }} {{ $list->ket_semester }}
                            </td>

                            <td class="border text-center">
                                {{ $list->kelas }}
                            </td>

                            <td class="border text-center">
                                {{ $list->nama_kelas }}
                            </td>

                            <td class="border text-center p-1">
                                <a href="/report/{{ $list->id }}"
                                    class="inline-block px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-purple-600 transition">
                                    Cetak
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-500">
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