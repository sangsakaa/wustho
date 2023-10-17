<x-app-layout>
    @if($kelasmi !== null)

    @section('title','| Rekap Nilai : '.$kelasmi->nama_kelas )
    @else

    @section('title','Kelas 2' )
    @endif
    <x-slot name="header">
        <div class="flex bg-white dark:bg-dark-eval-0 flex-col gap-2 py-2 justify-between px-4 md:flex-row md:items-center md:justify-between">

        </div>
    </x-slot>
    <div class="p-6 overflow-hidden bg-white  shadow-md dark:bg-dark-eval-1">
        <div class=" w-full  py-1 grid grid-cols-2">
            <div class=" w-full">
                <form action="/Rekapitulasi-Nilai-Siswa" method="get" class="  text-sm gap-1 flex">
                    <select name="kelasmi_id" id="" class="  w-full sm:w-1/2 py-1 dark:bg-dark-bg" required>
                        @foreach ($dataKelasMi as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                            {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class=" px-2 bg-blue-500   text-white">
                        Cari </button>
                    <a href="/Rekapitulasi-Nilai-Siswa" class=" bg-blue-500 px-2 py-1 text-white">Reset</a>
                </form>
            </div>
            <div class=" justify-end grid">
                <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                    Cetak Rekap Nilai</button>
                <script>
                    function printContent(el) {
                        var fullbody = document.body.innerHTML;
                        var printContent = document.getElementById(el).innerHTML;
                        document.body.innerHTML = printContent;
                        window.print();
                        document.body.innerHTML = fullbody;
                    }
                </script>
            </div>
        </div>
        @if($kelasmi)

        <div id="div1" class=" ">
            <center>
                <div class=" text-center text-green-900 mt-5">
                    <p class=" font-semibold text-3xl">
                        MADRASAH DINIYAH WUSTHO WAHIDIYAH
                    </p>
                    <p class=" font-semibold uppercase">
                        TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                    </p>
                </div>
                <p class="  uppercase font-semibold">
                    daftar Nilai Kelas {{$kelasmi->nama_kelas}} </p>
            </center>
            <table class="w-full">
                <thead>
                    <tr class="border border-black text-sm">
                        <th class="border border-black">No</th>
                        <th class="border border-black">Nama Siswa</th>
                        <th class="border border-black -rotate-90">Kelas</th>
                        <th class="border border-black -rotate-90">Nama Kelas</th>
                        @php
                        $subjectNames = [];
                        @endphp
                        @foreach($mapel as $m)
                        @if(!in_array($m->mapel, $subjectNames))
                        <th class="rotate-90 h-48 border border-black">{{ $m->mapel }}</th>
                        @php
                        $subjectNames[] = $m->mapel;
                        @endphp
                        @endif
                        @endforeach
                        <th class="border border-black -rotate-90">Total</th>
                        <th class="border border-black -rotate-90">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    <tr class="border border-black even:bg-gray-100 text-sm">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="border border-black px-2 capitalize">{{ strtolower($s->nama_siswa) }}</td>
                        <td class="border border-black px-2 text-center">{{ $s->kelas }}</td>
                        <td class="border border-black px-2 text-center">{{ $s->nama_kelas }}</td>
                        @php
                        $totalNilai = 0;
                        @endphp
                        @foreach($subjectNames as $subjectName)
                        @php
                        $nilaiHarian = 0;
                        $nilaiUjian = 0;
                        @endphp
                        @foreach($nilaiPesertaKelasMap as $n)
                        @if($n['pesertakelas_id'] == $s->id && isset($n[$s->nama_siswa][$subjectName]))
                        @php
                        $nilaiHarian += $n[$s->nama_siswa][$subjectName]['nilaiHarian'];
                        $nilaiUjian += $n[$s->nama_siswa][$subjectName]['nilaiUjian'];
                        $totalNilai += $nilaiHarian + $nilaiUjian;
                        @endphp
                        @endif
                        @endforeach
                        <td class="text-center border border-black px-1 text-sm">
                            <span>
                                @if($nilaiHarian < 60) <span class="text-red-600">{{ $nilaiHarian }}</span>
                            @else
                            {{ $nilaiHarian }}
                            @endif
                            /
                            @if($nilaiUjian < 60) <span class="text-red-600">{{ $nilaiUjian }}</span>
                                @else
                                {{ $nilaiUjian }}
                                @endif
                                </span>
                        </td>
                        @endforeach
                        <td class="text-center border border-black text-sm">
                            @if($totalNilai < 600) <span class="text-red-600"> {{ $totalNilai }}</span>
                                @else
                                {{ $totalNilai }}
                                @endif
                        </td>
                        <td class="text-center border border-black">
                            @if($totalNilai < 600) <span class="text-red-600"> Tidak Lulus</span>
                                @else
                                Lulus
                                @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @else
    <div class=" p-6 bg-yellow-300">
        <span class=" ">Pilih Kelas 1 dan 2</span>

    </div>
    @endif
</x-app-layout>