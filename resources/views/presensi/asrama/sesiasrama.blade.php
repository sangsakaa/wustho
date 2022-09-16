<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Sesi Pesensi Asrama' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Sesi Pesensi Asrama') }}
    </h2>
  </x-slot>
  @role('admin')
  <div class="px-4 mt-4">
    <div class=" mx-auto ">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class=" p-4">
          <form action="/sesiasrama" method="post">
            @csrf
            <label for=""> Tanggal</label>
            <input type="date" name="tanggal" class=" py-1" value="{{now()}}">
            <label for=""> Periode</label>

            <select name="periode_id" id="" class=" py-1">
              @foreach($periode as $peri)
              <option value="{{$peri->id}}">{{$peri->periode}} {{$peri->ket_semester}}</option>
              @endforeach
            </select>
            <label for=""> Asrama</label>
            <select name="asramasiswa_id" id="" class=" py-1">
              @foreach($asramasiswa as $peri)
              <option value="{{$peri->id}}">{{$peri->nama_asrama}} {{$peri->ket_semester}}</option>
              @endforeach
            </select>
            <label for=""> Kegiatan</label>
            <select name="kegiatan_id" id="" class=" py-1">
              @foreach($kegiatan as $peri)
              <option value="{{$peri->id}}">{{$peri->kegiatan}}</option>
              @endforeach
            </select>
            <button class=" bg-blue-700 text-white py-1 px-2 rounded-md"> Create Sesi Asrama</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endrole
  <div class="px-4 mt-4">
    <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" p-4 ">
        <div class=" flex">
          @role('admin')
          <a href="/asrama"><button class=" flex bg-blue-500 rounded-md py-1 px-2 text-white">Kembali Ke Asrama</button></a>
          @endrole
        </div>
        <div class=" overflow-scroll w-full rounded-md">

          <table class=" w-full mt-2  ">
            <thead>
              <tr class=" capitalize bg-gray-100  ">
                <th class=" py-2 px-2 border">No</th>
                <th class=" px-2 border"> presensi </th>
                <th class=" px-2 border"> tanggal </th>
                <th class=" px-2 border"> periode </th>
                <th class=" px-2 border"> Rincian Kegiatan </th>
                <th class=" px-2 border">asrama </th>
                <th class=" px-2 border">Status </th>
                <th class=" px-2 border">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sesiasrama as $item)
              <tr class=" border  hover:bg-gray-100">
                <th class=" w-5">{{$loop->iteration}}</th>
                <td class=" px-2 text-center py-1"><a href="/sesiasrama/{{$item->id}}"><button class=" bg-blue-500 py-1 px-2 rounded-md text-white hover:bg-purple-500">Presensi</button></a></td>
                <td class=" px-2 text-center">{{$item->tanggal}}</td>
                <td class=" px-2 text-center">{{$item->periode}} {{$item->ket_semester}}</td>
                <td class=" px-2 text-center">{{$item->kegiatan}}</td>
                <td class=" px-2 text-center">{{$item->nama_asrama}}</td>
                <td class=" px-2 text-center">Sudah</td>
                <td class=" px-2 text-center">
                  @role('admin')
                  <form action="/sesiasrama/{{$item->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="py-1 px-2 bg-red-600 text-white rounded-md capitalize">hapus</button>
                  </form>
                  @endrole
                </td>
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