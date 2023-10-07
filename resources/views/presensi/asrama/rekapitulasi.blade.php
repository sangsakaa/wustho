<x-app-layout>
    <x-slot name="header">
        @section('title', '| REKAP HARIAN : '. $tgl->isoFormat('dddd, D MMMM YYYY'))
        <h2 class="font-semibold text-xl leading-tight">
            Rekap Absensi Asrama : <br> {{($tgl->isoFormat('dddd, D MMMM YYYY')) }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200  flex grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <div>
                        <form action="/rekap-harian/" method="get" class="w-full">
                            {{-- @csrf --}}
                            <input type="date" name="tgl" class=" py-1 dark:bg-dark-bg" value="{{ $tgl->toDateString() }}">
                            <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                Pilih
                            </button>
                        </form>
                    </div>
                    <div>
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
                            Cetak
                        </button>
                    </div>
                    <div class=" py-1 px-4 my-1 justify-end">
                        <a href="/sesiasrama" class=" text-white py-1  px-2 bg-red-600">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    @if($rekapAbsensi)
    <div class="py-1" id="blanko">
        <div class="bg-white dark:bg-dark-bg  shadow-sm ">
            <div class=" p-1 ">
                <div class=" bg-white dark:bg-dark-bg  ">
                    <div class=" grid grid-cols-2">
                        <div class=" text-green-900  text-sm font-semibold">
                            Hari, tanggal : {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
                        </div>
                    </div>
                    <div class=" overflow-auto ">
                        <table class="table-fixed w-full text-green-900 my-2">
                            <thead class="border border-b-2 border-green-600">
                                <tr class="border  border-green-600 text-xs sm:text-sm">
                                    <th class="border border-green-600 px-1 w-8">No</th>
                                    <th class="border border-green-600 px-1 w-1/12">Kegiatan</th>
                                    <th class="border border-green-600 px-1 w-1/12 ">Asrama</th>
                                    <th class="border border-green-600 px-1 w-11 ">Total</th>
                                    <th class="border border-green-600 px-1 w-11">Tidak Hadir</th>
                                    <th class="border border-green-600 px-1 w-11">Hadir</th>
                                    <th class="border border-green-600 px-1 w-1/4 sm:w-1/2 ">Yang tidak hadir</th>
                                    <th class="border border-green-600 px-1 w-10 sm:w-11 ">Ket</th>
                                    <th class="border border-green-600 px-1 w-1/7  ">Alasan</th>

                                    <th class="border border-green-600 px-1  w-1/12 ">Presentase <br> Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class=" text-sm">
                                @php
                                $nomor = 1;
                                @endphp
                                @foreach ($rekapAbsensi as $nama_kegiatan => $dataKegiatan)
                                @foreach($dataKegiatan as $nama_asrama => $dataAbsensi)
                                @foreach($dataAbsensi['absensi'] as $absensi)
                                <tr class=" border border-green-600 text-xs sm:text-sm ">
                                    @if($loop->first)
                                    <td class="border border-green-600 text-center px-1 border-b-red-600 border-b-4 font-semibold" rowspan="{{ $dataAbsensi['row'] }}">{{$nomor++}}</td>
                                    @endif
                                    @if ($loop->parent->first && $loop->first)
                                    @if($dataKegiatan->sum('row') <= 4 ) <td class=" border border-green-600 text-sm  font-semibold    border-b-red-600 border-b-4  text-center " rowspan="{{ $dataKegiatan->sum('row') }}">
                                        {{ $nama_kegiatan }}
                                        </td>
                                        @else
                                        <td class=" border border-green-600 text-sm -rotate-90 whitespace-nowrap font-semibold    border-b-red-600 border-b-4  text-center " rowspan="{{ $dataKegiatan->sum('row') }}">
                                            {{ $nama_kegiatan }}
                                            @endif
                                            @endif
                                            @if($loop->first)
                                        <td class="border border-green-600 px-1 text-sm  font-semibold capitalize text-center border-b-red-600 border-b-4 " rowspan="{{$dataAbsensi['row']}}">{{$nama_asrama}}</td>
                                        <td class="border border-green-600 px-1  font-semibold capitalize text-center text-md border-b-red-600 border-b-4 " rowspan="{{$dataAbsensi['row']}}">{{$dataAbsensi['total']}}</td>
                                        <td class="border border-green-600 px-1  font-semibold capitalize text-center text-md border-b-red-600 border-b-4 " rowspan="{{$dataAbsensi['row']}}">{{$dataAbsensi['tidakHadir']}}</td>
                                        <td class="border border-green-600 px-1  font-semibold capitalize text-center text-md border-b-red-600 border-b-4 " rowspan="{{$dataAbsensi['row']}}">{{$dataAbsensi['hadir']}}</td>
                                        @endif
                                        <td class="border border-green-600 px-1 text-xs capitalize {{$loop->last ? 'border-b-red-600 border-b-4' : ''}}">
                                            {{ $dataAbsensi['tidakHadir'] !== 0 ? $loop->iteration . '. ' . strtolower($absensi->nama_siswa) : 'NIHIL'  }}
                                        </td>
                                        <td class="border border-green-600 px-1 text-center capitalize {{$loop->last ? 'border-b-red-600 border-b-4' : ''}}">{{ $dataAbsensi['tidakHadir'] !== 0 ? $absensi->keterangan : 'NIHIL' }}</td>
                                        <td class="border border-green-600 px-1 text-center capitalize {{$loop->last ? 'border-b-red-600 border-b-4' : ''}}">{{ $dataAbsensi['tidakHadir'] !== 0 ? $absensi->alasan : 'NIHIL' }}</td>

                                        @if ($loop->first)
                                        <td class="border border-green-600 text-center px-1 border-b-red-600 border-b-4 font-semibold text-2xl" rowspan="{{ $dataAbsensi['row'] }}">{{ number_format($dataAbsensi['persentase'], 1, ',') }}%</td>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>