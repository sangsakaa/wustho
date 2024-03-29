<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Lulusan' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Lulusan') }}
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
                            <a href="/daftar-transkip" class=" capitalize py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                daftar transkip
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
                            <form action="/lulusan" method="post">
                                @csrf
                                <div class=" grid  grid-cols-4 w-full gap-2">
                                    <label for="">Periode Lulusan</label>
                                    <select name="periode_id" id="" class=" w-full  py-1 px-1">
                                        @foreach($dataPeriode as $item)
                                        <option value="{{$item->id}}">{{$item->periode}} {{$item->ket_semester}}</option>
                                        @endforeach
                                    </select>
                                    <label for="">Tanggal Mulai</label>
                                    <input type="date" class="py-1 px-1 w-full" name="tanggal_mulai">
                                    <label for="">Tanggal Hijriyah</label>
                                    <input type="text" class="py-1 px-1 w-full" name="tanggal_lulus_hijriyah" placeholder="12 Robi'ul Awwal 1444">
                                    <label for="">Tanggal Selesai</label>
                                    <input type="date" class="py-1 px-1 w-full" name="tanggal_selesai">
                                    <label for="">Tanggal Kelulusan</label>
                                    <input type="date" class="py-1 px-1 w-full" name="tanggal_kelulusan">
                                    <label for="">Kelas</label>
                                    <select name="kelasmi_id" id="" class="   py-1 px-1">
                                        @foreach($kelasMi as $item)
                                        <option value="{{$item->id}}">{{$item->nama_kelas}} {{$item->periode}} {{$item->ket_semester}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" py-2 grid justify-end">
                                    <label for="">
                                        <span class=" text-red-600">
                                            data ini dari bagian Kurikulum
                                        </span>
                                    </label>
                                    <button class=" py-1 px-2 bg-blue-600 rounded-sm text-white hover:bg-purple-500">Simpan</button>
                                </div>
                            </form>
                            <table class=" w-full mt-1 border">
                                <thead class=" border">
                                    <tr class="  uppercase text-sm bg-gray-100">
                                        <th class=" border px-2 py-1">No</th>
                                        <th class=" border px-2 py-1 text-center">Periode</th>
                                        <th class=" border px-2 py-1 text-center">Kelas</th>
                                        <th class=" border px-2 py-1 text-center">Tanggal Mulai</th>
                                        <th class=" border px-2 py-1 text-center">Tanggal Selesai</th>
                                        <th class=" border px-2 py-1 text-center">Tanggal Kelulusan</th>
                                        <th class=" border px-2 py-1 text-center">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($dataLulusan->count() != null)
                                    @foreach($dataLulusan as $list)
                                    <tr>
                                        <th>{{$loop->iteration}}</th>
                                        <td class=" border text-center capitalize"><a href="/daftar-lulusan/{{$list->id}}">{{$list->periode}} {{$list->ket_semester}}</a></td>
                                        <td class=" border text-center capitalize"><a href="/daftar-lulusan/{{$list->id}}">{{$list->nama_kelas}}</a></td>
                                        <td class=" border text-center capitalize">
                                            {{ \Carbon\Carbon::parse($list->tanggal_mulai)->isoFormat('D MMM Y') }}
                                        </td>
                                        <td class=" border text-center capitalize">
                                            {{ \Carbon\Carbon::parse($list->tanggal_selesai)->isoFormat('D MMM Y') }}
                                        </td>
                                        <td class=" border text-center capitalize">
                                            {{ \Carbon\Carbon::parse($list->tanggal_kelulusan)->isoFormat('D MMMM Y') }}
                                            <br>
                                            {{ $list->tanggal_lulus_hijriyah }}
                                        </td>

                                        <td class=" border text-center capitalize">
                                            <form action="/lulusan/{{$list->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class=" px-1 py-1 bg-red-600 text-white">
                                                    <x-icons.hapus class="flex-shrink-0 w-4 h-4" aria-hidden="true" />
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class=" border text-center capitalize">

                                            <span class=" text-red-600 font-semibold uppercase text-sm text-center">Belum ada Data !!</span>
                                        </td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>