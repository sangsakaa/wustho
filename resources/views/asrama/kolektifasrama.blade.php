<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peserta Kelas Kolektif Asrama') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" flex justify-end gap-2">
                        <a href="asramasiswa">
                            <button class=" flex bg-blue-600 text-white rounded-sm px-2 py-1"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Kembali</button>
                        </a>
                        <form action="/kolektifasrama" method="get" class=" flex gap-1">
                            <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">
                            <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                Cari </button>
                        </form>
                    </div>

                    <form action="/kolektifasrama" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" py-1 w-3/5 grid grid-cols-2 gap-2 ">
                            <select name="asramasiswa_id" id="" class=" py-1 w-full" required>
                                <option value="">-- Pilih Sesui kelas --</option>
                                @foreach($kelas as $kelas )
                                <option value="{{$kelas->id}}">{{$loop->iteration}} | {{$kelas->nama_asrama}} |{{$kelas->type_asrama}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class=" w-1/5 bg-blue-600 text-white rounded-sm px-2 py-1"> Kolektif</button>
                        </div>
                        <table class=" w-full">
                            <thead>
                                <tr class=" border  bg-gray-100">
                                    <th class=" py-2 border px-2"><input type="checkbox" name="" id=""></th>
                                    <th class=" border px-2">No</th>
                                    <th class=" border px-2" class=" text-center"> Nomor Induk Siswa</th>
                                    <th class=" border px-2">Nama Siswa</th>
                                    <th class=" border px-2"> JK</th>
                                    <th class=" border px-2">Angkatan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($Datasiswa->count())
                                @foreach ($Datasiswa as $item)
                                <tr class=" border hover:bg-green-200">
                                    <td class=" border text-center">
                                        <input type="checkbox" name="siswa[]" value="{{$item->id}}" multiple>
                                    </td>
                                    <td class=" border px-2 text-center">
                                        {{$loop->iteration}}
                                    </td>
                                    <td class=" border px-2 text-center">
                                        <label for="">{{ $item->nis }}</label>
                                    </td>
                                    <td class=" border px-2 text-left">
                                        <label for="">{{ $item->nama_siswa }}</label>
                                    </td>

                                    <td class=" border px-2 text-center">
                                        <label for="">{{ $item->jenis_kelamin}}</label>
                                    </td>
                                    <td class=" border px-2  text-center ">
                                        <?php
                                        $date = date_create($item->tanggal_masuk);
                                        echo date_format($date, "Y");
                                        ?>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class=" border text-center" colspan="6">
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class=" py-1 " colspan="6">
                                        {{$Datasiswa}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>