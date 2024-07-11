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
    <div class=" p-2 bg-white">
        <button class=" text-white   bg-green-800 px-2 py-1 " onclick="printContent('div1')">Cetak Ijazah</button>
        <a href="/blangko-transkip/{{$kelasmi->id}}" class=" text-white   bg-green-800 px-2 py-1 ">Transkip</a>
        <a href="/lulusan" class=" text-white   bg-green-800 px-2 py-1 ">Kembali</a>
    </div>
    <div class=" bg-white p-2 my-2 grid grid-cols-4 uppercase">
        <div>Kelas </div>
        <div>: {{$DataIjaza->nama_kelas}}</div>
        <div>Total Ijazah </div>
        <div> : {{$data->count()}}</div>
    </div>
    <div id="div1" class="  px-4 w-full   ">
        @foreach($data as $ijazah)
        <div class="relative     flex items-center justify-center gap-2 bg-white">
            <style>
                .page-break {
                    page-break-after: always;
                }

                .black-and-white {
                    filter: grayscale(150%);
                }
            </style>
            <!-- Konten lainnya di sini -->

            @if ($dataKelas->first()->jenjang == 'Wustho')
            <img src="{{ asset('asset/images/logo_wustho.png') }}" alt="" class="absolute     opacity-25  w-1/3  p-2 mt-3 black-and-white">
            @elseif ($dataKelas->first()->jenjang == 'Ula')
            <img src="{{ asset('asset/images/logoUla.png') }}" alt="" class="absolute     opacity-25  w-1/3  p-2 mt-3 black-and-white">
            @endif
            <div class=" font-serif    text-center     rounded gap-4   ">
                <div class=" px-14 ">
                    <div class="  w-full justify-end grid ">
                        <style>
                            .nomor-ijazah {
                                font-family: Arial, sans-serif;
                            }
                        </style>

                        <!-- <span class="  font-semibold   mt-14  font-serif"> NOMOR : {{$ijazah->nomor_ijazah}}</span> -->
                        <span class="font-semibold mt-14 font-serif nomor-ijazah"> NOMOR : {{$ijazah->nomor_ijazah}}</span>

                    </div>
                    <div class="  w-full">
                        <center>

                            @if ($dataKelas->first()->jenjang == 'Wustho')
                            <img src={{ asset("asset/images/logo_wustho.png") }} alt="" width="180" class="  mt-3  p-2">
                            @elseif ($dataKelas->first()->jenjang == 'Ula')
                            <img src={{ asset("asset/images/logoUla.png") }} alt="" width="180" class="  mt-3  p-2">
                            @endif

                            <p class=" font-semibold">DEPARTEMEN PENDIDIKAN <br> DINIYAH WAHIDIYAH</p>
                            <p class=" font-serif text-5xl   mt-2 font-semibold ">IJAZAH</p>

                            <p class="  uppercase font-serif text-lg font-semibold ">madrasah diniyah <br> takmiliyah
                                @if ($dataKelas->first()->jenjang == 'Wustho')
                                Wustha
                                @elseif ($dataKelas->first()->jenjang == 'Ula')
                                Ula
                                @endif
                                Wahidiyah
                            </p>
                            <p class=" font-semibold ">TAHUN PELAJARAN
                                <span class="nomor-ijazah  font-serif">
                                    {{$dataPeriode->first()->periode}}
                                </span>
                            </p>

                        </center>
                    </div>
                    <div class=" w-full ">
                        <p class=" text-justify  text-sm  mt-5  ">
                            Yang bertanda tangan di bawah ini, Pengasuh Perjuangan Wahidiyah dan Pondok Pesantren Kedunglo Al Munadhdhoroh menerangkan bahwa :
                        </p> <br>
                        <p class=" text-2xl uppercase bold  font-serif text-center   mt-2 underline ">
                            {{$ijazah->nama_siswa}}
                        </p>
                        <p class=" text-sm uppercase font-semibold    text-center ">
                            nomor induk murid : <span class="nomor-ijazah">{{$ijazah->nis}}</span>
                        </p>
                        <div class=" text-sm text-left  grid grid-cols-2 mt-2">
                            <div class=" px-1 ">Tempat, Tanggal Lahir</div>
                            <div class=" px-1 capitalize nomor-ijazah ">
                                : {{strtolower($ijazah->tempat_lahir)}},
                                {{ \Carbon\Carbon::parse($ijazah->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                            </div>
                            <div class=" px-1 ">Nama Orang Tua / Wali </div>
                            <div class=" px-1 capitalize ">
                                : {{$ijazah->nama_ayah}}
                            </div>
                            <div class=" px-1 ">Nomor Ujian</div>
                            <div class=" px-1 capitalize nomor-ijazah ">
                                : {{$ijazah->nomor_ujian}}
                            </div>
                        </div>
                        <div>
                            <p class="  text-3xl uppercase bold  font-serif text-center mt-4 ">lulus</p>
                            <p class=" text-sm text-justify mt-4 ">
                                dari Madrasah Diniyah Takmiliyah
                                @if ($dataKelas->first()->jenjang == 'Wustho')
                                Wustha
                                @elseif ($dataKelas->first()->jenjang == 'Ula')
                                Ula
                                @endif
                                Wahidiyah Kedunglo Kediri Nomor Statistik
                                @if ($dataKelas->first()->jenjang == 'Wustho')
                                <span class=" ">321235710006</span>
                                @elseif ($dataKelas->first()->jenjang == 'Ula')

                                <span class=" ">311235710013</span>
                                @endif
                                berdasarkan penilaian sebagaimana ketentuan yang berlaku.
                            </p>
                        </div>
                        <p class=" text-sm  text-justify mt-3 mx-auto lg:mx-0 ">
                            Pemegang ijazah ini, terakhir tercatat sebagai <span class=" capitalize">murid madrasah Diniyah takmiliyah wustha wahidiyah kedunglo Kediri</span> dengan <span class=" font-semibold">Nomor Induk Murid : <span class="nomor-ijazah ">{{$ijazah->nis}}</span></span>
                        </p>
                    </div>
                    <div class="  flex grid-cols-1    ">
                        <div class="    px-8    py-9">
                            <span class="border   w-32  h-40 border-black flex justify-center items-center">
                                <p class="">Foto 3x4</p>
                            </span>
                        </div>
                        <div class="   grid   text-left  mt-4 text-sm  ">
                            <div class="flex flex-col">
                                <table class="  w-fit">
                                    <tbody>
                                        <tr>
                                            <td class=" underline">Kedunglo, </td>
                                            <td class=" text-right underline nomor-ijazah">
                                                <p class=" "> {{ $ijazah->tanggal_lulus_hijriyah }} H</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="text-right">
                                                <p style="margin: 0; width: 100%;" class="nomor-ijazah  ">{{ \Carbon\Carbon::parse($ijazah->tanggal_kelulusan)->isoFormat('DD MMMM Y') }} M</p>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div>
                                    <p class=" mb-0">Pengasuh Perjuangan Wahidiyah <br> Dan Pondok Pesantren Kedunglo</p>
                                </div>
                                <div>
                                    <p class="underline">
                                    </p>
                                </div>
                                <div class="flex items-center">
                                    <p class="  px-20">
                                    </p>
                                </div>
                            </div>
                            <div class=" ">
                                <br><br><br><br>
                                <p class=" uppercase font-semibold"> Kanjeng Romo Kyai Abdul Majid Ali Fikri R.A</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </div>
</x-app-layout>