<x-app-layout>

  <x-slot name="header">

    <div class="flex justify-between">

      <h2 class="text-2xl font-bold">
        Maintenance Laravel
      </h2>

    </div>

  </x-slot>

  <div class="py-6">

    <div class="max-w-7xl mx-auto">

      @if(session('success'))

      <div class="mb-4 rounded bg-green-100 p-4 text-green-700">
        {{ session('success') }}
      </div>

      @endif

      <div class="grid md:grid-cols-5 gap-3 mb-6">

        <form method="POST" action="{{ route('maintenance.optimize') }}">
          @csrf
          <button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded p-3">
            Optimize Clear
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.cache') }}">
          @csrf
          <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded p-3">
            Cache Clear
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.config') }}">
          @csrf
          <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded p-3">
            Config Clear
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.route') }}">
          @csrf
          <button class="w-full bg-red-500 hover:bg-red-600 text-white rounded p-3">
            Route Clear
          </button>
        </form>

        <form method="POST" action="{{ route('maintenance.view') }}">
          @csrf
          <button class="w-full bg-green-600 hover:bg-green-700 text-white rounded p-3">
            View Clear
          </button>
        </form>

      </div>

      <div class="bg-white shadow rounded overflow-hidden">

        <table class="w-full">

          <thead class="bg-gray-100">

            <tr>

              <th class="p-3 text-left">Folder</th>

              <th class="p-3">Status</th>

              <th class="p-3">Ukuran</th>

              <th class="p-3">Jumlah File</th>

              <th class="p-3">Path</th>

            </tr>

          </thead>

          <tbody>

            @foreach($data as $item)

            <tr class="border-t">

              <td class="p-3 font-semibold">

                {{ $item['name'] }}

              </td>

              <td class="text-center">

                @if($item['exists'])

                <span class="text-green-600">
                  ✔ Ada
                </span>

                @else

                <span class="text-red-600">
                  ✘ Tidak Ada
                </span>

                @endif

              </td>

              <td class="text-center">

                {{ $item['size'] }}

              </td>

              <td class="text-center">

                {{ $item['files'] }}

              </td>

              <td class="text-xs text-gray-500">

                {{ $item['path'] }}

              </td>

            </tr>

            @endforeach

          </tbody>

        </table>

      </div>

    </div>

  </div>

</x-app-layout>