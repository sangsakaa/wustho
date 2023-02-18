<x-app-layout>
    <x-slot name="header">
        @section('title', ' | blangko ijazah' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard blangko ijazah') }}
        </h2>
    </x-slot>
    <div class="  px-36 py-10 bg-white  ">
        @foreach($data as $ijazah)
        <div class=" text-center    rounded dark:bg-purple-600 ">
            <div class=" grid justify-end">
                <span class=" pr-10 mt-4"> Nomor : ...........................</span>
            </div>
            <center>
                <img src={{ asset("asset/images/logo.png") }} alt="" width="200" class=" grayscale p-2">
                <p class=" font-serif text-5xl  mt-10 font-semibold ">IJAZAH</p>
                <p class=" capitalize  text-4xl  font-riqah py-2">المدرسه الدينيه وسطى واحيديه</p>
                <p class=" capitalize font-serif text-2xl">pondok pesantren kedunglo al munadhdhoroh</p>
                <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                    Wahidiyah</p>
                <p class=" capitalize font-serif text-2xl">kota kediri jawa timur indonesia</p>
            </center>
            <div>
                <p class="  text-left mt-5"> Yang bertanda tangan dibawah ini Kepala Madrasah Diniyah Wustho Wahidiyah Kedunglo Kediri menerangkan bahwa :</p>
                <p class=" text-3xl uppercase bold  font-serif text-center mt-15 underline">{{$ijazah->nama_siswa}}</p>
                <p class=" text-lg uppercase font-semibold   font-sans text-center ">nomor induk siswa : {{$ijazah->nis}}</p>
            </div>

            <div class=" text-left grid grid-cols-2 mt-5">
                <div class=" px-1 ">Tempat, Tanggal Lahir</div>
                <div class=" px-1 capitalize "> : {{strtolower($ijazah->tempat_lahir)}},
                    {{ \Carbon\Carbon::parse($ijazah->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                </div>
                <div class=" px-1 ">Nama Orang Tua / Wali </div>
                <div class=" px-1 capitalize "> : Mukidi
                </div>
            </div>
            <p class=" text-4xl uppercase bold  font-serif text-center mt-4 ">lulus</p>
            <p class=" text-justify ">dalam mengikuti Evaluasi Belajar Tahap Akhir Madrasah Diniyah Wustho Wahidiyah yang diselenggarakan pada tanggal................ s.d...................Dengan nilai dengan nilai sebagaimana tercantum pada daftar nilai dibalik ini.</p>

            <p class=" text-justify mt-4">
                Pemegang ijazah ini, terakhir tercatat sebagai siswa madrasah Diniyah wustho wahidiyah pondok pesantren kedunglo Kediri dengan <span class=" font-semibold">Nomor Induk Siswa</span> : {{$ijazah->nis}}
            </p>

        </div>
        @endforeach
    </div>



</x-app-layout>