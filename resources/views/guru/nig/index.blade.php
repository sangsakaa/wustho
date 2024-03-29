<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Detail Guru') }}
        </h2>
    </x-slot>
    <div class="">
        <div class="bg-white overflow-hidden shadow-sm ">
            <div class="p-2 bg-white border-b border-gray-200">
                <div class=" p-4 grid grid-cols-4 gap-1 ">
                    <div class=" ">Nama Lengkap</div>
                    <div class=" ">: {{$guru->nama_guru}}</div>
                    <div class=" ">Jenia Kelamin</div>
                    <div class=" ">: {{$guru->jenis_kelamin}}</div>
                </div>
            </div>

        </div>
        <div class="mt-2">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" ">
                        <div>
                            <a href="/guru/{{$guru->id}}" class=" text-white px-1 py-1 bg-sky-400"> Kembali Ke Detail</a>
                        </div>
                        <span class=" py-1">Generate Nomor Induk Guru</span>
                        <form action="/nig/{{$guru->id}}" method="post">
                            @csrf
                            <input type="hidden" name="guru_id" value="{{$guru->id}}" class=" py-1" required>
                            <input type="text" name="nig" class=" py-1" placeholder="NIG : 2023010001" autofocus>
                            <input type="hidden" name="jenjang_id" class=" py-1" placeholder="NIG : 2023010001" autofocus value="2">
                            <button class=" bg-blue-600 py-1 px-2 text-white rounded-sm uppercase">Nomor Induk guru</button>
                        </form>
                    </div>
                    <div>
                        <span class=" py-1">Daftar Nomor Induk Guru</span>
                        <table class=" w-1/2">
                            <thead>
                                <tr>
                                    <th class=" px-1 border py-1">No</th>
                                    <th class=" px-1 border py-1">Nomor Induk Guru</th>
                                    <th class=" px-1 border py-1">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataNIG as $nig)
                                <tr>
                                    <th class=" px-1 py-1 border text-center">
                                        {{$loop->iteration}}
                                    </th>
                                    <td class=" px-1 py-1 border text-center">
                                        {{$nig->nig}}
                                    </td>
                                    <td class=" px-1 py-1 border text-center">
                                        <form action="/nig/{{$nig->id}}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button class=" py-1 px-2 bg-red-500 text-white">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>