<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Detail Guru') }}
        </h2>
    </x-slot>
    <div class="">

        <div class="bg-white overflow-hidden shadow-sm ">
            <div class="p-2 bg-white border-b border-gray-200">
                <div class=" p-4 grid grid-cols-4 gap-1">
                    <div>Nama Lengkap</div>
                    <div>: {{$guru->nama_guru}}</div>
                    <div>Jenia Kelamin</div>
                    <div>: {{$guru->jenis_kelamin}}</div>
                </div>
            </div>
        </div>

        <div class="p-4">

            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" ">
                        <span>Riwayat Mengajar</span>
                        <table class=" border w-full">
                            <thead>
                                <tr class=" border">
                                    <th>no</th>
                                    <th class=" text-center">Periode Mengajar</th>
                                    <th class=" text-left">Nama Pengajar</th>
                                    <th>Kelas</th>
                                    <th class=" text-left">Mata Pelajaran</th>
                                    <th class=" text-left">Kitab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatMengajar as $ngajar)
                                <tr class=" border">
                                    <th>{{$loop->iteration}}</th>
                                    <td class=" text-center">{{$ngajar->periode}} {{$ngajar->ket_semester}}</td>
                                    <td>{{$ngajar->nama_guru}}</td>
                                    <td class=" text-center">{{$ngajar->nama_kelas}}</td>
                                    <td class=" text-center">{{$ngajar->mapel}}</td>
                                    <td class=" text-center">{{$ngajar->nama_kitab}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>