<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen User')

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-slate-800">
          Manajemen User
        </h2>
        <p class="text-sm text-slate-500 mt-1">
          Kelola akun, role, dan akses sistem
        </p>
      </div>

      <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.users.index') }}"
          class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium transition">
          Users
        </a>

        <a href="{{ route('admin.roles.index') }}"
          class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition">
          Roles
        </a>

        <form action="{{ route('admin.bulk.siswa') }}" method="POST">
          @csrf
          <button type="submit"
            class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">
            Generate Akun Siswa
          </button>
        </form>

        <form action="{{ route('admin.bulk.guru') }}" method="POST">
          @csrf
          <button type="submit"
            class="px-4 py-2 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium transition">
            Generate Akun Guru
          </button>
        </form>
      </div>
    </div>
  </x-slot>

  <div class="min-h-screen bg-slate-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

      @if(session('success'))
      <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
      </div>
      @endif

      <div class="bg-white shadow-sm rounded-2xl border border-slate-200"
        x-data="{ tab: 'with-role' }">

        {{-- Header --}}
        <div class="border-b border-slate-200 px-6 py-5">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h3 class="text-lg font-semibold text-slate-800">
                Data User
              </h3>
              <p class="text-sm text-slate-500">
                Kelola seluruh user sistem
              </p>
            </div>

            <form action="{{ route('admin.users.index') }}"
              method="GET"
              class="flex gap-2 w-full md:w-auto">
              <input
                type="text"
                name="cari"
                value="{{ request('cari') }}"
                placeholder="Cari nama / email..."
                class="w-full md:w-72 rounded-xl border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-sm">

              <button type="submit"
                class="px-5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium transition">
                Cari
              </button>
            </form>
          </div>

          {{-- Tabs --}}
          <div class="flex flex-wrap gap-2 mt-5">
            <button
              @click="tab='with-role'"
              :class="tab === 'with-role'
                                ? 'bg-sky-600 text-white'
                                : 'bg-slate-100 text-slate-600'"
              class="px-4 py-2 rounded-xl text-sm font-medium transition">
              User Punya Role
            </button>

            <button
              @click="tab='without-role'"
              :class="tab === 'without-role'
                                ? 'bg-sky-600 text-white'
                                : 'bg-slate-100 text-slate-600'"
              class="px-4 py-2 rounded-xl text-sm font-medium transition">
              Belum Ada Role
            </button>
          </div>
        </div>

        {{-- USER PUNYA ROLE --}}
        <div x-show="tab === 'with-role'" x-cloak>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-50">
                <tr class="text-slate-600 uppercase text-xs tracking-wider">
                  <th class="px-6 py-4 text-center">No</th>
                  <th class="px-6 py-4 text-left">Username</th>
                  <th class="px-6 py-4 text-left">Email</th>
                  <th class="px-6 py-4 text-left">Identitas</th>
                  <th class="px-6 py-4 text-left">Role</th>
                  <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                @forelse($usersWithRole as $user)
                <tr class="hover:bg-slate-50 transition">
                  <td class="px-6 py-4 text-center text-slate-600">
                    {{ $usersWithRole->firstItem() + $loop->index }}
                  </td>

                  <td class="px-6 py-4 font-medium text-slate-800">
                    {{ $user->name }}
                  </td>

                  <td class="px-6 py-4 text-slate-600">
                    {{ $user->email }}
                  </td>

                  <td class="px-6 py-4 text-slate-700">
                    @if($user->siswa)
                    {{ $user->siswa->nama_siswa }}
                    @elseif($user->guru)
                    {{ $user->guru->nama_guru }}
                    @else
                    <span class="text-slate-400">Administrator</span>
                    @endif
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                      @foreach($user->roles as $role)
                      <span
                        class="px-2 py-1 text-xs rounded-lg bg-emerald-100 text-emerald-700 font-medium">
                        {{ ucfirst($role->name) }}
                      </span>
                      @endforeach
                    </div>
                  </td>

                  <td class="px-6 py-4 text-center">
                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus user {{ $user->name }} ?')">
                      @csrf
                      @method('DELETE')

                      <button type="submit"
                        class="inline-flex items-center px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-medium transition">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6"
                    class="px-6 py-8 text-center text-slate-500">
                    Tidak ada user dengan role
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="border-t border-slate-200 px-6 py-4">
            {{ $usersWithRole->withQueryString()->links() }}
          </div>
        </div>

        {{-- USER TANPA ROLE --}}
        <div x-show="tab === 'without-role'" x-cloak>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-50">
                <tr class="text-slate-600 uppercase text-xs tracking-wider">
                  <th class="px-6 py-4 text-left">Username</th>
                  <th class="px-6 py-4 text-left">Email</th>
                  <th class="px-6 py-4 text-left">Assign Role</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                @forelse($usersWithoutRole as $user)
                <tr class="hover:bg-slate-50 transition">
                  <td class="px-6 py-4 font-medium text-slate-800">
                    {{ $user->name }}
                  </td>

                  <td class="px-6 py-4 text-slate-600">
                    {{ $user->email }}
                  </td>

                  <td class="px-6 py-4">
                    <form method="POST"
                      action="{{ route('admin.users.assign-role', $user->id) }}"
                      class="flex flex-wrap gap-2">
                      @csrf

                      <select name="role_id"
                        required
                        class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                          {{ ucfirst($role->name) }}
                        </option>
                        @endforeach
                      </select>

                      <button type="submit"
                        class="px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium transition">
                        Simpan
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="3"
                    class="px-6 py-8 text-center text-slate-500">
                    Semua user sudah memiliki role
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="border-t border-slate-200 px-6 py-4">
            {{ $usersWithoutRole->withQueryString()->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>