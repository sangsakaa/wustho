<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Status Anak' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Status Anak ') }}
        </h2>
    </x-slot>
    <div class="py-2 px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid sm:grid-cols-4 grid-cols-2 capitalize">
                        <div>Nama </div>
                        <div class=" border-red-500 text-sm ">: {{$siswa->nama_siswa}}</div>
                        <div>Tanggal Lahir </div>
                        <div class=" ">: {{$siswa->tempat_lahir}} , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}</div>
                        <div>Jenis Kelamin </div>
                        <div>: {{$siswa->jenis_kelamin}}</div>
                        <div class="  grid w-36    ">Status Asrama </div>
                        <div class=" "> :
                            @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama !== null)
                            {{$siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama}}
                            @else
                            <span class=" text-red-600 ">Belum Memiliki Asrama</span>
                            @endif
                        </div>

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
                        <a href="/siswa/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1  hover:bg-purple-500 text-white">Kembali</a>
                        @role('siswa')
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        @endrole
                        @role('super admin')
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
                        <form action="/statusanak/{{$siswa->id}}" method="post">
                            @csrf
                            <div class=" grid grid-cols-2 gap-2">
                                <input type="hidden" name="siswa_id" class=" py-1" placeholder="siswa" value="{{$siswa->id}}">
                                <input type="number" name="anak_ke" class=" py-1" placeholder="anak ke : 5">
                                <input type="number" name="jumlah_saudara" class=" py-1" placeholder="jumlah saudara ke : 5">
                                <select name="status_anak" id="" class=" py-1 capitalize">
                                    <option value="kandung" class=" capitalize">kandung</option>
                                    <option value="tiri">tiri</option>
                                </select>
                                <input type="text" name="nama_ibu" class=" py-1" placeholder="nama_ibu">
                                <input type="text" name="nama_ayah" class=" py-1" placeholder="nama_ayah">
                                <input type="text" name="nomor_hp_ibu" class=" py-1" placeholder="nomor_hp_ibu">
                                <input type="text" name="nomor_hp_ayah" class=" py-1" placeholder="nomor_hp_ayah">
                                <input type="text" name="pekerjaan_ibu" class=" py-1" placeholder="pekerjaan_ibu">
                                <input type="text" name="pekerjaan_ayah" class=" py-1" placeholder="pekerjaan_ayah">
                                <button class=" bg-green-600 py-1 px-2 rounded-sm text-white capitalize">Simpan</button>
                            </div>
                        </form>
                        <div>
                            <span>Detail Status Anak</span>
                            <table class=" w-full    ">
                                <thead>
                                    <tr class=" border-collapse">
                                        <th class=" border text-center">Status Anak</th>
                                        <th class=" border text-center"> jumlah saudara</th>
                                        <th class=" border text-center"> anak ke</th>
                                        <th class=" border text-center"> Ayah</th>
                                        <th class=" border text-center"> Perkerjaan</th>
                                        <th class=" border text-center"> Nomor Hp</th>
                                        <th class=" border text-center"> Ibu</th>
                                        <th class=" border text-center"> Perkerjaan</th>
                                        <th class=" border text-center"> Nomor Hp</th>
                                        <th class=" border text-center"> aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sp as $org)
                                    <tr class=" border">
                                        <td class=" px-2 border text-center ">{{$org->status_anak}}</td>
                                        <td class=" px-2 border text-center ">{{$org->jumlah_saudara}}</td>
                                        <td class=" px-2 border text-center ">{{$org->anak_ke}}</td>
                                        <td class=" px-2 border text-center ">{{$org->nama_ayah}}</td>
                                        <td class=" px-2 border text-center ">{{$org->pekerjaan_ayah}}</td>
                                        <td class=" px-2 border text-center ">{{$org->nomor_hp_ayah}}</td>
                                        <td class=" px-2 border text-center ">{{$org->nama_ibu}}</td>
                                        <td class=" px-2 border text-center ">{{$org->pekerjaan_ibu}}</td>
                                        <td class=" px-2 border text-center ">{{$org->nomor_hp_ibu}}</td>
                                        <td class=" text-sm flex justify-center py-1  gap-1">
                                            @role('super admin')
                                            <form action="/statusanak/{{$org->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class=" bg-red-500 text-white p-1 rounded-md flex"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg></button>
                                            </form>
                                            @endrole
                                            <a href="/statusanak/{{$org->id}}/edit" class=" bg-yellow-500 rounded p-1 flex ">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg></a>

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