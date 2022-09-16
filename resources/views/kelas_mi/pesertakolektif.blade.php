<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Peserta Kelas Kolektif' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peserta Kelas Kolektif') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" grid justify-items-end">
                        <a href="kelas_mi">
                            <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> Kembali</button>
                        </a>
                    </div>
                    <form action="/pesertakolektif" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" py-1 w-3/5 grid grid-cols-2 gap-2 ">
                            <select name="kelasmi_id" id="" class=" py-1 w-full" required>
                                <option value="">-- Pilih Kelas Sesuia Periode --</option>
                                @foreach($kelas as $kelas )
                                <option value="{{$kelas->id}}">{{$kelas->nama_kelas}} {{$kelas->periode}} {{$kelas->ket_semester}}{{$kelas->ket_periode}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class=" w-1/5 bg-blue-600 text-white rounded-sm px-2 py-1"> Kolektif</button>
                        </div>
                        <table class=" w-full">
                            <thead>
                                <tr class=" border">
                                    <th class=" border"><input type="checkbox" name="" id=""></th>
                                    <th class=" border">#</th>
                                    <th class=" border">Nomor Induk Siswa</th>
                                    <th class=" border">Nama Siswa</th>
                                    <th class=" border">JK</th>
                                    <th class=" border">Asal Kota</th>
                                    <th class=" border">Asrama</th>
                                    <th class=" border">Angkatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($Datasiswa->count())
                                @foreach ($Datasiswa as $item)
                                <tr class=" border hover:bg-green-200">
                                    <td class=" text-center">
                                        <input type="checkbox" name="siswa[]" value="{{$item->id}}" multiple>
                                    </td>
                                    <td class=" px-2 border text-center">
                                        {{$loop->iteration}}
                                    </td>
                                    <td class=" px-2 border text-center">
                                        <label for="">{{ $item->nis}}</label>
                                    </td>
                                    <td class=" px-2 border text-left">
                                        <label for="">{{ $item->nama_siswa }}</label>
                                    </td>

                                    <td class=" px-2 border text-center">
                                        <label for="">{{ $item->jenis_kelamin}}</label>
                                    </td>
                                    <td class=" px-2 border text-left">
                                        <label for="">{{ $item->kota_asal}}</label>
                                    </td>
                                    <td class=" px-2 border text-center">
                                        <label for="">{{ $item->nama_asrama}}</label>
                                    </td>
                                    <td class=" border text-center ">
                                        <?php
                                        $date = date_create($item->tanggal_masuk);
                                        echo date_format($date, "Y");
                                        ?>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class=" px-2 border text-center" colspan="6">
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>