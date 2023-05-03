<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Asrama Siswa') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" flex grid-cols-2 w-full gap-1">
                        <div>
                            <a href="/addasramasiswa">
                                <button class=" bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <form action="/asramasiswa/{{$asramasiswa->id}}" method="post">
                        @csrf
                        @method('patch')
                        <div class=" grid grid-cols-1 gap-2 sm:grid-cols-4 sm:grid">
                            <input type="hidden" name="asrama_id" class=" py-1 " placeholder=" Kuota : 40" value="{{$asramasiswa->asrama_id}}" readonly>
                            <select name="asrama_id" id="" class=" py-1  uppercase">
                                @foreach($dataasrama as $asrama)
                                <option class=" w-1/4" value="{{$asrama->id}}" {{ $asramasiswa->asrama_id == $asrama->id ? "selected" : "" }}>
                                    {{$loop->iteration}}
                                    . {{$asrama->nama_asrama}}
                                </option>
                                @endforeach
                            </select>
                            <input type="text" name="kuota" class=" py-1 " placeholder=" Kuota : 40" value="{{$asramasiswa->kuota}}">
                            <button class=" bg-blue-600 text-white rounded-md px-2 py-1"> Update</button>
                            <a class=" bg-blue-600 text-white text-center rounded-md px-2 py-1" href="/asramasiswa">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class=" px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-blue-200 border-b border-gray-200">
                    <div class="flex justify-items-end grid-cols-1 gap-2  py-1">
                        <div class=" grid grid-cols-1 text-xs sm:text-sm">
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