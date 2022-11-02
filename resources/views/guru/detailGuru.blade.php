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
                        <table class=" border w-1/2">
                            <thead>
                                <tr class=" border">
                                    <th>no</th>
                                    <th class=" text-left">Nama Pengajar</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatMengajar as $ngajar)
                                <tr class=" border">
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$ngajar->nama_guru}}</td>
                                    <td>{{$ngajar->nama_kelas}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>