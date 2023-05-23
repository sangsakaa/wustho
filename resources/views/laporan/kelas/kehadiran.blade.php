<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Laporan Kehadiran') }}
            </h2>
        </div>
    </x-slot>
    <div class=" px-4 py-1  w-full bg-white ">
        <div class=" flex  grid-cols-2  gap-1 ">
            <div class=" mt-1">
                <button class="  w-10 justify-center text-white   bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                    <x-icons.print></x-icons.print>
                </button>
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
    </div>
    <div id="div1">
        <div class=" bg-white px-2 ">
            <center>
                <div class=" uppercase text-green-800  block sm:hidden">
                    <p class=" text-2xl">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                    <p class=" text-3xl">Laporan Kehadiran</p>
                    <p class=" text-md">Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}}{{$periode = $kelasmi->ket_semester ?? ' ';}}</p>

                    <hr class=" border border-b-2 border-green-800">
            </center>
            <table class=" w-full ">
                <thead>
                    <tr>
                        <th class=" border border-green-800 px-1">Nama Kelas</th>
                        <th class=" border border-green-800 px-1">Total Kelas</th>
                        <th class=" border border-green-800 px-1">Nama Siswa</th>
                        <th class=" border border-green-800 px-1">Total Alfa</th>
                        <th class=" border border-green-800 px-1">Total Sakit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $currentKelas = null;
                    @endphp
                    @foreach($data as $item)
                    <tr>
                        @if($currentKelas !== $item->nama_kelas)
                        @php
                        $currentKelas = $item->nama_kelas;
                        $rowCount = $data->where('nama_kelas', $item->nama_kelas)->count();
                        @endphp
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{ $item->nama_kelas }}
                        </td>
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{$data->where('nama_kelas', $item->nama_kelas)->count()}}
                        </td>
                        @endif

                        <td class="border border-green-800 px-1 py-1 capitalize">{{$loop->iteration}}. {{ strtolower($item->nama_siswa) }}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_alfa }}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_sakit }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>


        </div>
    </div>
</x-app-layout>