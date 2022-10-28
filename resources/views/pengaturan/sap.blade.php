<x-app-layout>
    <x-slot name="header">
        @if($kelasmi)
        @section('title', '| Satuan Acara Pembelajaran'. $kelasmi->nama_kelas)
        @endif
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Satuan Acara Pembelajaran') }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <form action="/sap" method="get" class="w-full">
                        <select name="kelasmi_id" id="" class=" my-1 w-full sm:w-1/5 py-1 dark:bg-dark-bg" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($dataKelasMi as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Pilih Kelas
                        </button>
                    </form>
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
                        Cetak
                    </button>
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
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    @if($kelasmi)
    <div class="py-1">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm " id="blanko">
            @foreach ($dataMapel as $mapel)
            <div class=" p-1 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg  ">
                    <div class=" text-center text-green-900">
                        <p class=" font-semibold text-3xl">
                            MADRASAH DINIYAH WUSTHA WAHIDIYAH
                        </p>
                        <p class=" font-semibold uppercase">
                            TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                        </p>
                    </div>
                    <hr class=" border-b-2 border-green-900">
                    <div class=" grid grid-cols-1">
                        <div class="text-green-900 mt-1 font-semibold">
                            <span class="inline-block w-1/5">KELAS</span>: {{ $kelasmi->nama_kelas }}
                        </div>
                        <div class="text-green-900 font-semibold">
                            <span class="inline-block w-1/5">MATA PELAJARAN</span>: {{ $mapel->mapel }}
                        </div>
                        <div class="text-green-900 font-semibold">
                            <span class="inline-block w-1/5">GURU MAPEL</span>: {{ $mapel->nama_guru }}
                        </div>
                    </div>
                    <table class="table-fixed w-full text-green-900">
                        <thead class="border border-b-2 border-green-600">
                            <tr class="border  border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1 w-8" rowspan="2">NO</th>
                                <th class="border border-green-600 px-1 w-1/5">TANGGAL KBM</th>
                                @for ($i = 0; $i < 17; $i++) <th class="border border-green-600 px-1">
                                    </th>
                                    @endfor
                                    <th class="border border-green-600 px-1 text-xs" colspan="2">NILAI TUGAS</th>
                                    <th class="border border-green-600 px-1 text-xs" rowspan="2">KET</th>
                            </tr>
                            <tr class="border border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1">NAMA</th>
                                @for ($i = 1; $i <= 17; $i++) <th class="border border-green-600 px-1 text-xs">PERT {{ $i }}</th>
                                    @endfor
                                    <th class="border border-green-600 px-1">1</th>
                                    <th class="border border-green-600 px-1">2</th>
                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            @foreach ($dataSiswa as $siswa)
                            <tr class=" border border-green-600 text-xs sm:text-sm ">
                                <td class="border border-green-600 text-center px-1 text-xs">{{ $loop->iteration }}</td>
                                <td class="border border-green-600 px-1 text-sm">{{ $siswa->nama_siswa }}</td>
                                @for ($i = 0; $i < 20; $i++) <td class="border border-green-600 px-1">
                                    </td>
                                    @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="break-after-page"></div>
            @endforeach
        </div>
    </div>
    @endif
</x-app-layout>