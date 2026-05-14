<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Guru
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- CARD GURU --}}
        <div class="bg-white shadow rounded-xl p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Nama Lengkap</p>
                    <p class="font-semibold text-lg">
                        {{ $guru->nama_guru ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jenis Kelamin</p>
                    <p class="font-semibold">
                        {{ $guru->jenis_kelamin ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ACTION + FILTER --}}
        <div class="bg-white shadow rounded-xl p-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">

            <div class="flex gap-2">
                <a href="/guru" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                    ← Kembali
                </a>

                <a href="/nig/{{ $guru->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                    NIG
                </a>
            </div>

            {{-- FILTER PERIODE --}}


        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow rounded-xl p-4">

            <h3 class="font-semibold mb-3">Riwayat Mengajar</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200">

                    <thead class="bg-gray-100 text-xs uppercase">
                        <tr>
                            <th class="border px-2 py-2">No</th>
                            <th class="border px-2 py-2">Periode</th>
                            <th class="border px-2 py-2">Kelas</th>
                            <th class="border px-2 py-2">Mapel</th>
                            <th class="border px-2 py-2">Kitab</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($riwayatMengajar as $i => $data)
                        <tr class="hover:bg-gray-50">

                            <td class="border px-2 py-1 text-center">
                                {{ $i+1 }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $data->periode ?? '-' }} <br>
                                <span class="text-xs text-gray-500">
                                    {{ $data->ket_semester ?? '-' }}
                                </span>
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $data->nama_kelas ?? '-' }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $data->mapel ?? '-' }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $data->nama_kitab ?? '-' }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-400">
                                Tidak ada data mengajar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</x-app-layout>