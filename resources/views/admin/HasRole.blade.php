<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen Has Role')
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
      Dashboard Has Role User
    </h2>
  </x-slot>

  <div class="p-4 space-y-4">

    {{-- NAVIGATION --}}
    <div class="bg-white shadow rounded-xl p-4 flex flex-wrap gap-2">
      <a href="/manajemen-user"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
        List Users
      </a>
      <a href="/manajemen"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
        Manajemen Role
      </a>
    </div>

    {{-- FORM SECTION --}}
    <div class="grid md:grid-cols-2 gap-4">

      {{-- CREATE ROLE --}}
      <div class="bg-white shadow rounded-xl p-5">
        <h3 class="font-semibold text-lg mb-3 text-gray-700">Create Role</h3>

        <form action="/HasRole" method="post" class="space-y-3">
          @csrf

          <div>
            <label class="text-sm text-gray-600">Role Name</label>
            <input type="text" name="name"
              class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
              placeholder="Contoh: super admin">
            @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="text-sm text-gray-600">Guard</label>
            <input type="text" name="guard_name"
              value="web"
              readonly
              class="w-full bg-gray-100 border rounded-lg px-3 py-2">
          </div>

          <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Simpan Role
          </button>

          {{-- NOTIF --}}
          @if(Session::has('message'))
          <div id="notification"
            class="mt-3 bg-green-100 text-green-700 px-3 py-2 rounded-lg text-sm">
            {{ Session::get('message') }}
          </div>
          @endif
        </form>
      </div>

      {{-- ASSIGN ROLE --}}
      <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-slate-800">
            Assign Role ke User
          </h3>
          <p class="text-sm text-slate-500 mt-1">
            Pilih role dan user yang akan diberikan akses sistem.
          </p>
        </div>

        <form action="{{ route('has-role.assign') }}" method="POST" class="space-y-5">
          @csrf

          {{-- ROLE --}}
          <div>
            <label for="role_id" class="block text-sm font-medium text-slate-700 mb-2">
              Pilih Role
            </label>

            <select
              id="role_id"
              name="role_id"
              class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
              required>
              <option value="">-- Pilih Role --</option>
              @foreach ($roles as $role)
              <option value="{{ $role->id }}"
                {{ old('role_id') == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
              </option>
              @endforeach
            </select>

            @error('role_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- USER --}}
          <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
          <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
          <div>
            <label for="model_id" class="block text-sm font-medium text-slate-700 mb-2">
              Pilih User
            </label>

            <select
              id="model_id"
              name="model_id"
              class="w-full rounded-xl border-slate-300 shadow-sm"
              required>
              <option value="">-- Pilih User --</option>
              @foreach ($User as $user)
              <option value="{{ $user->id }}"
                {{ old('model_id') == $user->id ? 'selected' : '' }}>
                {{ ucwords(strtolower($user->name)) }}
              </option>
              @endforeach
            </select>

            @error('model_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <script>
            new TomSelect('#model_id', {
              create: false,
              sortField: {
                field: "text",
                direction: "asc"
              },
              placeholder: "Cari user..."
            });
          </script>

          <input type="hidden" name="model_type" value="App\Models\User">

          {{-- BUTTON --}}
          <div class="pt-2">
            <button type="submit"
              class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition duration-200 shadow-sm">
              Assign Role
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl p-5">
      <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-lg text-gray-700">Data Role User</h3>

        <form action="/HasRole" method="get" class="flex gap-2">
          <input type="text" name="cari"
            value="{{ request('cari') }}"
            class="border rounded-lg px-3 py-1 text-sm"
            placeholder="Cari user...">
          <button class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm">
            Cari
          </button>
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm border rounded-lg overflow-hidden">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="py-2 px-3 text-left">No</th>
              <th class="py-2 px-3 text-left">Email</th>
              <th class="py-2 px-3 text-left">Role</th>
              <th class="py-2 px-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($hasRole as $index => $Hasrole)
            <tr class="border-t hover:bg-gray-50">
              <td class="px-3 py-2">{{ $index + 1 }}</td>
              <td class="px-3 py-2">{{ $Hasrole->user_name }}</td>
              <td class="px-3 py-2">{{ $Hasrole->email }}</td>
              <td class="px-3 py-2">
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                  {{ $Hasrole->role_name }}
                </span>
              </td>
              <td class="px-3 py-2 text-center">
                <form action="/has-role/{{$Hasrole->model_id}}" method="post">
                  @csrf
                  @method('delete')
                  <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center py-4 text-gray-500">
                Data tidak ditemukan
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  {{-- AUTO HIDE NOTIF --}}
  <script>
    setTimeout(() => {
      const notif = document.getElementById('notification');
      if (notif) notif.remove();
    }, 4000);
  </script>
</x-app-layout>