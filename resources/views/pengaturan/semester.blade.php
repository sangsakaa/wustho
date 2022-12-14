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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg>
                                Cetak Raport
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="div1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" p-6 ">
                        <span>Akun Smedi Siswa</span>
                        <table class=" w-full ">
                            <thead class=" border">
                                <tr class=" bg-gray-100 capitalize">
                                    <th class=" border px-2 py-1">No</th>
                                    <th class=" border px-2 text-center">Nama Siswa</th>
                                    <th class=" border px-2 text-center">kelas</th>
                                    <th class=" border px-2 text-center">User</th>
                                    <th class=" border px-2 text-center">Password</th>
                                </tr>
                            </thead>
                            @foreach($peserta as $user)
                            <tbody>
                                <tr class=" border hover:bg-gray-100 text-sm">
                                    <th class=" px-2 text-center border">{{$loop->iteration}}</th>
                                    <td class=" px-2 text-left border text-sm">{{$user->nama_siswa}}</td>
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