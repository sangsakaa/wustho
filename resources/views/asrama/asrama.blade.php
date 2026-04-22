<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Asrama')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Asrama
        </h2>
    </x-slot>

    {{-- ACTION BUTTON --}}
    <div class="px-4 mt-4">
        <div class="bg-white shadow-sm rounded-lg p-3 flex flex-wrap gap-2 justify-end">

            <a href="/addasrama"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm flex items-center gap-1">
                ➕ Tambah Asrama
            </a>

            <a href="/asramasiswa"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm">
                Asrama Siswa
            </a>

            <a href="/sesiasrama"
                class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm uppercase">
                Presensi Harian
            </a>

        </div>
    </div>

    {{-- CONTENT --}}
    <div class="mt-4 px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- PUTRA --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-4 py-2 font-semibold">
                    Daftar Asrama Putra
                </div>

                <div class="p-2 overflow-x-auto">
                    <table class="w-full text-sm border">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 border w-10">#</th>
                                <th class="p-2 border text-left">Asrama</th>
                                <th class="p-2 border text-center">Type</th>
                                @role('super admin')
                                <th class="p-2 border text-center w-20">Aksi</th>
                                @endrole
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Putra as $buah)
                            <tr class="hover:bg-blue-50">
                                <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                                <td class="p-2 border">{{ $buah->nama_asrama }}</td>
                                <td class="p-2 border text-center">
                                    <span class="px-2 py-1 text-xs rounded bg-gray-200">
                                        {{ $buah->type_asrama }}
                                    </span>
                                </td>

                                @role('super admin')
                                <td class="p-2 border text-center">
                                    <form action="/asrama/{{ $buah->id }}" method="POST"
                                        onsubmit="return confirm('Hapus asrama ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                                @endrole
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center p-4 text-gray-500">
                                    Tidak ada data Asrama Putra
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PUTRI --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="bg-pink-600 text-white px-4 py-2 font-semibold">
                    Daftar Asrama Putri
                </div>

                <div class="p-2 overflow-x-auto">
                    <table class="w-full text-sm border">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 border w-10">#</th>
                                <th class="p-2 border text-left">Asrama</th>
                                <th class="p-2 border text-center">Type</th>
                                @role('super admin')
                                <th class="p-2 border text-center w-20">Aksi</th>
                                @endrole
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Putri as $buah)
                            <tr class="hover:bg-pink-50">
                                <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                                <td class="p-2 border">{{ $buah->nama_asrama }}</td>
                                <td class="p-2 border text-center">
                                    <span class="px-2 py-1 text-xs rounded bg-gray-200">
                                        {{ $buah->type_asrama }}
                                    </span>
                                </td>

                                @role('super admin')
                                <td class="p-2 border text-center">
                                    <form action="/asrama/{{ $buah->id }}" method="POST"
                                        onsubmit="return confirm('Hapus asrama ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                                @endrole
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center p-4 text-gray-500">
                                    Tidak ada data Asrama Putri
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- INFO --}}
    <div class="px-4 mt-4">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-gray-700">
            <p class="font-semibold mb-1">📌 Keterangan:</p>
            <ul class="list-decimal ml-5 space-y-1">
                <li>Tambah data <b>asrama</b> jika belum tersedia.</li>
                <li>Pisahkan data berdasarkan Putra & Putri untuk manajemen lebih rapi.</li>
                <li>Gunakan menu presensi untuk absensi harian santri.</li>
            </ul>
        </div>
    </div>

</x-app-layout>