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
        <table class=" w-full">
            <thead>
                <tr class=" border text-sm">
                    <th class=" border">No</th>
                    <th class=" border">Nama Siswa</th>
                    <th class=" border -rotate-90">Kelas</th>
                    <th class=" border -rotate-90">Nama Kelas</th>
                    @foreach($mapel as $m)
                    <th class=" rotate-90  h-48  border">{{ $m->mapel }}</th>
                    @endforeach
                    <th class=" border -rotate-90">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                <tr class="border even:bg-gray-100">
                    <td class=" text-center">{{$loop->iteration}}</td>
                    <td class="border px-2  capitalize">{{ strtolower($s->nama_siswa) }}</td>
                    <td class="border px-2 text-center">{{ $s->kelas }}</td>
                    <td class="border px-2 text-center">{{ $s->nama_kelas }}</td>
                    @php
                    $totalNilai = 0;
                    @endphp
                    @foreach($mapel as $m)
                    <td class=" text-center border px-1 w-15  ">
                        @foreach($nilaiPesertaKelasMap as $n)
                        @if($n['pesertakelas_id'] == $s->id && isset($n[$s->nama_siswa][$m->mapel]))
                        @php
                        $nilaiHarian = $n[$s->nama_siswa][$m->mapel]['nilaiHarian'];
                        $nilaiUjian = $n[$s->nama_siswa][$m->mapel]['nilaiUjian'];
                        $totalNilai += $nilaiHarian + $nilaiUjian;
                        @endphp
                        <span class="{{ ($nilaiHarian < 65 || $nilaiUjian < 65) ? 'text-red-500' : '' }}">
                            {{ $nilaiHarian }} / {{ $nilaiUjian }}
                        </span>
                        @endif
                        @endforeach
                    </td>
                    @endforeach
                    <td class="   text-center ">
                        @if($totalNilai < 800) <span class=" text-red-600"> Tidak| {{ $totalNilai }}</span> @else Lulus | {{ $totalNilai }} @endif </td>
                </tr>
                @endforeach
            </tbody>
        </table>




    </div>
</x-app-layout>