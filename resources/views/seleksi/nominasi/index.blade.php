<x-app-layout>
    @if($kelasmi !== null)

    @section('title','| Nilai Lager : '.$kelasmi->nama_kelas )
    @else
    @section('title','| Lager' )
    @endif
    <x-slot name="header">
        @section('title', ' | Nilai Lager' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nilai Lager') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1  gap-2 px-2 py-2">
        <div class="">
            <div class=" w-full ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" w-full   grid grid-cols-2">
                            <div class=" w-full p-4">
                                <form action="/juara-pararel" method="get" class="  text-sm gap-1 flex">
                                    <select name="kelasmi_id" id="" class="  w-full sm:w-1/2 py-1 dark:bg-dark-bg" required>
                                        @foreach ($dataKelasMi as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                            {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class=" px-2 bg-blue-500   text-white">
                                        Cari </button>
                                    <a href="/juara-pararel" class=" bg-blue-500 px-2 py-1 text-white">Reset</a>
                                    <a href="/nilaimapel" class=" bg-blue-500 px-2 py-1 text-white">Kembali</a>
                                </form>
                            </div>
                            <div class=" justify-end grid">
                                <div class=" py-4  px-2">
                                    <button class="flex text-white rounded-md  bg-green-600 px-2 py-1 " onclick="printContent('div1')">
                                        Cetak</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class=" w-full ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        @if($kelasmi)
                        <div id="div1" class="p-4 mt-2  bg-white  shadow-md dark:bg-dark-eval-1">
                            <center>
                                <div class=" text-center text-green-900  tracking-wider flex">
                                    <div class="">
                                        <img src={{ asset("asset/images/logo.png") }} alt="" width="100" class="  mb-1    ">
                                    </div>
                                    <div class=" w-full ">
                                        @if($kelasmi->jenjang === "Wustho")
                                        <div class="grid   justify-items-center     ">
                                            </p>
                                            <p class="   text-lg uppercase font-semibold tracking-widest ">departemen pendidikan diniyah wahidiyah</p>
                                            <p class="font-semibold text-3xl uppercase">
                                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                                            </p>
                                            <p class="font-semibold uppercase  tracking-widest">
                                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                                            </p>
                                        </div>
                                        @elseif($kelasmi->jenjang === "Ulya")
                                        <p class="font-semibold text-3xl uppercase">
                                            MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                                        </p>
                                        <p class="font-semibold uppercase  tracking-widest">
                                            TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                                        </p>
                                        @elseif($kelasmi->jenjang === "Ula")
                                        <p class="font-semibold text-3xl uppercase">
                                            MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                                        </p>
                                        <p class="font-semibold uppercase  tracking-widest">
                                            TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </center>
                            <hr class=" border-b-2 border-green-900">
                            <hr class=" mt-0.5 border-b-1 border-green-900">
                            <div class=" mt-2 ">
                                <div class=" uppercase grid justify-center text-green-900 font-semibold tracking-widest">
                                    Daftar Nilai Lager Kelas : {{$kelasmi->nama_kelas}}
                                </div>
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border border-black text-sm">
                                            <th class="border border-black">No</th>
                                            <th class="border border-black">Nama Siswa</th>
                                            <th class="border border-black -rotate-90">Kelas</th>
                                            @php
                                            $subjectNames = [];
                                            @endphp
                                            @foreach($mapel as $m)
                                            @if(!in_array($m->mapel, $subjectNames))
                                            <th class="rotate-90  h-36  w-16  border border-black ">{{ $m->mapel }}</th>
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
                                        <tr class="border border-black even:bg-gray-100 text-xs">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="border border-black px-2 capitalize">{{ strtolower($s->nama_siswa) }}</td>
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


                                                @if($nilaiHarian == 0)
                                                <span class="text-red-600">00</span>
                                                @elseif($nilaiHarian < 60) <span class="text-red-600">{{ str_pad($nilaiHarian, 2, '0', STR_PAD_LEFT) }}</span>
                                                    @else
                                                    {{ str_pad($nilaiHarian, 2, '0', STR_PAD_LEFT) }}
                                                    @endif

                                                    /
                                                    @if($nilaiUjian == 0)
                                                    <span class="text-red-600">00</span>
                                                    @elseif($nilaiUjian < 60) <span class="text-red-600">{{ str_pad($nilaiUjian, 2, '0', STR_PAD_LEFT) }}</span>
                                                        @else
                                                        {{ str_pad($nilaiUjian, 2, '0', STR_PAD_LEFT) }}
                                                        @endif

                                            </td>
                                            @endforeach
                                            <td class="text-center border border-black text-sm">
                                                @if($totalNilai < 600) <span class="text-red-600"> {{ $totalNilai }}</span>
                                                    @else
                                                    {{ $totalNilai }}
                                                    @endif
                                            </td>
                                            <td class="text-center border border-black  ">
                                                @if($totalNilai < 600) <span class=" justify-center grid text-red-600 font-semibold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    </span>
                                                    @else
                                                    <span class=" justify-center grid font-semibold text-green-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>

                                                    </span>
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
                            <span class=" capitalize">pilih kelas </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>