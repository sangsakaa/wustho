<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengaturan') }}
        </h2>
    </x-slot>
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
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 flex grid-cols-1 gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/peringkat" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                Peringkat
                            </a>
                            <a href="/cardlogin" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                User Account
                            </a>
                            <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                                <x-icons.print></x-icons.print>
                                Cetak Kartu Akun
                            </button>
                            <div class=" justify-end grid">
                                <form action="/semester" method="get" class="  text-sm gap-1 flex">
                                    <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari .." autofocus>
                                    <button type="submit" class=" px-2    bg-blue-500  rounded-md text-white">
                                        Cari By Nama </button>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div id="div1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" p-6 ">
                        <div class=" text-center">
                            <span class=" uppercase text-center font-semibold">Akun Smedi Siswa</span>
                        </div>
                        <table class=" w-full ">
                            <thead class=" border">
                                <tr class=" bg-gray-100  uppercase text-sm">
                                    <th class=" border px-2 py-1">No</th>
                                    <th class=" border px-2 text-center">Nama Siswa</th>
                                    <th class=" border px-2 text-center">kelas</th>
                                    <th class=" border px-2 text-center">Username</th>
                                    <th class=" border px-2 text-center">Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peserta as $user)
                                <tr class=" border hover:bg-gray-100 text-sm even:bg-gray-100">
                                    <th class=" px-2 text-center border">{{$loop->iteration}}</th>
                                    <td class=" px-2 text-left border text-sm capitalize ">{{ strtolower($user->nama_siswa)}}</td>
                                    <td class=" px-2 text-center border ">{{$user->nama_kelas}}</td>
                                    <td class=" px-2 text-center border">{{$user->nis}}</td>
                                    <td class=" px-2 text-center border">{{$user->nis}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>