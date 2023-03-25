<x-app-layout>
    <x-slot name="header">
        @section('title','| NOMINASI : ' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white   px-2 py-2 gap-2">
        <table>
            <thead>
                <tr class=" border text-xs uppercase">
                    <th class=" border  w-10   h-40  ">No</th>
                    <th class=" border   ">Siswa</th>
                    <th class=" border -rotate-90   ">Kelas</th>
                    @foreach ($mapel as $m)
                    <th class=" border -rotate-90   ">{{ $m->mapel }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $s)
                <tr class=" border">
                    <td class=" text-center ">{{ $loop->iteration }}</td>
                    <td class=" border w-1/4 capitalize px-1">{{ strtolower($s->nama_siswa) }}</td>
                    <td class="  w-5 text-center">{{$s->nama_kelas}}</td>
                    @foreach ($mapel as $m)
                    <td class=" border text-center  text-sm font-semibold">
                        @if (isset($nilaiPesertaKelasMap->where('pesertakelas_id', $s->id)->first()[$s->nama_siswa][$m->mapel]))
                        {{ $nilaiPesertaKelasMap->where('pesertakelas_id', $s->id)->first()[$s->nama_siswa][$m->mapel]['nilaiHarian'] }}
                        /
                        {{ $nilaiPesertaKelasMap->where('pesertakelas_id', $s->id)->first()[$s->nama_siswa][$m->mapel]['nilaiUjian'] }}
                        @else
                        <span class=" text-center  text-red-600  ">X</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>



    </div>
</x-app-layout>