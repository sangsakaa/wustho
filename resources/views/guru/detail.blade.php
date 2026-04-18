<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Detail Guru') }}
        </h2>
    </x-slot>

    <div class="p-2 space-y-2">

        {{-- DETAIL GURU --}}
        <div class="bg-white shadow-sm border rounded">
            <div class="p-4 grid grid-cols-1 md:grid-cols-4 gap-2">

                <div class="font-semibold">Nama Lengkap</div>
                <div>: {{$guru->nama_guru}}</div>

                <div class="font-semibold">Jenis Kelamin</div>
                <div>: {{$guru->jenis_kelamin}}</div>

            </div>
        </div>

        {{-- RIWAYAT MENGAJAR --}}
        <div class="bg-white shadow-sm border rounded p-2">

            {{-- BUTTON --}}
            <div class="mb-2 flex gap-2">
                <a href="/guru" class="text-white px-2 py-1 bg-sky-500 rounded">
                    Kembali
                </a>

                <a href="/nig/{{$guru->id}}" class="text-white px-2 py-1 bg-sky-500 rounded">
                    Nomor Induk Guru
                </a>
            </div>

            <h3 class="font-semibold mb-2">Riwayat Mengajar</h3>

            <div class="overflow-x-auto">
                <table class="w-full border text-sm">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1 text-center">No</th>
                            <th class="border px-2 py-1 text-center">Periode</th>
                            <th class="border px-2 py-1 text-center">Nama Guru</th>
                            <th class="border px-2 py-1 text-center">Kelas</th>
                            <th class="border px-2 py-1 text-center">Mata Pelajaran</th>
                            <th class="border px-2 py-1 text-center">Kitab</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($riwayatMengajar as $ngajar)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-1 text-center">
                                {{$loop->iteration}}
                            </td>
                            <td class="border px-2 py-1 text-center">
                                {{$ngajar->periode}} {{$ngajar->ket_semester}}
                            </td>
                            <td class="border px-2 py-1 text-center">
                                {{$ngajar->nama_guru}}
                            </td>
                            <td class="border px-2 py-1 text-center">
                                {{$ngajar->nama_kelas}}
                            </td>
                            <td class="border px-2 py-1 text-center">
                                {{$ngajar->mapel}}
                            </td>
                            <td class="border px-2 py-1 text-center">
                                {{$ngajar->nama_kitab}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-500">
                                Tidak ada riwayat mengajar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</x-app-layout>