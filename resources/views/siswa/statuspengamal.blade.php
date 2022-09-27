<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Status Pengamal' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Status Pengamal ') }}
        </h2>
    </x-slot>
    <div class="py-2 px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid sm:grid-cols-4 grid-cols-2">
                        <div>Nama </div>
                        <div class=" border-red-500 text-sm ">: {{$siswa->nama_siswa}}</div>
                        <div>Tanggal Lahir </div>
                        <div>: {{$siswa->tempat_lahir}}</div>
                        <div>Jenis Kelamin </div>
                        <div>: {{$siswa->jenis_kelamin}}</div>
                        <div>Tempat Lahir </div>
                        <div>: {{$siswa->tanggal_lahir}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" flex grid-cols-1 justify-items-end gap-1">
                        <a href="/siswa" class=" bg-blue-500 px-2 py-1  hover:bg-purple-500 text-white">Kembali</a>
                        @role('siswa')
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        @endrole
                        @role('admin')
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/biodata/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Biodata Lengkap</a>
                        </div>

                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/statuspengamal/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Pengamal</a>
                        </div>

                        @endrole
                    </div>
                    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 py-1">
                        <form action="/statuspengamal/{{$siswa->id}}" method="post">
                            @csrf
                            <input type="text" name="siswa_id" class=" py-1" placeholder="siswa" value="{{$siswa->id}}">
                            <select name="status_pengamal" id="" class=" py-1">
                                <option value="pengamal" class=" capitalize">pengamal</option>
                                <option value="simpatisan" class=" capitalize">simpatisan</option>
                            </select>
                            <button class=" bg-green-600 py-1 px-2 rounded-sm text-white capitalize">create status pengamal</button>
                        </form>
                        <div>
                            <span>Detail Kelas</span>

                            <table class=" w-1/2    ">
                                <thead>
                                    <tr class=" border-collapse">
                                        <th class=" border text-center">#</th>
                                        <th class=" border text-center"> Status Pengamal</th>
                                        <th class=" border text-center"> Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($statuspengamal as $org)
                                    <tr class=" border">
                                        <td class=" px-2 border ">{{$org->nama_siswa}}</td>
                                        <td class=" px-2 border ">{{$org->status_pengamal}}</td>
                                        <td class=" text-sm flex justify-center py-1  gap-1">
                                            <form action="/statuspengamal/{{$siswa->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class=" bg-red-500 text-white p-1 rounded-md flex"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg></button>
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
        </div>
    </div>



</x-app-layout>