<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
          🔍 Storage Analyzer
        </h2>
        <p class="text-gray-500 text-sm">
          Analisa folder yang menggunakan storage paling besar.
        </p>
      </div>

      <a href="{{ route('maintenance.index') }}"
        class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg">
        ← Kembali
      </a>
    </div>
  </x-slot>

  <div class="py-6">

    <div class="max-w-7xl mx-auto px-4">

      @if(session('success'))
      <div class="mb-5 rounded-lg border border-green-300 bg-green-100 p-4 text-green-700">
        {{ session('success') }}
      </div>
      @endif

      <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">

        <table class="min-w-full">

          <thead class="bg-gray-100 dark:bg-gray-700">

            <tr>

              <th class="px-5 py-3 text-left">
                Folder
              </th>

              <th class="px-5 py-3 text-center">
                Ukuran
              </th>

              <th class="px-5 py-3 text-center">
                Status
              </th>

              <th class="px-5 py-3">
                Path
              </th>

              <th class="px-5 py-3 text-center">
                Rekomendasi
              </th>

              <th class="px-5 py-3 text-center">
                Aksi
              </th>

            </tr>

          </thead>

          <tbody>

            @forelse($result as $item)

            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">

              <td class="px-5 py-4 font-semibold">

                {{ $item['name'] }}

              </td>

              <td class="px-5 py-4 text-center">

                <span class="px-3 py-1 rounded bg-blue-100 text-blue-700 font-semibold">

                  {{ $item['size'] }}

                </span>

              </td>

              <td class="px-5 py-4 text-center">

                @if($item['status']=='danger')

                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                  🔴 Sangat Besar

                </span>

                @elseif($item['status']=='warning')

                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                  🟡 Perlu Dicek

                </span>

                @else

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                  🟢 Normal

                </span>

                @endif

              </td>

              <td class="px-5 py-4">

                <small class="text-gray-500 break-all">

                  {{ $item['path'] }}

                </small>

              </td>

              <td class="px-5 py-4">

                @if($item['cleanable'])

                <span class="text-green-600 font-semibold">

                  Aman dibersihkan

                </span>

                @else

                <span class="text-red-600 font-semibold">

                  Jangan dihapus, cek manual

                </span>

                @endif

              </td>

              <td class="px-5 py-4 text-center">

                @if($item['action']=='clear-log')

                <form method="POST"
                  action="{{ route('maintenance.log.clear','laravel.log') }}"
                  onsubmit="return confirm('Kosongkan seluruh log?')">

                  @csrf

                  <button
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">

                    🧹 Bersihkan

                  </button>

                </form>

                @elseif($item['action']=='cache')

                <form method="POST"
                  action="{{ route('maintenance.cache') }}">

                  @csrf

                  <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded">

                    Bersihkan

                  </button>

                </form>

                @elseif($item['action']=='view')

                <form method="POST"
                  action="{{ route('maintenance.view') }}">

                  @csrf

                  <button
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded">

                    Bersihkan

                  </button>

                </form>

                @elseif($item['action']=='bootstrap')

                <form method="POST"
                  action="{{ route('maintenance.optimize') }}">

                  @csrf

                  <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded">

                    Optimize

                  </button>

                </form>

                @else

                <span class="text-gray-400">

                  -

                </span>

                @endif

              </td>

            </tr>

            @empty

            <tr>

              <td colspan="6"
                class="text-center py-8 text-gray-500">

                Tidak ada data.

              </td>

            </tr>

            @endforelse

          </tbody>

        </table>

      </div>

    </div>

  </div>

</x-app-layout>