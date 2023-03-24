<x-app-layout>
    <x-slot name="header">
        @section('title', ' | blangko ijazah' )
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
        <a href="/blangko-transkip" class=" text-white   bg-green-800 px-2 py-1 ">Transkip</a>
        <a href="/pengaturan" class=" text-white   bg-green-800 px-2 py-1 ">Kembali</a>
    </div>
    <div class=" p-2 bg-white mt-2">
        <form action="/blangko-ijazah" method="get" class="  text-sm gap-1 flex">
            <!-- <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari .." autofocus> -->
            <select name="cari" id="" class=" py-1 w-1/4">
                <option value="">Pilih Kelas</option>
                @foreach($dataKelas as $item)
                <option value="{{ $item->id }}" {{ $kelasmi?->id == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kelas }} {{ $item->periode }} {{ $item->ket_semester }}
                </option>
                @endforeach
            </select>
            <button type="submit" class=" px-2    bg-blue-500  rounded-md text-white">
                <x-icons.cari></x-icons.cari>
            </button>
        </form>
    </div>
    @if($data === null)
    x
    @else
    <div class=" p-2 m-2 rounded-md bg-yellow-200">
        {{$data->count()}}
    </div>
    @endif

    <div id="div1" class=" bg-white   w-full   ">
        @foreach($data as $ijazah)
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class=" bg-white  px-16  mt-16 text-center     rounded gap-4   ">
            <div class="  w-full justify-end grid">
                <span class=" mt-4 font-semibold"> NOMOR : {{$ijazah->nomor_ijazah}}</span>
            </div>
            <div class="  w-full">
                <center>
                    <img src={{ asset("asset/images/logo.png") }} alt="" width="180" class="  mt-3  p-2">
                    <p class=" font-serif text-5xl   mt-6 font-semibold ">IJAZAH</p>
                    <p class=" capitalize  text-4xl  font-riqah py-2">
                        المدرسة الدينية الوسطى الواحدية
                    </p>

                    </p>
                    <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                    <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                        Wahidiyah</p>
                    <p class=" capitalize font-serif text-lg">kota kediri jawa timur indonesia</p>
                </center>
            </div>
            <div class=" w-full ">
                <p class=" text-justify  text-sm  mt-5  ">
                    Yang bertanda tangan di bawah ini Pengasuh Pondok Pesantren Kedunglo Al Munadhdhoroh menerangkan bahwa :
                </p>
                <p class=" text-2xl uppercase bold  font-serif text-center   mt-4 underline ">
                    {{$ijazah->nama_siswa}}
                </p>
                <p class=" text-sm uppercase font-semibold   font-sans text-center ">
                    nomor induk murid : {{$ijazah->nis}}
                </p>
                <div class=" text-sm text-left  grid grid-cols-2 mt-5">
                    <div class=" px-1 ">Tempat, Tanggal Lahir</div>
                    <div class=" px-1 capitalize ">
                        : {{strtolower($ijazah->tempat_lahir)}},
                        {{ \Carbon\Carbon::parse($ijazah->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                    </div>
                    <div class=" px-1 ">Nama Orang Tua / Wali </div>
                    <div class=" px-1 capitalize ">
                        : {{$ijazah->nama_ayah}}
                    </div>
                    <div class=" px-1 ">Nomor Ujian</div>
                    <div class=" px-1 capitalize ">
                        : {{$ijazah->nomor_ujian}}
                    </div>

                </div>

                <div>
                    <p class="  text-3xl uppercase bold  font-serif text-center mt-4 ">lulus</p>
                    <p class=" text-sm text-justify mt-4 ">Dalam mengikuti <span class=" font-semibold ">Ujian Akhir Madrasah Diniyah Wustho Wahidiyah</span> yang diselenggarakan pada tanggal
                        {{ \Carbon\Carbon::parse($ijazah->tanggal_mulai)->isoFormat(' DD MMMM ') }}
                        s.d
                        {{ \Carbon\Carbon::parse($ijazah->tanggal_selesai)->isoFormat(' DD MMMM Y') }}

                        dengan nilai sebagaimana tercantum pada daftar nilai di balik ini.
                    </p>
                </div>

                <p class=" text-sm  text-justify mt-4 ">
                    Pemegang ijazah ini, terakhir tercatat sebagai <span class=" capitalize">murid madrasah Diniyah wustho wahidiyah pondok pesantren kedunglo Kediri</span> dengan <span class=" font-semibold">Nomor Induk Murid : {{$ijazah->nis}}</span>
                </p>
            </div>
            <div class="  grid grid-cols-2 text-right   ">
                <div class="  w-2/2  flex    px-32 pt-4 ">
                    <div class="  border-black  border    w-32  h-40   text-justify ">
                        <span class=" grid justify-between   p-12 font-semibold ">
                            Foto 3x4
                        </span>
                    </div>
                </div>
                <div class=" text-sm   mt-4 text-left ">
                    <p class=" ">
                        <!-- {{ \Carbon\Carbon::parse($ijazah->tanggal_kelulusan)->isoFormat(' DD MMMM Y') }}</p> -->
                    <p class=" underline"> Kedunglo, 27 Sya'ban 1444 H </p>

                    <p class="  px-20 ml-1">19 Maret 2023 M</p>
                    <!-- <p class="">Mengetahui,</p> -->
                    <!-- <p>Pengasuh Pondok</p> -->
                    <!-- <p>Pengasuh/ Al Mudir</p> -->
                    <p>Pengasuh Perjuangan Wahidiyah</p>
                    <p>Dan Pondok Pesantren Kedunglo </p>


                    <br><br><br><br><br>
                    <p class=" uppercase font-semibold"> Kanjeng Kyai Abdul Majid Ali Fikri R.A</p>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </div>

</x-app-layout>