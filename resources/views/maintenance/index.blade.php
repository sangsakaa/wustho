<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
          🛠 Maintenance Laravel
        </h2>
        <p class="text-sm text-gray-500">
          Monitoring Storage & Maintenance Server
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-6">

    <div class="max-w-7xl mx-auto px-4">

      @if(session('success'))
      <div
        class="mb-5 rounded-lg border border-green-300 bg-green-100 p-4 text-green-700 shadow">
        {{ session('success') }}
      </div>
      @endif

      {{-- MENU --}}
      <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">

        <form method="POST" action="{{ route('maintenance.optimize') }}">
          @csrf
          <button
            class="w-full rounded-lg bg-blue-600 py-3 font-semibold text-white hover:bg-blue-700 transition">
            ⚡ Optimize
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.cache') }}">
          @csrf
          <button
            class="w-full rounded-lg bg-indigo-600 py-3 font-semibold text-white hover:bg-indigo-700 transition">
            🗑 Cache
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.config') }}">
          @csrf
          <button
            class="w-full rounded-lg bg-yellow-500 py-3 font-semibold text-white hover:bg-yellow-600 transition">
            ⚙ Config
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.route') }}">
          @csrf
          <button
            class="w-full rounded-lg bg-red-500 py-3 font-semibold text-white hover:bg-red-600 transition">
            🛣 Route
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.view') }}">
          @csrf
          <button
            class="w-full rounded-lg bg-green-600 py-3 font-semibold text-white hover:bg-green-700 transition">
            👁 View
          </button>
        </form>

      </div>

      {{-- TABLE --}}
      <div class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow">

        <table class="min-w-full">

          <thead class="bg-gray-100 dark:bg-gray-700">

            <tr>

              <th class="px-6 py-3 text-left">Folder</th>

              <th class="px-6 py-3 text-center">Status</th>

              <th class="px-6 py-3 text-center">Ukuran</th>

              <th class="px-6 py-3">Path</th>

              <th class="px-6 py-3 text-center">
                Aksi
              </th>

            </tr>

          </thead>

          <tbody>

            @foreach($data as $item)

            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">

              <td class="px-6 py-4 font-semibold">

                {{ $item['name'] }}

              </td>

              <td class="text-center">

                @if($item['exists'])

                <span
                  class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">

                  ✔ Ada

                </span>

                @else

                <span
                  class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">

                  ✘ Tidak Ada

                </span>

                @endif

              </td>

              <td class="text-center">

                <span
                  class="rounded bg-blue-100 px-3 py-1 text-blue-700 font-semibold">

                  {{ $item['size'] }}

                </span>

              </td>

              <td>

                <small class="text-gray-500">

                  {{ $item['path'] }}

                </small>

              </td>

              <td class="px-6 py-4 text-center">

                @php
                $route = null;

                switch($item['name']){

                case 'Logs':
                $route='logs';
                break;

                case 'Framework Cache':
                $route='cache';
                break;

                case 'Framework Views':
                $route='views';
                break;

                case 'Framework Sessions':
                $route='sessions';
                break;

                case 'Bootstrap Cache':
                $route='bootstrap';
                break;
                }
                @endphp

                <div class="flex justify-center gap-2 flex-wrap">

                  @if($route)

                  <a href="{{ route('maintenance.detail',$route) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">
                    📄 Detail
                  </a>

                  @endif

                  @if($item['name']=='Logs')

                  <a href="{{ route('maintenance.log.view','laravel.log') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm">
                    👁 Lihat Log
                  </a>

                  <a href="{{ route('maintenance.log.download','laravel.log') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm">
                    ⬇ Download
                  </a>

                  <form method="POST"
                    action="{{ route('maintenance.log.clear','laravel.log') }}"
                    onsubmit="return confirm('Kosongkan isi laravel.log?');">
                    @csrf
                    <button
                      class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">
                      🧹 Kosongkan
                    </button>
                  </form>

                  @endif

                </div>

              </td>

            </tr>

            @endforeach

          </tbody>

        </table>

      </div>

    </div>

  </div>

</x-app-layout>