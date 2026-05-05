<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
          Manajemen Role User
        </h2>
        <p class="text-sm text-slate-500 mt-1">
          Assign role user menggunakan Spatie Permission
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-6 bg-slate-100 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

      @if(session('success'))
      <div class="mb-4 rounded-xl bg-green-100 border border-green-200 px-4 py-3 text-green-700">
        {{ session('success') }}
      </div>
      @endif

      <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-6">
          Assign Role ke User
        </h3>

        <form action="{{ route('roles.assign') }}" method="POST">
          @csrf

          {{-- USER --}}
          <div>
            <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">
              Pilih User
            </label>

            <select
              id="user_id"
              name="user_id"
              class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
              <option value="">-- Pilih User --</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}"
                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ ucwords(strtolower($user->name)) }}
              </option>
              @endforeach
            </select>

            @error('user_id')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          {{-- ROLE --}}
          <div>
            <label for="role_name" class="block text-sm font-medium text-slate-700 mb-2">
              Pilih Role
            </label>

            <select
              id="role_name"
              name="role_name"
              class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
              <option value="">-- Pilih Role --</option>
              @foreach($roles as $role)
              <option value="{{ $role->name }}"
                {{ old('role_name') == $role->name ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
              </option>
              @endforeach
            </select>

            @error('role_name')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-2">
            <button
              type="submit"
              class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition">
              Simpan Role
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Tom Select --}}
  @push('styles')
  <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
  @endpush

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
  <script>
    new TomSelect('#user_id', {
      create: false,
      placeholder: 'Cari user...',
      sortField: {
        field: 'text',
        direction: 'asc'
      }
    });
  </script>
  @endpush
</x-app-layout>