<x-app-layout>
    <x-slot name="header">
        @section('title', ' | blangko ijazah' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard blangko ijazah') }}
        </h2>
    </x-slot>
    <div class=" px-36 py-10 bg-white  ">
        <div class=" text-center  sm:text-center   rounded dark:bg-purple-600 ">
            <div class=" grid justify-end">
                <span class=" pr-10 mt-4"> Nomor : ...........................</span>
            </div>
            <center>
                <img src={{ asset("asset/images/logo.png") }} alt="" width="200" class=" grayscale p-2">
                <p class=" font-serif text-5xl  mt-10 font-semibold ">IJAZAH</p>
                <p class=" capitalize  text-4xl  font-riqah py-2">المدرسه الدينيه الوسطى واحيديه</p>
                <p class=" capitalize font-serif text-2xl">pondok pesantren kedunglo al munadhdhoroh</p>
                <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho wahidiyah</p>
                <p class=" capitalize font-serif text-2xl">kota kediri jawa timur indonesia</p>
            </center>
            <p class="  text-left"> Yang bertanda tangan dibawah ini adalah Kepala Sekolah Madrasah Diniyah Wustho wahidiyah kedunglo Kediri menerangkan bahwa :</p>
            <p class=" text-4xl uppercase bold  font-serif text-center mt-20 underline">muhammad bahrul ulum</p>
            <p class=" text-lg uppercase font-semibold   font-sans text-center ">nomor induk siswa : 202002000001</p>

            <div class=" px-1 ">Tempat, Tanggal Lahir</div>
            <div class=" px-1 capitalize "> : {{strtolower($siswa->tempat_lahir)}},
                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
            </div>
            <div class=" px-1 ">Nama Orang Tua / Wali </div>
            <div class=" px-1 capitalize "> : Mukidi
            </div>
            <p class=" text-4xl uppercase bold  font-serif text-center mt-4 ">lulus</p>
        </div>
    </div>
    </div>


</x-app-layout>