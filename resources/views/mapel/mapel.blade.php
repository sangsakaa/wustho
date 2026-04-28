<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kurikulum')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <h2 class="font-semibold text-xl text-gray-800">
                Daftar Mata Pelajaran & Kurikulum
            </h2>

            <div class="flex gap-2">
                <a href="/mapel/laporan/pdf" target="_blank"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                    Download PDF
                </a>

                <a href="/addmapel"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-xl shadow">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    Tambah
                </a>
            </div>
        </div>
    </x-slot>

    <div class="px-4 py-6 space-y-6">

        <!-- ALERT -->
        @if (session('delete'))
        <div class="px-4 py-3 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm">
            {{ session('delete') }}
        </div>
        @endif

        @if (session('success'))
        <div class="px-4 py-3 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session('update'))
        <div class="px-4 py-3 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 text-sm">
            {{ session('update') }}
        </div>
        @endif

        <!-- DASHBOARD -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Total Mapel</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">
                    {{ $listmapel->count() }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Total Kelas</p>
                <h3 class="text-3xl font-bold text-green-600 mt-2">
                    {{ $listmapel->groupBy('kelas')->count() }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Semester Ganjil</p>
                <h3 class="text-3xl font-bold text-yellow-500 mt-2">
                    {{ $listmapel->where('ket_semester','Ganjil')->count() }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Semester Genap</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-2">
                    {{ $listmapel->where('ket_semester','Genap')->count() }}
                </h3>
            </div>

        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b">
                <h3 class="text-sm font-semibold text-gray-700">
                    Data Mata Pelajaran
                </h3>
            </div>

            <div class="overflow-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="text-gray-500 text-xs uppercase border-b bg-gray-50">
                            <th class="py-3 text-center w-12">No</th>
                            <th class="text-center">Periode</th>
                            <th class="text-left px-3">Mata Pelajaran</th>
                            <th class="text-left px-3">Kitab</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center w-40">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($listmapel as $list)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="text-center py-3">
                                <a href="/report/{{ $list->id }}"
                                    class="text-blue-600 font-medium hover:underline">
                                    {{ $loop->iteration }}
                                </a>
                            </td>

                            <td class="text-center">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">
                                    {{ $list->periode }} {{ $list->ket_semester }}
                                </span>
                            </td>

                            <td class="px-3">
                                <a href="{{ url('/mapel/'.$list->id) }}"
                                    class="text-blue-600 font-semibold hover:underline">
                                    {{ $list->mapel }}
                                </a>
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

                                    <a href="/edit-mapel/{{ $list->id }}"
                                        class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg">
                                        Edit
                                    </a>

                                    <form action="/mapel/{{ $list->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            onclick="return confirm('Yakin hapus: {{ $list->mapel }}?')"
                                            class="px-3 py-1 text-xs bg-red-100 text-red-600 hover:bg-red-200 rounded-lg">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-8">
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