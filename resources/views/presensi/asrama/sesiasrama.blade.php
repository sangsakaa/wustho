<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Sesi Pesensi' )
    <h2 class="font-semibold text-xl  leading-tight">
      {{ __('Sesi Pesensi Asrama') }}
    </h2>
  </x-slot>
  @can('show post')
  <div class="px-4 mt-4">
    <div class=" mx-auto ">
      <div class="bg-white overflow-auto shadow-sm  ">
        <form action="/sesiasrama" method="post" class=" text-sm">
          @csrf
          <div class=" p-4 grid grid-cols-1  sm:grid-cols-5 gap-2  ">
            <!-- <label for="" class=" py-2"> Tanggal</label> -->
            <input type="date" name="tanggal" class=" py-1 text-sm dark:bg-dark-bg" value="{{ $tanggal->toDateString() }}">
            <!-- <label for="" class=" py-2"> Periode</label> -->
            <select name="periode_id" id="" class=" py-1 text-xs sm:text-sm">
              @foreach($periode as $peri)
              <option value="{{$peri->id}}">{{$peri->periode}} {{$peri->ket_semester}}</option>
              @endforeach
            </select>
            <!-- <label for="" class=" py-2"> Asrama</label> -->
            <select name="asramasiswa_id" id="" class=" py-1 text-xs sm:text-sm">
              <option value="">-- Pilih Asrama --</option>
              @foreach($asramasiswa as $peri)
              <option value="{{$peri->id}}">{{$peri->nama_asrama}} </option>
              @endforeach
            </select>
            <!-- <label for="" class=" py-2"> Kegiatan</label> -->
            <select name="kegiatan_id" id="" class=" py-1 text-xs sm:text-sm">
              <option value="">-- Pilih kegiatan --</option>
              @foreach($kegiatan as $peri)
              <option value="{{$peri->id}}">{{$peri->kegiatan}}</option>
              @endforeach
            </select>
            <button class=" bg-blue-700  text-white py-1 px-2 "> Create Sesi Asrama</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endcan
  <div class="px-4 mt-4">
    <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" p-4 ">
        <div class=" flex gap-2">
          @role('super admin')
          <a href="/asrama"><button class=" flex bg-blue-500 rounded-md py-1 px-2 text-white">Back </button></a>
          <a href="/kegiatan"><button class=" flex bg-blue-500 rounded-md py-1 px-2 text-white">
              <span>
                <x-icons.usercircle></x-icons.usercircle>
              </span>
              Kegiatan</button></a>
          @endrole

        </div>
        <div class=" overflow-auto w-full rounded-md">
          <form action="/sesiasrama" method="get" class=" py-1">
            <input type="date" name="tanggal" class=" py-1 dark:bg-dark-bg" value="{{ $tanggal->toDateString() }}">
            <button class=" bg-blue-600 py-1 text-white px-2">
              Cari By Tanggal
            </button>
          </form>
          <table class=" w-full mt-2  ">
            <thead>
              <tr class=" capitalize bg-gray-100 text-sm  ">
                <th class=" py-2 px-2 border">No</th>
                <th class=" px-2 border"> presensi </th>
                <th class=" px-2 border"> tanggal </th>
                @role('super admin')
                <th class=" px-2 border"> periode </th>
                @endrole
                <th class=" px-2 border"> Rincian Kegiatan </th>
                <th class=" px-2 border">asrama </th>
                <th class=" px-2 border">Status <br> Kehadiran </th>
                @role('super admin')
                <th class=" px-2 border">Aksi </th>
                @endrole
              </tr>
            </thead>
            <tbody>
              @foreach ($Datasesiasrama as $item)
              <tr class=" border  hover:bg-gray-100 text-sm">
                <th class=" w-5">{{$loop->iteration}}</th>
                <td class=" px-2 text-center py-1"><a href="/sesiasrama/{{$item->id}}"><button class=" bg-blue-500 py-1 px-2 rounded-md text-white hover:bg-purple-500">Presensi</button></a></td>
                <td class=" px-2 text-center">
                  {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat(' DD MMMM Y') }}
                </td>
                @role('super admin')
                <td class=" px-2 text-center">{{$item->periode}} {{$item->ket_semester}}</td>
                @endrole
                <td class=" px-2 text-center">{{$item->kegiatan}}</td>
                <td class=" px-2 text-center">

                  @if($item->type_asrama == "Putri" )
                  <span class=" bg-pink-600 px-2 py-1 text-white font-semibold uppercase"> {{$item->nama_asrama}}</span>
                  @else
                  <span class=" bg-sky-600 px-2 py-1 text-white font-semibold uppercase"> {{$item->nama_asrama}}</span>
                  @endif

                </td>
                <td class=" px-2 text-center">
                  <span class=" font-semibold">{{$item->SesiAsrama->count()}} </span>|
                  {{$item->SesiAsrama->countBy('keterangan')}}
                </td>
                @role('super admin')
                <td class=" px-2 text-center">
                  <form action="/sesiasrama/{{$item->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="py-1 px-2 bg-red-600 text-white rounded-md capitalize">
                      <x-icons.hapus></x-icons.hapus>
                    </button>
                  </form>
                </td>
                @endrole
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <div class="px-4 mt-1">
    <div class=" mx-auto mt-1 ">
      <div class="bg-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
        <div class=" p-4">
          <p class=" font-semibold">Keterangan :</p>
          <p class="px-2">1. Pelaporan Kehadiran di isi oleh petugas yaitu <b>Ketua Asrama atau Jampeng (Jama'ah dan Pengajian)</b></p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>