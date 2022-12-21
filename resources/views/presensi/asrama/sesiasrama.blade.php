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
              <option value="" class=" text-center">---- Pilih Asrama ----</option>
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
  <div class="px-4 mt-4 ">
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
          <table class=" w-full mt-2   ">
            <thead class=" capitalize text-xs ">
              <th class=" py-2 px-2 border">No</th>
              <th class=" px-2 border"> presensi </th>
              <th class=" px-2 border"> tanggal </th>
              <th class=" px-2 border"> periode </th>
              <th class=" px-2 border"> Rincian <br> Kegiatan </th>
              <th class=" px-2 border">Status <br> Kehadiran </th>
              <th class=" px-2 w-10 text-center border ">Status <br> Presensi </th>
              <th class=" px-2 border">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @if($Datasesiasrama->count() != null)
              @foreach ($Datasesiasrama as $item)
              <tr class=" border  hover:bg-gray-100 text-xs even:bg-gray-100">
                <th class=" w-5">{{$loop->iteration}}</th>
                <td class=" border px-2 text-center py-1"><a href="/sesiasrama/{{$item->id}}">
                    @if($item->type_asrama == "Putri" )
                    <span class=" bg-pink-600 px-2 py-1 text-white font-semibold uppercase"> {{$item->nama_asrama}}</span>
                    @else
                    <span class=" bg-sky-600 px-2 py-1 text-white font-semibold uppercase"> {{$item->nama_asrama}}</span>
                    @endif
                <td class=" border px-2 text-center">
                  {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat(' DD MMMM Y') }}
                </td>

                <td class=" border px-2 text-center">{{$item->periode}} {{$item->ket_semester}}</td>

                <td class=" border px-2 text-center">{{$item->kegiatan}}</td>

                <td class=" border px-2 text-center capitalize">
                  <span class=" font-semibold">{{$item->SesiAsrama->count()}} org </span>|
                  {{$item->SesiAsrama->countBy('keterangan')}}
                </td>
                <td class=" text-center py-1 grid justify-center">
                  @if($item->SesiAsrama->count() == 0 )
                  <span class=" text-red-600 items-center ">
                    <x-icons.x-mark></x-icons.x-mark>
                  </span>
                  @else
                  <span class=" text-green-600  ">
                    <x-icons.check></x-icons.check>
                  </span>
                  @endif
                </td>

                <td class=" border px-2 text-center">
                  <form action="/sesiasrama/{{$item->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="py-1 px-2 bg-red-600 text-white rounded-md capitalize">
                      <x-icons.hapus></x-icons.hapus>
                    </button>
                  </form>
                </td>

              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="8" class=" border text-red-600 font-semibold capitalize text-center">Sesi belum di buat</td>
              </tr>
              @endif

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