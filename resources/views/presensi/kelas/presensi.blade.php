<x-app-layout>
    <x-slot name="header">
        @section('title', '| Presensi Kelas : ' . $dataKelas->nama_kelas)

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center sm:text-left">
                Dashboard Presensi Kelas
            </h2>
        </div>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto px-4 space-y-6">

        {{-- INFO KELAS --}}
        <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-blue-600">Presensi Kelas</h3>
                <p class="text-xs text-gray-500">Kelola kehadiran siswa per kelas</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="space-y-2">
                    <div class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">Kelas / Semester</span>
                        <span class="font-semibold text-gray-800">
                            {{ $dataKelas->nama_kelas }} / {{ $dataKelas->semester }}
                        </span>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">Periode</span>
                        <span class="font-semibold text-gray-800">
                            {{ $dataKelas->periode }} {{ $dataKelas->ket_semester }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM PRESENSI --}}
        <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">

            <form action="/presensikelas" method="post">
                @csrf

                {{-- ACTION BAR --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 border-b bg-gray-50">
                    <div class="flex gap-2">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                            💾 Simpan Presensi
                        </button>

                        <a href="/presensikelas"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                            ← Kembali
                        </a>
                    </div>

                    {{-- ALERT --}}
                    <div class="space-y-1 text-sm">
                        @if (session('delete'))
                        <div class="bg-red-100 text-red-700 px-3 py-1 rounded-lg">
                            {{ session('delete') }}
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="bg-green-100 text-green-700 px-3 py-1 rounded-lg">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if (session('update'))
                        <div class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg">
                            {{ session('update') }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-center">No</th>
                                <th class="px-4 py-3 text-center">NIS</th>
                                <th class="px-4 py-3 text-left">Nama Siswa</th>
                                <th class="px-4 py-3 text-center">Kelas</th>
                                <th class="px-4 py-3 text-center">Nama Kelas</th>
                                <th class="px-4 py-3 text-center">Izin</th>
                                <th class="px-4 py-3 text-center">Sakit</th>
                                <th class="px-4 py-3 text-center">Alfa</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($dataSiswa as $item)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-3 text-center">
                                    {{ $loop->iteration }}

                                    <input type="hidden" name="pesertakelas[]" value="{{ $item->id }}">
                                    <input type="hidden" name="presensikelas_id[{{ $item->id }}]"
                                        value="{{ $item->presensikelas_id }}">
                                </td>

                                <td class="px-4 py-3 text-center text-gray-600">
                                    {{ $item->nis }}
                                </td>

                                <td class="px-4 py-3 capitalize font-medium text-gray-800">
                                    {{ strtolower($item->nama_siswa) }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $item->kelas }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $item->nama_kelas }}
                                </td>

                                <td class="px-2 py-2">
                                    <input type="number"
                                        name="izin[{{ $item->id }}]"
                                        value="{{ $item->izin }}"
                                        class="w-16 text-center border rounded-lg py-1 focus:ring-2 focus:ring-green-400 outline-none">
                                </td>

                                <td class="px-2 py-2">
                                    <input type="number"
                                        name="sakit[{{ $item->id }}]"
                                        value="{{ $item->sakit }}"
                                        class="w-16 text-center border rounded-lg py-1 focus:ring-2 focus:ring-yellow-400 outline-none">
                                </td>

                                <td class="px-2 py-2">
                                    <input type="number"
                                        name="alfa[{{ $item->id }}]"
                                        value="{{ $item->alfa }}"
                                        class="w-16 text-center border rounded-lg py-1 focus:ring-2 focus:ring-red-400 outline-none">
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>