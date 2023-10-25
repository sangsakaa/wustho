<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Card Login' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Card User Account') }}
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
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 p-1">
        <div class="">
            <div class="  ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-2  grid grid-cols-2 gap-1">
                            <div class=" flex gap-2">
                                <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                    periode
                                </a>
                                <a href="/semester" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                    semester
                                </a>
                                <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                    </svg>
                                    Card Akun
                                </button>
                                <button onclick="window.print('test')">Cetak Halaman</button>

                            </div>
                            <div class=" w-full  bg-blue-100 grid justify-end ">
                                <form action="/cardlogin" method="get">
                                    <select name="cari" class="   py-1   ">
                                        <option value="" disabled selected>Pilih...</option>
                                        @foreach($kelasmi as $item)
                                        <option value="{{ $item->nama_kelas }}" {{ request('cari') == $item->nama_kelas ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-2 py-1 w-20 bg-blue-500 rounded-sm text-white">
                                        Cari
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="div1" class="">


        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" p-1 bg-white">
                <div class=" p-2 gap-2 grid grid-cols-2 ">
                    @foreach($peserta as $user)
                    <style>
                        .page-break {
                            page-break-after: always;
                        }
                    </style>
                    <div class=" p-1 grid grid-cols-1  border border-green-600  rounded-md">
                        <div class=" flex  ">
                            <div class=" p-1">
                                <img src={{ asset("asset/images/logo.png") }} alt="" width="50" class="">
                            </div>
                            <div class="   text-center  w-full">
                                <p class=" uppercase bold text-xs font-semibold  ">madrasah diniyah wahidiyah</p>
                                <p class=" uppercase bold text-xs font-semibold ">madrasah diniyah wustho wahidiyah</p>
                                <p class=" uppercase text-sm font-semibold">kartu akun siswa</p>
                            </div>
                        </div>
                        <hr class="">
                        <div class=" grid grid-cols-2">
                            <div class=" px-2 text-sm">
                                Username
                            </div>
                            <div class=" px-2 text-sm">
                                : {{$user->nis}}
                            </div>
                            <div class=" px-2 text-sm">
                                Password
                            </div>
                            <div class=" px-2 text-sm">
                                : {{$user->nis}}
                            </div>
                        </div>
                        <div class=" text-right text-sm">
                            Nama pengguna : <br>
                            <p class=" font-semibold">{{$user->nama_siswa}}</p>
                            <p class=" text-xs ">masa berlaku : status masih aktif | <b>Link : https://wustho.smedi.my.id/</b></p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="break-after-page"></div>
    </div>
</x-app-layout>