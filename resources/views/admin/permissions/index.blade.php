<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Manajemen Permission Role
    </h2>
  </x-slot>

  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>

  <div class="py-6 px-4">
    <div class="max-w-7xl mx-auto">

      @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
        {{ session('success') }}
      </div>
      @endif

      <div
        x-data="{ activeTab: '{{ $roles->first()?->id }}' }"
        class="bg-white shadow-sm rounded-2xl overflow-hidden">
        <!-- Tabs -->
        <div class="border-b bg-gray-50 px-6">
          <div class="flex flex-wrap items-center gap-2 py-4">
            @foreach($roles as $role)
            <button
              @click="activeTab = '{{ $role->id }}'"
              :class="activeTab === '{{ $role->id }}'
                                    ? 'bg-blue-600 text-white shadow'
                                    : 'bg-white text-gray-600 border hover:bg-gray-100'"
              class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
              {{ ucfirst($role->name) }}
            </button>
            @endforeach

            <div class="ml-auto">
              <a href="{{ url('/manajemen-user') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow transition-all duration-200">
                Kembali
              </a>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="relative min-h-[500px]">
          @foreach($roles as $role)
          <div
            x-cloak
            x-show="activeTab === '{{ $role->id }}'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="p-6 absolute inset-0 overflow-y-auto">
            <div class="mb-6">
              <h3 class="text-xl font-bold text-gray-800">
                Role: {{ ucfirst($role->name) }}
              </h3>
              <p class="text-sm text-gray-500 mt-1">
                Atur permission untuk role ini.
              </p>
            </div>

            <form action="{{ route('admin.permissions.update', $role->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($permissions as $permission)
                <label class="flex items-center gap-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer transition">
                  <input
                    type="checkbox"
                    name="permissions[]"
                    value="{{ $permission->name }}"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                  <span class="text-sm text-gray-700">
                    {{ $permission->name }}
                  </span>
                </label>
                @endforeach
              </div>

              <div class="mt-6 flex justify-end">
                <button
                  type="submit"
                  class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow transition-all duration-200">
                  Simpan Permission
                </button>
              </div>
            </form>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</x-app-layout>