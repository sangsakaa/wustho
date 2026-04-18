<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kurikulum')
        <h2 class="font-semibold text-xl text-gray-800">
            Daftar Mata Pelajaran & Kurikulum
        </h2>
    </x-slot>

    <!-- ACTION -->
    <div class="px-4 py-3">
        <div class="flex justify-between items-center">
            <a href="/addmapel"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Mapel
            </a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="px-4 pb-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">

            <!-- ALERT -->
            @if (session('delete'))
            <div class="mb-3 px-4 py-2 rounded-lg bg-red-100 text-red-700 text-sm">
                {{ session('delete') }}
            </div>
            @endif

            @if (session('success'))
            <div class="mb-3 px-4 py-2 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @if (session('update'))
            <div class="mb-3 px-4 py-2 rounded-lg bg-blue-100 text-blue-700 text-sm">
                {{ session('update') }}
            </div>
            @endif

            <!-- TABLE -->
            <div class="overflow-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">

                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="py-2 border text-center">No</th>
                            <th class="border text-center">Periode</th>
                            <th class="border text-left px-3">Mata Pelajaran</th>
                            <th class="border text-left px-3">Kitab</th>
                            <th class="border text-center">Kelas</th>
                            <th class="border text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($listmapel as $list)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border text-center py-2">
                                <a href="/report/{{ $list->id }}" class="text-blue-600 hover:underline">
                                    {{ $loop->iteration }}
                                </a>
                            </td>

                            <td class="border text-center">
                                {{ $list->periode }} {{ $list->ket_semester }}
                            </td>

                            <td class="border px-3">
                                {{ $list->mapel }}
                            </td>

                            <td class="border px-3">
                                {{ $list->nama_kitab }}
                            </td>

                            <td class="border text-center">
                                {{ $list->kelas }}
                            </td>

                            <td class="border">
                                <div class="flex justify-center gap-2 py-1">

                                    <!-- EDIT -->
                                    <a href="/edit-mapel/{{ $list->id }}"
                                        class="px-3 py-1 text-xs bg-yellow-400 hover:bg-yellow-500 text-black rounded-md">
                                        Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form action="/mapel/{{ $list->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            onclick="return confirm('Yakin hapus: {{ $list->mapel }}?')"
                                            class="px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded-md">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">
                                Data mata pelajaran belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>