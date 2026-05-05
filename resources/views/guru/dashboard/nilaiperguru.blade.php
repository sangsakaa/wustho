<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Nilai Per Guru')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Detail Nilai Per Guru
        </h2>
    </x-slot>

    <div class="py-4 px-4 space-y-4">

        <!-- CARD INFO GURU -->
        <div class="bg-white dark:bg-dark-bg shadow rounded-xl overflow-hidden">
            <div class="p-6 text-center">
                <h3 class="text-xl font-bold text-gray-900">
                    {{ $title->nama_guru }}
                </h3>

                <p class="uppercase text-xs text-gray-500 mt-2">
                    Nomor Induk Guru
                </p>

                <p class="text-lg font-semibold text-blue-600">
                    {{ $title->nig }}
                </p>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white dark:bg-dark-bg shadow rounded-xl overflow-hidden">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    Detail Nilai Mata Pelajaran
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border px-3 py-2">No</th>
                                <th class="border px-3 py-2 hidden md:table-cell">Periode</th>
                                <th class="border px-3 py-2">Mapel</th>
                                <th class="border px-3 py-2">Kelas</th>
                                <th class="border px-3 py-2">Jumlah</th>
                                <th class="border px-3 py-2">NH</th>
                                <th class="border px-3 py-2">HU</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($dataguru as $guru)
                            <tr class="hover:bg-gray-50 even:bg-gray-50">
                                <td class="border px-3 py-2 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-3 py-2 text-center hidden md:table-cell">
                                    {{ $guru->periode }} {{ $guru->ket_semester }}
                                </td>

                                <td class="border px-3 py-2 text-center">
                                    <a href="/nilai/{{ $guru->id }}"
                                        class="text-blue-600 hover:underline font-medium">
                                        {{ $guru->mapel }}
                                    </a>
                                </td>

                                <td class="border px-3 py-2 text-center">
                                    <a href="/nilai/{{ $guru->id }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $guru->nama_kelas }}
                                    </a>
                                </td>

                                <td class="border px-3 py-2 text-center font-semibold">
                                    {{ $guru->jumlah_peserta_kelas }}
                                </td>

                                <td class="border px-3 py-2 text-center">
                                    {{ $guru->jumlah_nilai_harian }}
                                </td>

                                <td class="border px-3 py-2 text-center">
                                    {{ $guru->jumlah_nilai_ujian }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-red-500">
                                    Tidak ada data nilai guru
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>