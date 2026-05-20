<x-app-layout>
  <div class="p-6 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">
          Manajemen Lembaga
        </h1>
        <p class="text-sm text-gray-500 mt-1">
          Kelola data lembaga, status aktif, dan informasi lainnya
        </p>
      </div>

      <a href="{{ route('lembaga.create') }}"
        class="inline-flex items-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700
                      text-white font-medium rounded-xl shadow-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 4v16m8-8H4" />
        </svg>
        Tambah Lembaga
      </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('lembaga.index') }}" class="mb-6">
      <div class="relative max-w-md">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Cari kode atau nama lembaga..."
          class="w-full pl-4 pr-4 py-3 rounded-xl border border-gray-300
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
      </div>
    </form>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 border-b">
            <tr>
              <th class="px-6 py-4 text-left font-semibold text-gray-700">Logo</th>
              <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode</th>
              <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama</th>
              <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
              <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100">
            @forelse($lembagas as $item)
            <tr class="hover:bg-gray-50 transition">

              {{-- Logo --}}
              <td class="px-6 py-4">
                @if($item->logo)
                <img src="{{ asset('storage/' . $item->logo) }}"
                  alt="{{ $item->nama }}"
                  class="w-12 h-12 rounded-xl object-cover border shadow-sm">
                @else
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700
                                                    flex items-center justify-center font-bold">
                  {{ strtoupper(substr($item->nama, 0, 1)) }}
                </div>
                @endif
              </td>

              {{-- Kode --}}
              <td class="px-6 py-4 font-semibold text-gray-800">
                {{ $item->kode }}
              </td>

              {{-- Nama --}}
              <td class="px-6 py-4 text-gray-700">
                {{ $item->nama }}
              </td>

              {{-- Status --}}
              <td class="px-6 py-4">
                @if($item->is_active)
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                     bg-green-100 text-green-700">
                  Aktif
                </span>
                @else
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                     bg-red-100 text-red-700">
                  Nonaktif
                </span>
                @endif
              </td>

              {{-- Actions --}}
              <td class="px-6 py-4">
                <div class="flex flex-wrap justify-center gap-2">

                  <a href="{{ route('lembaga.show', $item) }}"
                    class="px-3 py-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                    Detail
                  </a>

                  <a href="{{ route('lembaga.edit', $item) }}"
                    class="px-3 py-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    Edit
                  </a>

                  <form method="POST"
                    action="{{ route('lembaga.destroy', $item) }}"
                    onsubmit="return confirm('Yakin hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                      class="px-3 py-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                      Hapus
                    </button>
                  </form>

                  <form method="POST"
                    action="{{ route('lembaga.toggle', $item) }}">
                    @csrf
                    @method('PATCH')
                    <button
                      class="px-3 py-2 text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                      Toggle
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                Belum ada data lembaga
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
      {{ $lembagas->links() }}
    </div>
  </div>
</x-app-layout>