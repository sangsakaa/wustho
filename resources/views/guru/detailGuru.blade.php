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
        <div class="mt-2">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" ">
                        <span>Riwayat Mengajar</span>
                        <table class=" border w-full">
                            <thead>
                                <tr class=" border ">
                                    <th class=" px-1 text-center border">No</th>
                                    <th class=" px-1 text-center border ">Periode Mengajar</th>
                                    <th class=" px-1 text-center border ">Nama Pengajar</th>
                                    <th class=" px-1 text-center border">Kelas</th>
                                    <th class=" px-1 text-center border ">Mata Pelajaran</th>
                                    <th class=" px-1 text-center border ">Kitab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatMengajar as $ngajar)
                                <tr class=" border">
                                    <th class=" border">{{$loop->iteration}}</th>
                                    <td class=" border text-center">{{$ngajar->periode}} {{$ngajar->ket_semester}}</td>
                                    <td class=" border text-center">{{$ngajar->nama_guru}}</td>
                                    <td class=" border text-center">{{$ngajar->nama_kelas}}</td>
                                    <td class=" border text-center">{{$ngajar->mapel}}</td>
                                    <td class=" border text-center">{{$ngajar->nama_kitab}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>