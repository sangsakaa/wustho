<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen User')
    <h2 class="font-semibold text-xl text-gray-800">
      Dashboard Manajemen User
    </h2>
  </x-slot>

  <div class="p-4 space-y-4 bg-gray-100 min-h-screen">

    {{-- MENU --}}
    <div class="bg-white shadow rounded-xl p-4">
      <div class="flex flex-wrap gap-2">
        <a href="/manajemen" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm">
          Manajemen User Guru
        </a>
        <a href="/HasRole" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm">
          Has Role
        </a>
        <a href="/buatakunsiswa" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
          Akun Siswa
        </a>
        <a href="/buatakunguru" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm">
          Akun Guru
        </a>
      </div>

      @if ($pesan = Session::get('status'))
      <div class="mt-3 text-green-600 text-sm">
        {{ $pesan }}
      </div>
      @endif
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl p-4">

      {{-- HEADER --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
        <h3 class="font-semibold text-lg">User Role</h3>

        <form action="/manajemen-user" method="get" class="flex gap-2 w-full md:w-auto">
          <input
            type="text"
            name="cari"
            value="{{ request('cari') }}"
            class="border rounded-lg px-3 py-2 text-sm w-full md:w-64 focus:ring focus:ring-blue-200"
            placeholder="Cari user...">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            Cari
          </button>
        </form>
      </div>

      {{-- TABLE RESPONSIVE --}}
      <div class="overflow-x-auto">
        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
          <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
              <th class="px-3 border">No</th>
              <th class="px-3 border">Username</th>
              <th class="px-3 border">Email</th>
              <th class="px-3 border">Nama</th>
              <th class="px-3 border text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
              <td class="px-3 border text-center">
                {{ $loop->iteration }}
              </td>

              <td class="px-3 border uppercase">
                {{ strtolower($user->name) }}
              </td>

              <td class="px-3 border text-center">
                {{ $user->email }}
              </td>

              <td class="px-3 border capitalize">
                {{ strtolower($user->nama_siswa) }}
              </td>

              <td class="px-3 border text-center">
                <form action="/admin/{{ $user->id }}" method="post"
                  onsubmit="return confirm('Yakin hapus {{ $user->nama_siswa }} ?')">
                  @csrf
                  @method('delete')

                  <button
                    type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-gray-500">
                Data tidak ditemukan
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- PAGINATION --}}
      <div class="mt-4">
        {{ $users->links() }}
      </div>

    </div>
  </div>
</x-app-layout>