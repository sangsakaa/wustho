<x-app-layout>

  <x-slot name="header">
    <h2 class="text-xl font-bold">
      Detail {{ ucfirst($folder) }}
    </h2>
  </x-slot>

  <div class="p-6">

    <table class="w-full border">

      <thead class="bg-gray-100">

        <tr>

          <th class="p-2 text-left">Nama File</th>
          <th class="p-2">Ukuran</th>
          <th class="p-2">Terakhir Diubah</th>
          <th class="p-2">Aksi</th>

        </tr>

      </thead>

      <tbody>

        @foreach($files as $file)

        <tr class="border-t">

          <td class="p-2">{{ $file['name'] }}</td>

          <td class="text-center">
            {{ $file['size'] }}
          </td>

          <td class="text-center">
            {{ $file['modified'] }}
          </td>
          <td class="px-4 py-3">
            <div class="flex gap-2">

              <a href="{{ route('maintenance.log.view', $file['name']) }}"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                👁 Lihat
              </a>

              <a href="{{ route('maintenance.log.download', $file['name']) }}"
                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                ⬇ Download
              </a>

              <form action="{{ route('maintenance.log.clear', $file['name']) }}"
                method="POST"
                onsubmit="return confirm('Kosongkan isi log ini?')">
                @csrf

                <button
                  class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                  🧹 Kosongkan
                </button>
              </form>

            </div>
          </td>

        </tr>

        @endforeach

      </tbody>

    </table>

  </div>

</x-app-layout>