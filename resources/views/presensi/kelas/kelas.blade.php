<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:text-left text-center">
            {{ __('Dashboard Presensi Kelas') }}
        </h2>
    </x-slot>
    <div class="p-2 md:p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" w-full ">
                        <div class=" overflow-auto">
                            <div class=" overflow-auto">
                                <Table class=" w-full  border-collapse border border-slate-500 mt-2 ">
                                    <thead>
                                        <tr class=" text-xs border bg-gray-100 ">
                                            <th class=" text-xs py-1">No</th>
                                            <th>Periode</th>
                                            <th>Kelas</th>
                                            <th>Nama Kelas</th>
                                            <th class=" text-xs text-center">Kapasitas</th>
                                            <th class=" text-xs text-center">Jml Peserta</th>
                                            <th class=" text-xs text-center">Presensi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @if ($kelasMI->count() != null)
                                        @foreach ($kelasMI as $item)
                                        <tr class=" hover:bg-green-200 border">
                                            <th class=" text-xs text-center border">{{ $loop->iteration }}</th>
                                            <td class=" text-xs text-center border"> {{ $item->periode }}
                                                {{ $item->ket_semester }}
                                            </td>
                                            <td class=" text-xs text-center border"><a href="/presensikelas/{{ $item->id }}">
                                                    {{ $item->kelas }}</a></td>
                                            <td class=" text-xs text-center py-2"><a href="/presensikelas/{{ $item->id }}" class=" text-xs bg-blue-600 text-white py-1 px-2 rounded-md hover:bg-purple-600">Kelas
                                                    {{ $item->nama_kelas }}</a></td>
                                            <td class=" text-xs text-center border"> {{ $item->kuota }}</td>
                                            <td class=" text-xs text-center border">
                                                {{ $item->jumlah_nilai_ujian }}
                                            </td>
                                            <td class=" text-xs px-2 border text-center w-40">

                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class=" border text-center" colspan="5">
                                                Data Tidak ditemukan
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </Table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>