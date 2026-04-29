<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-bold text-gray-800">
      Detail Periode
    </h2>
  </x-slot>

  <div class="p-4 space-y-4">

    <div class="bg-white rounded-xl shadow p-5 border">
      <h3 class="font-semibold text-lg">
        {{ $periode->periode }}
      </h3>

      <div class="mt-3 space-y-2 text-sm text-gray-600">
        <p>Semester: <b>{{ $periode->semester->ket_semester }}</b></p>
        <p>Tanggal Mulai: <b>{{ $periode->tanggal_mulai }}</b></p>
        <p>Tahun Hijriyah: <b>{{ $periode->tahun_hijriyah }}</b></p>
        <p>Status:
          @if($periode->is_active)
          <span class="text-green-600 font-semibold">Aktif</span>
          @else
          <span class="text-red-600 font-semibold">Nonaktif</span>
          @endif
        </p>
      </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">

      <div class="bg-white p-4 rounded-xl shadow border">
        <p class="text-sm text-gray-500">Kelas</p>
        <h3 class="text-2xl font-bold text-blue-600">
          {{ $periode->kelasmi->count() }}
        </h3>
      </div>

      <div class="bg-white p-4 rounded-xl shadow border">
        <p class="text-sm text-gray-500">Asrama</p>
        <h3 class="text-2xl font-bold text-green-600">
          {{ $periode->asramasiswa->count() }}
        </h3>
      </div>

      <div class="bg-white p-4 rounded-xl shadow border">
        <p class="text-sm text-gray-500">Lulusan</p>
        <h3 class="text-2xl font-bold text-purple-600">
          {{ $periode->lulusan->count() }}
        </h3>
      </div>

      <div class="bg-white p-4 rounded-xl shadow border">
        <p class="text-sm text-gray-500">Nominasi</p>
        <h3 class="text-2xl font-bold text-orange-600">
          {{ $periode->nominasi->count() }}
        </h3>
      </div>
    </div>
  </div>
</x-app-layout>