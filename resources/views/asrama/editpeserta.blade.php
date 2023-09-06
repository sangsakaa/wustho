<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Asrama Peserta Asrama ') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class=" p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="/pesertaasrama/{{$pesertaasrama->id}}" method="post">
                    @csrf
                    @method('patch')
                    <div class=" grid grid-cols-1 w-1/2 gap-2">
                        <input type="hidden" name="siswa_id" class=" py-1  " value="{{$anggota->id}}" readonly>
                        <input type="text" placeholder="{{$anggota->nama_siswa}}" class=" py-1" readonly>
                        <select name="asramasiswa_id" id="" class=" py-1  uppercase">

                            @foreach($dataasrama as $asrama)
                            <option value="{{$asrama->id}}" {{ $pesertaasrama->asramasiswa_id == $asrama->id ? "selected" : "" }}>{{$loop->iteration}} | {{$asrama->nama_asrama}} </option>
                            @endforeach
                        </select>
                        <div class=" flex gap-2">
                            <div>
                                <button class=" bg-blue-600 text-white rounded-md px-4 py-1"> Update Asrama</button>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class=" px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-blue-200 border-b border-gray-200">
                    <div class="flex justify-items-end grid-cols-1 gap-2  py-1">
                        <div class=" grid grid-cols-1">
                            <span class=" text-bold">Keterangan :</span>
                            <div class=" px-2">
                                <p class=" capitalize">1. Untuk penambahan <b>anggota asrama </b> <u>wajib</u> memiliki <b><u>NIS (nomor induk siswa)</u></b> </p>
                                <p class=" capitalize">2. jika tidak memili harap <b>NIS (nomor induk siswa)</b> konfimasi ke pihak madin bagian <b>kesiswaan & kepala sekolah</b> </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>