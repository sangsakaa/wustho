<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Nilai Transkip')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Data Nilai Transkip
        </h2>
    </x-slot>

    <div class="px-3 py-3 space-y-3">

        <!-- MENU -->
        <div class="bg-white shadow-sm rounded-lg p-3 flex flex-wrap gap-2">
            <a href="/periode" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Periode
            </a>
            <a href="/pengaturan" class="px-3 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Pengaturan
            </a>
            <a href="/daftar-transkip" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">
                Daftar Transkip
            </a>
        </div>

        <!-- INFO -->
        <div class="bg-white shadow-sm rounded-lg p-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <p class="text-sm text-gray-500">Mata Pelajaran</p>
                <p class="font-semibold text-lg text-gray-800">
                    {{ $dataTranskip->mapel }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jenis Ujian</p>
                <p class="font-semibold text-lg text-gray-800">
                    {{ $dataTranskip->nama_ujian }}
                </p>
            </div>
        </div>

        <!-- FORM NILAI -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-gray-700">
                    Input Nilai Peserta
                </h3>
            </div>

            <div class="p-4 overflow-x-auto">

                <form action="/nilai_transkip/{{ $transkip->id }}" method="POST">
                    @csrf

                    <!-- ACTION -->
                    <div class="flex justify-between mb-3">
                        <div class="text-sm text-gray-500">
                            Isi nilai dengan rentang <span class="font-semibold text-red-500">65 - 100</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="/daftar-transkip"
                                class="px-3 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-4 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="transkip_id" value="{{ $transkip->id }}">

                    <!-- TABLE -->
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="border px-2 py-2 w-10">No</th>
                                <th class="border px-2 py-2 text-left">Nama Peserta</th>
                                <th class="border px-2 py-2 text-center w-20">Kelas</th>
                                <th class="border px-2 py-2 text-center w-32">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataLulusan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-2 py-1 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-2 py-1 capitalize">
                                    <input type="hidden" name="daftar_lulusan_id[]" value="{{ $item->id }}">
                                    <input type="hidden" name="nilai_transkip_id[{{ $item->id }}]" value="{{ $item->nilai_transkip_id }}">
                                    {{ strtolower($item->nama_siswa) }}
                                </td>

                                <td class="border px-2 py-1 text-center">
                                    {{ $item->nama_kelas }}
                                </td>

                                <td class="border px-2 py-1">
                                    <input
                                        type="number"
                                        name="nilai_akhir[{{ $item->id }}]"
                                        value="{{ $item->nilai_akhir }}"
                                        min="65"
                                        max="100"
                                        class="w-full border rounded px-2 py-1 text-center focus:ring focus:ring-blue-200"
                                        placeholder="65 - 100"
                                        required>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-red-500 font-semibold">
                                    Belum ada data peserta lulusan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </form>
            </div>
        </div>

    </div>
</x-app-layout>