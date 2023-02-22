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

    <div class=" p-2">
        <button class=" text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">Cetak Ijazah</button>
        <a href="/blangko-transkip" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Transkip</a>
        <a href="/pengaturan" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Kembali</a>
    </div>
    <div id="div1" class="   w-full   ">
        @foreach($data as $ijazah)
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class=" bg-white  px-16  mt-16 text-center     rounded gap-4   ">
            <div class="  w-full justify-end grid">
                <span class=""> Nomor : {{$ijazah->nomor_ijazah}}</span>
            </div>
            <div class="  w-full">
                <center>
                    <img src={{ asset("asset/images/logo.png") }} alt="" width="180" class="  mt-5  p-2">
                    <p class=" font-serif text-5xl  mt-10 font-semibold ">IJAZAH</p>
                    <p class=" capitalize  text-4xl  font-riqah py-2">ألمدرسة الدينية الوسطى الواحدية
                    </p>
                    <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                    <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                        Wahidiyah</p>
                    <p class=" capitalize font-serif text-lg">kota kediri jawa timur indonesia</p>
                </center>
            </div>
            <div class=" w-full ">
                <p class=" text-justify   mt-5 text-sm">
                    Yang bertanda tangan dibawah ini Kepala Madrasah Diniyah Wustho Wahidiyah Kedunglo Kediri menerangkan bahwa :
                </p>
                <p class=" text-2xl uppercase bold  font-serif text-center   mt-4 underline ">
                    {{$ijazah->nama_siswa}}
                </p>
                <p class=" text-sm uppercase font-semibold   font-sans text-center ">
                    nomor induk siswa : {{$ijazah->nis}}
                </p>
                <div class=" text-left grid grid-cols-2 mt-5">
                    <div class=" px-1 ">Tempat, Tanggal Lahir</div>
                    <div class=" px-1 capitalize "> : {{strtolower($ijazah->tempat_lahir)}},
                        {{ \Carbon\Carbon::parse($ijazah->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                    </div>
                    <div class=" px-1 ">Nama Orang Tua / Wali </div>
                    <div class=" px-1 capitalize "> : {{$ijazah->nama_ayah}}
                    </div>
                </div>
                <p class="  text-3xl uppercase bold  font-serif text-center mt-4 ">lulus</p>
                <p class=" text-justify mt-4 ">Dalam mengikuti <span class=" font-semibold text-sm">Ujian Akhir Madrasah Diniyah Wustho Wahidiyah</span> yang diselenggarakan pada tanggal
                    {{ \Carbon\Carbon::parse($ijazah->mulai)->isoFormat(' DD MMMM ') }}
                    s.d
                    {{ \Carbon\Carbon::parse($ijazah->selesai)->isoFormat(' DD MMMM Y') }}
                    dengan nilai sebagaimana tercantum pada daftar nilai di balik ini.
                </p>

                <p class=" text-sm text-justify mt-4 ">
                    Pemegang ijazah ini, terakhir tercatat sebagai <span class=" capitalize">siswa madrasah Diniyah wustho wahidiyah pondok pesantren kedunglo Kediri</span> dengan <span class=" font-semibold">Nomor Induk Siswa : {{$ijazah->nis}}</span>
                </p>
            </div>
            <div class="  flex grid-cols-2 text-right  text-sm">
                <div class=" w-2/3"></div>
                <div class=" text-sm  mt-4 text-left">
                    Kedunglo, {{ \Carbon\Carbon::parse($ijazah->tanggal_kelulusan)->isoFormat(' DD MMMM Y') }}<br>
                    Kepala Madrasah<br><br><br><br>
                    <p class=" uppercase"> Muh. Bahrul Ulum, S.H</p>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </div>

</x-app-layout>