<x-app-layout>
    <x-slot name="header">
        @if ($kelasmi)
        @section('title'," - Kelas :". $kelasmi->nama_kelas )
        <h2 class="font-semibold text-xl  leading-tight">
            Report Per Peringkat :{{$kelasmi->nama_kelas }}
        </h2>
        @endif
    </x-slot>
    <div class="">
        <div class=" flex gap-2">
            <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                Cetak Raport
            </button>
            <div class=" py-1">
                <a href="/semester" class=" py-1 px-2 bg-red-600 rounded-md text-white">Batal</a>
            </div>
        </div>
        <div class=" mt-4">
            <form action="/peringkat" method="post">
                @csrf
                <div class=" grid grid-cols-1 sm:grid-cols-5 gap-2 sm:gap-2  ">
                    <select name="kelasmi_id" id="" class=" px-2 py-1    ">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($datakelasmi as $item)
                        <option value="{{ $item->id }}" {{ $kelasmi?->id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }} - {{ $item->periode }} {{ $item->ket_semester }}
                        </option>
                        @endforeach
                    </select>
                    <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> Tampilkan Peringkat</button>
                </div>
            </form>
        </div>
    </div>
    <div id="div1" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <script>
            function printContent(el) {
                var fullbody = document.body.innerHTML;
                var printContent = document.getElementById(el).innerHTML;
                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = fullbody;
            }
        </script>
        @if ($kelasmi)
        <div class=" px-4 py-2">
            <div class="grid p-2 bg-white border-b border-gray-200">
                <div class=" grid grid-cols-1 justify-items-center">
                    <span class=" font-semibold ">PERINGKAT HASIL TADRIS</span>
                    <span class=" font-semibold">MADRASAH DINIYAH WUSTHO WAHIDIYAH</span>
                    <span class=" font-semibold"> KELAS {{ $kelasmi->nama_kelas }} PERIODE {{ $kelasmi->periode }}
                        {{ Str::upper($kelasmi->ket_semester) }}</span>
                </div>
            </div>
            <hr>
            <table class=" w-full">
                <thead class=" bg-green-800  border font-semibold ">
                    <tr class=" text-white">
                        <th class=" border border-gray-800 text-xs px-2" rowspan="2">NO </th>
                        <th class=" border border-gray-800 text-xs px-2" rowspan="2">NIS</th>
                        <th class=" border border-gray-800 text-xs px-2" rowspan="2">NAMA</th>
                        <th colspan="2" class=" text-xs border border-green-800 text-center">TOTAL NILAI</th>
                        <th class=" border border-green-800 text-xs px-2" rowspan="2">PERINGKAT</th>
                    </tr>
                    <tr class=" text-white">
                        <th class=" text-xs px-2 text-center">NH</th>
                        <th class=" text-xs px-2 text-center">NU</th>
                    </tr>
                </thead>
                @foreach ($ringkasanraportkelas as $pesertakelas_id => $ringkasan)
                @php
                if (!$siswa->has($pesertakelas_id)) {
                continue;
                }
                $datasiswa = $siswa[$pesertakelas_id];
                @endphp
                <tbody class=" text-md">
                    <tr>
                        <th class=" px-2 text-sm border border-green-800">{{ $loop->iteration }}</th>
                        <td class=" px-2 text-sm border text-center border-green-800">{{ $datasiswa->nis }}
                        </td>
                        <td class=" px-2 text-sm border border-green-800 capitalize"> {{ strtolower($datasiswa->nama_siswa) }}</td>
                        <td class=" px-2 text-sm border border-green-800 text-center">
                            @if($ringkasan['jmlharian'] <= 400) <span class=" text-red-600">{{$ringkasan['jmlharian']}}</span>
                                @else
                                <span class=" s font-semibold ">{{$ringkasan['jmlharian']}}</span>
                                @endif
                        </td>
                        <td class=" px-2 text-sm border border-green-800 text-center">
                            {{ $ringkasan['jmlujian'] }}
                        </td>
                        <td class=" px-2 text-sm border border-green-800 text-center">
                            {{ $ringkasan['peringkat'] }}
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
        @endif
    </div>
</x-app-layout>