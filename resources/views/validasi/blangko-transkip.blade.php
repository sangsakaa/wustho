<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Blangko Transkip' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Blangko Transkip') }}
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
    <div class=" p-2">
        <button class=" text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">Cetak Transkip</button>
        <a href="/blangko-ijazah" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Ijazah</a>
        <a href="/pengaturan" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Kembali</a>
    </div>
    <div id="div1" class=" px-4  ">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        @foreach($data as $ijazah)
        <div class=" border">
            <div class=" px-28 py-20 text-center  bg-white   rounded   ">
                <div class=" grid text-right justify-end w-full">
                    <span class=" pr-10 mt-4 text-right"> Nomor : .......................................</span>
                </div>
                <center>
                    <img src={{ asset("asset/images/logo.png") }} alt="" width="180" class=" mt-10  p-2">
                    <p class=" font-serif text-5xl  mt-10 font-semibold ">IJAZAH</p>
                    <p class=" capitalize  text-4xl  font-riqah py-2">ألمدرسة الدينية الوسطى الواحدية
                    </p>
                    <p class="  font-serif text-sm uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                    <p class="  uppercase font-serif text-lg font-semibold ">madrasah diniyah wustho
                        Wahidiyah</p>
                    <p class=" capitalize font-serif text-2xl">kota kediri jawa timur indonesia</p>
                </center>
                <div>
                    <p class=" text-justify   mt-5 text-sm"> Yang bertanda tangan dibawah ini Kepala Madrasah Diniyah Wustho Wahidiyah Kedunglo Kediri menerangkan bahwa :</p>
                    <p class=" text-2xl uppercase bold  font-serif text-center  mt-8 underline ">{{$ijazah->nama_siswa}}</p>
                    <p class=" text-sm uppercase font-semibold   font-sans text-center ">nomor induk siswa : {{$ijazah->nis}}</p>
                </div>

                <div class=" text-left grid grid-cols-2 mt-5">
                    <div class=" px-1 ">Tempat, Tanggal Lahir</div>
                    <div class=" px-1 capitalize "> : {{strtolower($ijazah->tempat_lahir)}},
                        {{ \Carbon\Carbon::parse($ijazah->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                    </div>
                    <div class=" px-1 ">Nama Orang Tua / Wali </div>
                    <div class=" px-1 capitalize "> : {{$ijazah->nama_ayah}}
                    </div>
                </div>
                <p class=" text-4xl uppercase bold  font-serif text-center mt-8 ">lulus</p>
                <p class=" text-justify mt-8 ">Dalam mengikuti <span class=" font-semibold text-sm">Ujian Akhir Madrasah Diniyah Wustho Wahidiyah</span> yang diselenggarakan
                    pada tanggal................ s.d................... dengan nilai sebagaimana tercantum pada daftar nilai dibalik ini.</p>

                <p class=" text-justify mt-4 text-sm">
                    Pemegang ijazah ini, terakhir tercatat sebagai <span class=" capitalize">siswa madrasah Diniyah wustho wahidiyah pondok pesantren kedunglo Kediri</span> dengan <span class=" font-semibold">Nomor Induk Siswa</span> : {{$ijazah->nis}}
                </p>

                <div class="  flex grid-cols-2 text-right mt-4 text-sm">
                    <div class=" w-2/3"></div>
                    <div class="  text-left">
                        Kedunglo, {{ now()->isoFormat('D MMMM YYYY') }}<br>
                        Kepala Madrasah<br><br><br><br>
                        <p class=" uppercase"> Muh. Bahrul Ulum, S.H</p>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="page-break"></div>
        </div>
    </div>

</x-app-layout>