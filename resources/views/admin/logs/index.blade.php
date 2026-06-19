<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Log Aktivitas
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                    Waktu
                  </th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                    User
                  </th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                    Aktivitas
                  </th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                    Model
                  </th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-3">
                    {{ $log->created_at?->format('d/m/Y H:i:s') }}
                  </td>

                  <td class="px-4 py-3">
                    {{ $log->causer?->name ?? 'System' }}
                  </td>

                  <td class="px-4 py-3">
                    {{ $log->description }}
                  </td>

                  <td class="px-4 py-3">
                    {{ class_basename($log->subject_type) }}
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-6 text-gray-500">
                    Belum ada aktivitas
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            {{ $logs->links() }}
          </div>

        </div>
      </div>

    </div>
  </div>
</x-app-layout>