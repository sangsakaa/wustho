<x-app-layout>
    <x-slot name="header">
        @section('title', ' | IJAZAH - '.$DataIjaza->nama_kelas )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard blangko ijazah') }}
        </h2>
    </x-slot>

    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>

    @php
    $jenjang = $dataKelas->first()->jenjang;
    @endphp

    <div class=" p-2 bg-white">
        <button class=" text-white bg-green-800 px-2 py-1" onclick="printContent('div1')">Cetak Ijazah</button>
        <a href="/blangko-transkip/{{$kelasmi->id}}" class=" text-white bg-green-800 px-2 py-1">Transkip</a>
        <a href="/lulusan" class=" text-white bg-green-800 px-2 py-1">Kembali</a>
    </div>

    <div class=" bg-white p-2 my-2 grid grid-cols-4 uppercase">
        <div>Kelas</div>
        <div>: {{$DataIjaza->nama_kelas}}</div>
        <div>Total Ijazah</div>
        <div>: {{$data->count()}}</div>
    </div>

    <div id="div1" class="px-4 w-full">
        @foreach($data as $ijazah)

        <div class="relative flex items-center justify-center gap-2 bg-white">

            <style>
                .page-break {
                    page-break-after: always;
                }

                .black-and-white {
                    filter: grayscale(150%);
                }

                .nomor-ijazah {
                    font-family: Arial, sans-serif;
                }
            </style>

            {{-- BACKGROUND LOGO --}}
            @if ($jenjang == 'Wustho')
            <img src="{{ asset('asset/images/logo_wustho.png') }}" class="absolute opacity-25 w-1/3 p-2 mt-3 black-and-white">

            @elseif ($jenjang == 'Ula')
            <img src="{{ asset('asset/images/logoUla.png') }}" class="absolute opacity-25 w-1/3 p-2 mt-3 black-and-white">

            @elseif ($jenjang == 'Ulya')
            <img src="{{ asset('asset/images/logo_ulya.jpeg') }}" class="absolute opacity-25 w-1/3 p-2 mt-3 black-and-white">
            @endif

            <div class="font-serif text-center rounded gap-4">
                <div class="px-14">

                    {{-- NOMOR IJAZAH --}}
                    <div class="w-full justify-end grid">
                        <span class="font-semibold mt-14 font-serif nomor-ijazah">
                            NOMOR : {{$ijazah->nomor_ijazah}}
                        </span>
                    </div>

                    {{-- LOGO --}}
                    <div class="w-full">
                        <center>

                            {{-- LOGO --}}
                            @if ($jenjang == 'Wustho')
                            <img src="{{ asset('asset/images/logo_wustho.png') }}" width="180" class="mt-3 p-2">

                            @elseif ($jenjang == 'Ula')
                            <img src="{{ asset('asset/images/logo_ula.png') }}" width="180" class="mt-3 p-2">

                            @elseif ($jenjang == 'Ulya')
                            <img src="{{ asset('asset/images/logo_ulya.jpeg') }}" width="180" class="mt-3 p-2">
                            @else
                            <img src="{{ asset('asset/images/logo_kop.jpeg') }}" width="180" class="mt-3 p-2">
                            @endif

                            <p class="font-semibold">
                                DEPARTEMEN PENDIDIKAN <br> DINIYAH WAHIDIYAH
                            </p>

                            <p class="font-serif text-5xl mt-2 font-semibold">
                                IJAZAH
                            </p>

                            {{-- JENJANG --}}
                            <p class="uppercase font-serif text-lg font-semibold">
                                madrasah diniyah <br> takmiliyah

                                @if ($jenjang == 'Wustho')
                                Wustha
                                @elseif ($jenjang == 'Ula')
                                Ula
                                @elseif ($jenjang == 'Ulya')
                                Ulya
                                @endif

                                Wahidiyah
                            </p>

                            <p class="font-semibold">
                                TAHUN PELAJARAN
                                <span class="nomor-ijazah font-serif">
                                    {{$dataPeriode->first()->periode}}
                                </span>
                            </p>

                        </center>
                    </div>

                    {{-- DATA SISWA --}}
                    <div class="w-full">
                        <p class="text-justify text-sm mt-5">
                            Yang bertanda tangan di bawah ini, Pengasuh Perjuangan Wahidiyah dan Pondok Pesantren Kedunglo Al Munadhdhoroh menerangkan bahwa :
                        </p>

                        <p class="text-2xl uppercase font-serif text-center mt-2 underline">
                            {{$ijazah->nama_siswa}}
                        </p>

                        <p class="text-sm uppercase font-semibold text-center">
                            nomor induk murid :
                            <span class="nomor-ijazah">{{$ijazah->nis}}</span>
                        </p>

                        <div class="text-sm text-left grid grid-cols-2 mt-2">
                            <div>Tempat, Tanggal Lahir</div>
                            <div class="capitalize nomor-ijazah">
                                : {{strtolower($ijazah->tempat_lahir)}},
                                {{ \Carbon\Carbon::parse($ijazah->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                            </div>

                            <div>Nama Orang Tua / Wali</div>
                            <div>: {{$ijazah->nama_ayah}}</div>

                            <div>Nomor Ujian</div>
                            <div class="nomor-ijazah">: {{$ijazah->nomor_ujian}}</div>
                        </div>

                        <p class="text-3xl uppercase text-center mt-4">lulus</p>

                        <p class="text-sm text-justify mt-4">
                            dari Madrasah Diniyah Takmiliyah

                            @if ($jenjang == 'Wustho')
                            Wustha
                            @elseif ($jenjang == 'Ula')
                            Ula
                            @elseif ($jenjang == 'Ulya')
                            Ulya
                            @endif

                            Wahidiyah Kedunglo Kediri

                            @if ($jenjang == 'Wustho')
                            <span class="nomor-ijazah"> Nomor Statistik 321235710006</span>

                            @elseif ($jenjang == 'Ula')
                            <span class="nomor-ijazah"> Nomor Statistik 311235710013</span>

                            @elseif ($jenjang == 'Ulya')
                            <span class="nomor-ijazah"></span>
                            @endif

                            berdasarkan penilaian sebagaimana ketentuan yang berlaku.
                        </p>

                        <p class="text-sm text-justify mt-3">
                            Pemegang ijazah ini, terakhir tercatat sebagai murid Madrasah Diniyah Takmiliyah
                            {{$jenjang}} Wahidiyah Kedunglo Kediri dengan
                            <b>Nomor Induk Murid: <span class="nomor-ijazah">{{$ijazah->nis}}</span></b>
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="flex">
                        <div class="px-8 py-9">
                            <span class="border w-32 h-40 border-black flex justify-center items-center">
                                Foto 3x4
                            </span>
                        </div>

                        <div class="grid text-left mt-4 text-sm">
                            <table class="w-fit">
                                <tr>
                                    <td class="underline">Kedunglo,</td>
                                    <td class="text-right underline nomor-ijazah">
                                        {{$ijazah->tanggal_lulus_hijriyah}} H
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right nomor-ijazah">
                                        {{ \Carbon\Carbon::parse($ijazah->tanggal_kelulusan)->isoFormat('DD MMMM Y') }} M
                                    </td>
                                </tr>
                            </table>

                            <p>Pengasuh Perjuangan Wahidiyah <br> Dan Pondok Pesantren Kedunglo</p>

                            <br><br><br>

                            <p class="uppercase font-semibold">
                                Kanjeng Romo Kyai Abdul Majid Ali Fikri R.A
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="page-break"></div>

        @endforeach
    </div>
</x-app-layout>