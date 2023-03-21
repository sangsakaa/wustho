<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Transkip' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Data Transkip') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-2 flex grid-cols-1 gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/lulusan" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                Data Lulusan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">
                            <form action="/daftar-transkip" method="post">
                                @csrf
                                <div class=" grid  grid-cols-2 w-full gap-2">
                                    <div class=" w-full  ">
                                        <label for="">Periode Lulusan</label>
                                        <select name="periode_id" id="" class=" w-full  py-1 px-1">
                                            @foreach($dataPeriode as $item)
                                            <option value="{{$item->id}}">{{$item->periode}} {{$item->ket_semester}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" w-full  ">
                                        <label for="">Mata Pelajaran</label>
                                        <select name="mapel_id" id="" class=" w-full  py-1 px-1">
                                            @foreach($dataMapel as $item)
                                            <option value="{{$item->id}}"> Kelas {{$item->kelas}} - {{$item->mapel}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" w-full  ">
                                        <label for="">Type Ujian Akhir</label>
                                        <select name="jenis_ujian_id" id="" class=" w-full  py-1 px-1">
                                            @foreach($dataJenisUjian as $item)
                                            <option value="{{$item->id}}"> Ujian - {{$item->nama_ujian}} {{$item->ket_semester}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" w-full ">
                                        <label for="">Kelas</label>

                                        <select name="kelasmi_id" id="" class=" w-full  py-1 px-1">
                                            @foreach($kelasMi as $item)

                                            <option value="{{$item->id}}">{{$item->id}} - {{$item->nama_kelas}} {{$item->periode}} {{$item->ket_semester}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" w-full ">
                                        <label for="" class=" text-red-500 text-xs">Wajib di isi bagian KURIKULUM</label>
                                        <div>
                                            <button class=" py-1 px-2 bg-blue-600 rounded-sm text-white hover:bg-purple-500">Simpan</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                            <table class=" w-full mt-1 border">
                                <thead class=" border">
                                    <tr class="  uppercase text-sm bg-gray-100">
                                        <th class=" border px-2 py-1">No</th>
                                        <th class=" border px-2 py-1 text-center">Periode</th>
                                        <th class=" border px-2 py-1 text-center">Kelas</th>
                                        <th class=" border px-2 py-1 text-center">Jenis Ujian</th>
                                        <th class=" border px-2 py-1 text-center">Mata Pelajaran
                                        <th class=" border px-2 py-1 text-center">Jumlah <br>
                                            Peserta</th>

                                        <th class=" border px-2 py-1 text-center">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataTranskip as $item)
                                    <tr>
                                        <th class=" border px-2 py-1 text-center">{{$loop->iteration}}</th>
                                        <td class=" border px-2 py-1 text-center"><a href="/nilai_transkip/{{$item->id}}">{{$item->periode}} {{$item->ket_semester}}</a></td>
                                        <td class=" border px-2 py-1 text-center"> {{$item->nama_kelas}}</td>
                                        <td class=" border px-2 py-1 text-center">Ujian - {{$item->nama_ujian}}</td>
                                        <td class=" border px-2 py-1 text-center"> Kelas {{$item->kelas}} - {{$item->mapel}}</td>
                                        <td class=" border px-2 py-1 text-center">{{$item->NilatTranskip->count()}}</td>
                                        <td class=" border px-2 py-1 text-center">


                                            <form action="/daftar-transkip/{{$item->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class=" px-1 py-1 bg-red-600 text-white">
                                                    <x-icons.hapus class="flex-shrink-0 w-4 h-4" aria-hidden="true" />
                                                </button>
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