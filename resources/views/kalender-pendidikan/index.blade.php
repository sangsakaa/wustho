
<x-app-layout>
  @php
  $kategoriColors = [
  'Pembelajaran' => 'bg-green-100 text-green-700',
  'Asesmen' => 'bg-orange-100 text-orange-700',
  'Ujian' => 'bg-yellow-100 text-yellow-700',
  'Libur' => 'bg-red-100 text-red-700',
  'Hari Besar Nasional' => 'bg-amber-100 text-amber-700',
  'Hari Besar Keagamaan' => 'bg-pink-100 text-pink-700',
  'Peringatan Internasional' => 'bg-cyan-100 text-cyan-700',
  'PPDB' => 'bg-indigo-100 text-indigo-700',
  'Kelulusan' => 'bg-emerald-100 text-emerald-700',
  'Kegiatan Sekolah' => 'bg-blue-100 text-blue-700',
  'Ekstrakurikuler' => 'bg-violet-100 text-violet-700',
  'Rapat' => 'bg-slate-100 text-slate-700',
  'Lainnya' => 'bg-gray-100 text-gray-700',
  ];
  @endphp

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- Header --}}
      <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

          <div>
            <h1 class="text-2xl font-bold text-gray-800">
              Kalender Pendidikan
            </h1>

            <p class="text-sm text-gray-500 mt-1">
              Kelola agenda, ujian, libur, hari besar dan kegiatan sekolah
            </p>
          </div>

          <div class="flex gap-2">

            <a href="{{ route('kalender-pendidikan.pdf') }}"
              target="_blank"
              class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm">

              PDF
            </a>

            <a href="{{ route('kalender-pendidikan.create') }}"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm">

              <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4" />
              </svg>

              Tambah Kegiatan
            </a>

          </div>

        </div>
      </div>

      {{-- Alert --}}
      @if(session('success'))
      <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-300 text-green-700">
        {{ session('success') }}
      </div>
      @endif

      {{-- Statistik --}}
      <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm border p-5">
          <div class="text-sm text-gray-500">
            Total Agenda
          </div>

          <div class="text-3xl font-bold text-indigo-600">
            {{ $data->total() }}
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-5">
          <div class="text-sm text-gray-500">
            Pembelajaran
          </div>

          <div class="text-3xl font-bold text-green-600">
            {{ $data->where('kategori','Pembelajaran')->count() }}
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-5">
          <div class="text-sm text-gray-500">
            Libur
          </div>

          <div class="text-3xl font-bold text-red-600">
            {{ $data->where('kategori','Libur')->count() }}
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-5">
          <div class="text-sm text-gray-500">
            Ujian
          </div>

          <div class="text-3xl font-bold text-yellow-600">
            {{ $data->where('kategori','Ujian')->count() }}
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-5">
          <div class="text-sm text-gray-500">
            Hari Besar
          </div>

          <div class="text-3xl font-bold text-pink-600">
            {{
                            $data->whereIn('kategori', [
                                'Hari Besar Nasional',
                                'Hari Besar Keagamaan'
                            ])->count()
                        }}
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-5">
          <div class="text-sm text-gray-500">
            Kegiatan
          </div>

          <div class="text-3xl font-bold text-blue-600">
            {{ $data->where('kategori','Kegiatan Sekolah')->count() }}
          </div>
        </div>

      </div>

      {{-- Table --}}
      <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="p-4 border-b bg-gray-50">

          <input type="text"
            placeholder="Cari kegiatan..."
            class="w-full md:w-96 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="overflow-x-auto">

          <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">

              <tr>

                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">
                  No
                </th>

                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">
                  Nama Kegiatan
                </th>

                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">
                  Tanggal Mulai
                </th>

                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">
                  Tanggal Selesai
                </th>

                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">
                  Kategori
                </th>

                <th class="px-6 py-2 text-center text-xs font-semibold text-gray-500 uppercase">
                  Aksi
                </th>

              </tr>

            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

              @forelse($data as $item)

              <tr class="hover:bg-gray-50">

                <td class="px-2 py-2">
                  {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                </td>

                <td class="px-2 py-2 text-sm  text-gray-800">
                  {{ $item->nama_kegiatan }}
                </td>

                <td class="px-2 py-2 text-sm text-gray-600">
                  {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                </td>

                <td class="px-2 py-2 text-sm text-gray-600">
                  {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                </td>

                <td class="px-2 py-2">

                  <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $kategoriColors[$item->kategori] ?? 'bg-gray-100 text-gray-700' }}">

                    {{ $item->kategori }}

                  </span>

                </td>

                <td class="px-2 py-2">

                  <div class="flex justify-center gap-2">

                    <a href="{{ route('kalender-pendidikan.edit', $item->id) }}"
                      class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm">
                      Edit
                    </a>

                    <form action="{{ route('kalender-pendidikan.destroy', $item->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">

                      @csrf
                      @method('DELETE')

                      <button type="submit"
                        class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm">
                        Hapus
                      </button>

                    </form>

                  </div>

                </td>

              </tr>

              @empty

              <tr>
                <td colspan="6"
                  class="py-10 text-center text-gray-500">
                  Belum ada data kalender pendidikan.
                </td>
              </tr>

              @endforelse

            </tbody>

          </table>

        </div>

        <div class="p-4 border-t bg-gray-50">
          {{ $data->links() }}
        </div>

      </div>

    </div>
  </div>
</x-app-layout>
