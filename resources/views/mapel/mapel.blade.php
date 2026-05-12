<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Kurikulum')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">

            <h2 class="text-xl font-bold text-gray-800">
                📘 Daftar Mata Pelajaran & Kurikulum
            </h2>

            <div class="flex gap-2">

                <a href="/mapel/laporan/pdf"
                    target="_blank"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                    Download PDF
                </a>

                <a href="/addmapel"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                    + Tambah Mapel
                </a>

            </div>

        </div>
    </x-slot>

    <div class="px-4 py-6 space-y-6">

        {{-- ================= ALERT ================= --}}
        @php
        $alerts = [
        'success' => 'green',
        'delete' => 'red',
        'update' => 'blue',
        ];
        @endphp

        @foreach ($alerts as $key => $color)
        @if (session($key))
        <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 text-{{ $color }}-700 px-4 py-3 rounded-xl text-sm">
            {{ session($key) }}
        </div>
        @endif
        @endforeach

        {{-- ================= NOTE ================= --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">

            <p class="font-semibold mb-2">📌 Alur Pengisian Kurikulum</p>

            <ol class="list-decimal pl-5 space-y-1">
                <li>Pilih <b>Periode Aktif</b>.</li>
                <li>Input data <b>Kelas</b>.</li>
                <li>Buat <b>Mata Pelajaran</b>.</li>
                <li>Isi <b>Kitab</b> jika diperlukan.</li>
                <li>Masuk detail mapel untuk <b>Guru Pengampu</b>.</li>
                <li>Gunakan <b>Generate dari Jadwal</b> jika tersedia.</li>
            </ol>

            <p class="text-xs mt-2 text-blue-600">
                ⚠️ Hindari duplikasi mapel pada kelas & periode yang sama.
            </p>

        </div>

        {{-- ================= DASHBOARD ================= --}}
        @php
        $totalMapel = $listmapel->count();
        $totalKelas = $listmapel->groupBy('kelas')->count();
        $ganjil = $listmapel->where('ket_semester','Ganjil')->count();
        $genap = $listmapel->where('ket_semester','Genap')->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl p-5 shadow">
                <p class="text-sm text-gray-500">Total Mapel</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $totalMapel }}</h3>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow">
                <p class="text-sm text-gray-500">Total Kelas</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $totalKelas }}</h3>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow">
                <p class="text-sm text-gray-500">Semester Ganjil</p>
                <h3 class="text-2xl font-bold text-yellow-500">{{ $ganjil }}</h3>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow">
                <p class="text-sm text-gray-500">Semester Genap</p>
                <h3 class="text-2xl font-bold text-purple-600">{{ $genap }}</h3>
            </div>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="px-5 py-4 border-b">
                <h3 class="font-semibold text-gray-700 text-sm">
                    Data Mata Pelajaran
                </h3>
            </div>

            <div class="overflow-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs uppercase text-gray-500 border-b">
                            <th class="py-3 w-12 text-center">No</th>
                            <th class="text-center">Periode</th>
                            <th class="text-left px-3">Mapel</th>
                            <th class="text-left px-3">Kitab</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center w-44">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($listmapel as $list)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="text-center py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center">
                                <span class="px-2 py-1 text-xs bg-gray-100 rounded-full">
                                    {{ $list->periode }} {{ $list->ket_semester }}
                                </span>
                            </td>

                            <td class="px-3 font-semibold text-blue-600">
                                {{ $list->mapel }}
                            </td>

                            <td class="px-3 text-gray-600">
                                {{ $list->nama_kitab }}
                            </td>

                            <td class="text-center">
                                <span class="px-2 py-1 text-xs bg-blue-50 text-blue-600 rounded-full">
                                    {{ $list->kelas }}
                                </span>
                            </td>

                            <td>
                                <div class="flex justify-center gap-2 py-2">

                                    {{-- EDIT --}}
                                    <a href="/edit-mapel/{{ $list->id }}"
                                        class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200">
                                        Edit
                                    </a>

                                    {{-- PENGAMPU --}}
                                    <a href="/mapel/{{ $list->id }}"
                                        class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                        Pengampu
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="/mapel/{{ $list->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Hapus {{ $list->mapel }}?')"
                                            class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">
                                Belum ada data mata pelajaran
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>