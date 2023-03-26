<x-app-layout>
    @section('title', '| Dashboard ' )
    <x-slot name="header">
        <div class="flex bg-white dark:bg-dark-eval-0 flex-col gap-2 py-2 justify-between px-4 md:flex-row md:items-center md:justify-between">

        </div>
    </x-slot>
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class=" w-full  py-1 grid grid-cols-2">
            <div class=" w-full">

                <form action="/juara-pararel" method="get" class="  text-sm gap-1 flex">

                    <select name="cari" id="" class=" py-1 w-full ">
                        @foreach($dataKelasMi as $kelas)
                        <option value="{{ $kelas->nama_kelas }}" {{ $kelasmi?->id == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class=" px-2 bg-blue-500   text-white">
                        Cari </button>
                    <a href="/juara-pararel" class=" bg-blue-500 px-2 py-1 text-white">Reset</a>
                </form>
            </div>
        </div>
        <div id="div1" class=" ">
            <table class=" w-full">
                <thead>
                    <tr class=" border text-sm">
                        <th class=" border">No</th>
                        <th class=" border">Nama Siswa</th>
                        <th class=" border -rotate-90">Kelas</th>
                        <th class=" border -rotate-90 ">Nama Kelas</th>
                        @foreach($mapel as $m)
                        <th class=" rotate-90  h-48  border">{{ $m->mapel }}</th>
                        @endforeach
                        <th class=" border -rotate-90 ">total</th>
                        <th class=" border -rotate-90 ">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    <tr class="border even:bg-gray-100 text-sm">
                        <td class=" text-center">{{$loop->iteration}}</td>
                        <td class="border px-2  capitalize">{{ strtolower($s->nama_siswa) }}</td>
                        <td class="border px-2 text-center">{{ $s->kelas }}</td>
                        <td class="border px-2 text-center">{{ $s->nama_kelas }}</td>
                        @php
                        $totalNilai = 0;
                        @endphp
                        @foreach($mapel as $m)
                        <td class=" text-center border px-1 text-sm   ">
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
                        <td class="   text-center border text-sm  ">
                            @if($totalNilai < 800) <span class=" text-red-600"> {{ $totalNilai }}</span> @else {{ $totalNilai }} @endif </td>
                        <td class="   text-center border ">
                            @if($totalNilai < 800) <span class=" text-red-600"> Tidak Lulus</span> @else Lulus @endif </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>