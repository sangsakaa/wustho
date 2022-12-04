<x-app-layout>
  <x-slot name="header">
    @section('title')
    <h2 class="font-semibold text-xl  leading-tight">
      Dashboard Asrama :{{$presensi->nama_asrama }}
    </h2>
  </x-slot>
  <div class=" mt-2">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" p-4">
        <div class=" grid grid-cols-2 sm:grid-cols-4 capitalize">
          <div>asrama</div>
          <div> : {{$presensi->nama_asrama}} </div>
          <div>semester</div>
          <div>
            :
            {{$presensi->semester}}

          </div>
          <div>periode</div>
          <div>
            :
            {{$presensi->periode}} {{$presensi->ket_semester}}
          </div>
          <div>Nama Kegiatan</div>
          <div> : {{$presensi->kegiatan}}</div>
        </div>
      </div>
    </div>
  </div>
  <div class=" overflow-scroll  mt-2">
    <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
      <div class=" p-2">
        <form action="/sesiasrama/presensi" method="post">
          @csrf
          <div class=" flex justify-end gap-1">
            @if($create_at == $update_terakhir)
            <span class=" text-white bg-red-600 py-1 px-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            </span>
            @elseif($update_terakhir >= $create_at) <span class=" text-white  bg-green-700 px-1 py-1 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>

            </span> @endif <button class=" bg-blue-400 py-1 px-2 rounded-md text-white ">simpan presensi</button>
            <a href="/sesiasrama" class=" bg-red-500 px-2 py-1 rounded-md text-white">batal</a>

          </div>
          <div class=" overflow-auto dark:bg-dark-bg ">
            <table class=" w-full mt-2 ">
              <thead>
                <tr class=" border capitalize bg-gray-100 text-sm">
                  <th class=" px-2 border ">no</th>
                  <th class=" px-2 border w-1/2 ">Peserta</th>
                  <th class=" px-1 border ">Keterangan </th>
                </tr>
              </thead>
              <tbody>
                @foreach($peserta as $item)
                <tr class=" hover:bg-gray-100 text-sm">
                  <th class=" border px-2 text-sm ">
                    {{$loop->iteration}}
                    <input type="hidden" name="pesertaasrama_id[]" value="{{ $item->id }}" />
                    <input type="hidden" name="presensiasrama_id[{{ $item->id }}]" value="{{ $item->presensiasrama_id }}">
                    <input type="hidden" name="sesiasrama_id" value="{{ $sesiasrama->id }}">
                  </th>
                  <td class="border px-2  text-xs sm:text-sm w-1/2 capitalize">{{strtolower($item->nama_siswa)}}</td>

                  <td class="   text-right   px-1   border ">
                    <input class="text-xs py-1 sm:text-sm  " type="radio" id="hadir[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="hadir" class=" " {{ $item->keterangan === 'hadir' || $item->keterangan === null ? 'checked' : '' }}>
                    <label for="hadir[{{ $item->id }}]" class=" ">H</label>
                    <input class="text-xs py-1 sm:text-sm " type="radio" id="izin[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="izin" class=" " {{ $item->keterangan === 'izin' ? 'checked' : '' }}>
                    <label for="izin[{{ $item->id }}]" class=" ">I</label>
                    <input class="text-xs py-1 sm:text-sm " type="radio" id="sakit[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="sakit" class=" " {{ $item->keterangan === 'sakit' ? 'checked' : '' }}>
                    <label for="sakit[{{ $item->id }}]" class=" ">S</label>
                    <input class="text-xs py-1 sm:text-sm " type="radio" id="alfa[{{ $item->id }}]" name="keterangan[{{ $item->id }}]" value="alfa" class=" " {{ $item->keterangan === 'alfa' ? 'checked' : '' }}>
                    <label for="alfa[{{ $item->id }}]" class=" ">A</label>
                    <input class="text-xs py-1 sm:text-sm " type="text" name="alasan[{{ $item->id }}]" class="    px-2" placeholder="Keterangan ">

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