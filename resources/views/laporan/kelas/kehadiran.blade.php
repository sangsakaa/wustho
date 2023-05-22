<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Laporan Kehadiran') }}
            </h2>
        </div>
    </x-slot>
    <div class=" p-4  w-full bg-white ">
        <div class=" flex  grid-cols-2  gap-1 ">
            <div class=" mt-1">
                <button class="  w-10 justify-center text-white   bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                    <x-icons.print></x-icons.print>
                </button>
            </div>
            <form action="/Laporan-Kehadiran" method="get" class="w-full">
                <div class="">
                    <select name="kelasmi_id" id="" class="  w-1/2   py-1 dark:bg-dark-bg">
                        <option value="">-- Semua --</option>
                        @foreach ($dataKelasMi as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                            {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                        </option>
                        @endforeach
                    </select>
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                        Tampilkan
                    </button>
                </div>
            </form>
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
        <div class=" bg-white p-4">
            <center>
                <div class=" uppercase text-green-800">
                    <p class=" text-2xl">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                    <p class=" text-3xl">Laporan Kehadiran</p>
            </center>

            <table>
                <thead>
                    <tr>
                        <th class=" border px-1">Nama Kelas</th>
                        <th class=" border px-1">Nama Siswa</th>
                        <th class=" border px-1">Total Alfa</th>
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
                        <td class="border text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{ $item->nama_kelas }}
                        </td>
                        @endif
                        <td class="border px-1 py-1">{{ $item->nama_siswa }}</td>
                        <td class="border text-center px-1 py-1">{{ $item->total_alfa }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>


        </div>
    </div>
</x-app-layout>