<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Sesi Pesensi Asrama' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Pesensi Asrama') }}
    </h2>
  </x-slot>
  <div class="px-4 mt-4">
    <div class=" mx-auto ">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class=" p-4">
          <div class=" grid grid-cols-2 sm:grid-cols-4">
            <div>Periode</div>
            <div> : {{$presensi->periode}} {{$presensi->ket_semester}}</div>
            <div>Asrama</div>
            <div> : {{$presensi->nama_asrama}} </div>
            <div>Jenis Kegiatan</div>
            <div> : {{$presensi->kegiatan}} </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class=" overflow-scroll px-4 mt-4">
    <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" p-4">

        <form action="/sesiasrama/presensi" method="post">
          @csrf
          <div class=" flex justify-end gap-1">
            @if($update_terakhir == $update_terakhir)
            <span>sudah</span>
            @else
            belum
            @endif
            <button class=" bg-blue-400 py-1 px-2 rounded-md text-white ">simpan presensi</button>
            <a href="/sesiasrama" class=" bg-red-500 px-2 py-1 rounded-md text-white">batal</a>

          </div>
          <div class=" overflow-scroll">
            <table class=" w-full mt-2">
              <thead>
                <tr class=" border capitalize bg-gray-100">
                  <th class=" px-2 border py-1">no</th>
                  <th class=" px-2 border ">Nama Peserta</th>
                  <th class=" px-2 border ">Asrama</th>
                  <th class=" px-2 border ">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($peserta as $item)
                <tr class=" hover:bg-gray-100">
                  <th class=" border px-2 py-1">
                    {{$loop->iteration}}
                    <input type="hidden" name="pesertaasrama_id[]" value="{{ $item->id }}" />
                    <input type="hidden" name="presensiasrama_id[{{ $item->id }}]" value="{{ $item->presensiasrama_id }}">
                    <input type="hidden" name="sesiasrama_id" value="{{ $sesiasrama->id }}">
                  </th>
                  <td class="border px-2 py-1">{{$item->nama_siswa}}</td>
                  <td class="border px-2 py-1 text-center">{{$item->nama_asrama}}</td>
                  <td class="   text-right   px-1 py-1 border ">
                    <input type="radio" id="hadir[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="hadir" class=" " {{ $item->keterangan === 'hadir' || $item->keterangan === null ? 'checked' : '' }}>
                    <label for="hadir[{{ $item->id }}]" class=" ">Hadir</label>
                    <input type="radio" id="izin[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="izin" class=" " {{ $item->keterangan === 'izin' ? 'checked' : '' }}>
                    <label for="izin[{{ $item->id }}]" class=" ">Izin</label>
                    <input type="radio" id="sakit[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="sakit" class=" " {{ $item->keterangan === 'sakit' ? 'checked' : '' }}>
                    <label for="sakit[{{ $item->id }}]" class=" ">Sakit</label>
                    <input type="radio" id="alfa[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="alfa" class=" " {{ $item->keterangan === 'alfa' ? 'checked' : '' }}>
                    <label for="alfa[{{ $item->id }}]" class=" ">Alfa</label>
                    <input type="text" name="alasan[{{ $item->id }}]" class="   py-1 px-2" placeholder="Keterangan untuk semua keadaan">
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>

  </div>
  <div class="px-4 mt-1">
    <div class=" mx-auto mt-1 ">
      <div class="bg-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
        -
      </div>
    </div>
  </div>
</x-app-layout>