<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
      <div>
        <h2 class="font-semibold text-xl text-gray-800">
          Dashboard Asrama
        </h2>
        <p class="text-sm text-gray-500">
          {{ $presensi->nama_asrama }}
        </p>
      </div>
    </div>
  </x-slot>

  <div class="p-3 space-y-3">

    {{-- CARD INFO --}}
    <div class="bg-white shadow rounded-xl p-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm">

        <div>
          <p class="text-gray-500">Asrama</p>
          <p class="font-semibold capitalize">{{ $presensi->nama_asrama }}</p>
        </div>

        <div>
          <p class="text-gray-500">Semester</p>
          <p class="font-semibold">{{ $presensi->semester }}</p>
        </div>

        <div>
          <p class="text-gray-500">Periode</p>
          <p class="font-semibold">
            {{ $presensi->periode }} {{ $presensi->ket_semester }}
          </p>
        </div>

        <div>
          <p class="text-gray-500">Kegiatan</p>
          <p class="font-semibold capitalize">{{ $presensi->kegiatan }}</p>
        </div>

      </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white shadow rounded-xl">

      <form action="/sesiasrama/presensi" method="post">
        @csrf

        {{-- HEADER ACTION --}}
        <div class="flex flex-wrap justify-between items-center p-3 border-b gap-2">

          <div class="flex items-center gap-2">
            {{-- STATUS --}}
            @if($create_at == $update_terakhir)
            <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">
              Belum disimpan
            </span>
            @else
            <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded">
              Sudah tersimpan
            </span>
            @endif
          </div>

          <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm shadow">
              💾 Simpan
            </button>

            <a href="/sesiasrama"
              class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1.5 rounded-lg text-sm shadow">
              Batal
            </a>
          </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-auto max-h-[500px]">
          <table class="w-full text-sm border-collapse">

            <thead class="bg-gray-100 sticky top-0 z-10">
              <tr class="text-xs uppercase text-gray-600">
                <th class="border px-2 py-2 w-10">No</th>
                <th class="border px-2 py-2">Peserta</th>
                <th class="border px-2 py-2 w-[350px]">Keterangan</th>
              </tr>
            </thead>

            <tbody>
              @foreach($peserta as $item)
              <tr class="hover:bg-gray-50">

                {{-- NO --}}
                <td class="border text-center">
                  {{ $loop->iteration }}

                  <input type="hidden" name="pesertaasrama_id[]" value="{{ $item->id }}">
                  <input type="hidden" name="presensiasrama_id[{{ $item->id }}]" value="{{ $item->presensiasrama_id }}">
                  <input type="hidden" name="sesiasrama_id" value="{{ $sesiasrama->id }}">
                </td>

                {{-- NAMA --}}
                <td class="border px-2 capitalize">
                  {{ strtolower($item->nama_siswa) }}
                </td>

                {{-- KETERANGAN --}}
                <td class="border px-2 py-1">

                  <div class="flex flex-wrap items-center gap-2">

                    @foreach(['hadir'=>'H','izin'=>'I','sakit'=>'S','alfa'=>'A'] as $key => $label)
                    <label class="flex items-center gap-1 cursor-pointer">
                      <input type="radio"
                        name="keterangan[{{ $item->id }}]"
                        value="{{ $key }}"
                        class="accent-blue-600"
                        {{ $item->keterangan === $key || ($key=='hadir' && $item->keterangan==null) ? 'checked' : '' }}>
                      <span class="text-xs font-medium">{{ $label }}</span>
                    </label>
                    @endforeach

                    <input type="text"
                      name="alasan[{{ $item->id }}]"
                      value="{{ $item->alasan }}"
                      placeholder="Alasan..."
                      class="border rounded px-2 py-1 text-xs focus:ring focus:ring-blue-200">
                  </div>

                </td>

              </tr>
              @endforeach
            </tbody>

          </table>
        </div>

      </form>
    </div>

    {{-- FOOTER INFO --}}
    <div class="bg-blue-50 border border-blue-200 text-blue-700 p-3 rounded-lg text-sm">
      💡 Gunakan H (Hadir), I (Izin), S (Sakit), A (Alfa) untuk presensi peserta.
    </div>

  </div>
</x-app-layout>