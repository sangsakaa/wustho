<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

      <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
          Monitor Absensi
        </h2>

        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
          {{ $sesi->kelasmi->nama_kelas ?? '-' }}
          •
          {{ \Carbon\Carbon::parse($sesi->tgl)->isoFormat('dddd, D MMMM Y') }}
        </p>
      </div>

      <div class="flex items-center gap-2">

        <span class="px-4 py-2 rounded-2xl text-sm font-semibold
                    {{ $sesi->status == 'open'
                        ? 'bg-emerald-100 text-emerald-700'
                        : 'bg-red-100 text-red-700' }}">

          {{ $sesi->status == 'open' ? 'Sesi Dibuka' : 'Sesi Ditutup' }}

        </span>

        <a href="{{ url('/sesikelas') }}"
          class="px-4 py-2 rounded-2xl bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium transition shadow-sm">
          ← Kembali
        </a>

      </div>

    </div>
  </x-slot>

  @php
  $total = $data->count();

  $hadir = $data->where('status', 'hadir')->count();
  $izin = $data->where('status', 'izin')->count();
  $sakit = $data->where('status', 'sakit')->count();
  $alfa = $data->where('status', 'alfa')->count();
  $belum = $data->where('status', 'belum')->count();
  @endphp

  <div class="min-h-screen bg-slate-100 dark:bg-slate-900 p-4 md:p-6 space-y-6">

    {{-- SUMMARY --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5">

      {{-- TOTAL --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Total Siswa
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
              {{ $total }}
            </h3>
          </div>

          <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-2xl">
            👥
          </div>

        </div>
      </div>

      {{-- HADIR --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Hadir
            </p>

            <h3 class="mt-2 text-3xl font-bold text-emerald-600">
              {{ $hadir }}
            </h3>
          </div>

          <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
            ✅
          </div>

        </div>
      </div>

      {{-- IZIN --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Izin
            </p>

            <h3 class="mt-2 text-3xl font-bold text-yellow-500">
              {{ $izin }}
            </h3>
          </div>

          <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
            📄
          </div>

        </div>
      </div>

      {{-- SAKIT --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Sakit
            </p>

            <h3 class="mt-2 text-3xl font-bold text-blue-500">
              {{ $sakit }}
            </h3>
          </div>

          <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
            🤒
          </div>

        </div>
      </div>

      {{-- BELUM --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Belum Absen
            </p>

            <h3 class="mt-2 text-3xl font-bold text-red-500">
              {{ $belum }}
            </h3>
          </div>

          <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
            ⏳
          </div>

        </div>
      </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">

      {{-- HEADER TABLE --}}
      <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

          <div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
              Data Peserta Kelas
            </h3>

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Monitoring presensi siswa realtime
            </p>
          </div>

          <div class="text-sm text-slate-500 dark:text-slate-400">
            Total {{ $total }} siswa
          </div>

        </div>

      </div>

      {{-- TABLE --}}
      <div class="overflow-x-auto">

        <table class="w-full text-sm">

          <thead class="bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200">
            <tr>
              <th class="px-4 py-3 text-center w-16">No</th>
              <th class="px-4 py-3 text-left">Nama Siswa</th>
              <th class="px-4 py-3 text-left">NIS</th>
              <th class="px-4 py-3 text-center">Status</th>
              <th class="px-4 py-3 text-center">Aksi Presensi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-slate-100 dark:divide-slate-700">

            @forelse ($data as $row)

            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">

              {{-- NO --}}
              <td class="px-4 py-4 text-center text-slate-500">
                {{ $loop->iteration }}
              </td>

              {{-- NAMA --}}
              <td class="px-4 py-4">

                <div class="flex items-center gap-3">

                  <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                    {{ strtoupper(substr($row['nama'], 0, 1)) }}
                  </div>

                  <div>
                    <div class="font-semibold text-slate-800 dark:text-white">
                      {{ $row['nama'] }}
                    </div>

                    <div class="text-xs text-slate-400">
                      Peserta Kelas
                    </div>
                  </div>

                </div>

              </td>

              {{-- NIS --}}
              <td class="px-4 py-4 text-slate-600 dark:text-slate-300">
                {{ $row['nis'] }}
              </td>

              {{-- STATUS --}}
              <td class="px-4 py-4 text-center">

                @if($row['status'] == 'hadir')

                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                  Hadir
                </span>

                @elseif($row['status'] == 'izin')

                <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                  Izin
                </span>

                @elseif($row['status'] == 'sakit')

                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                  Sakit
                </span>

                @elseif($row['status'] == 'alfa')

                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                  Alfa
                </span>

                @else

                <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-semibold">
                  Belum Absen
                </span>

                @endif

              </td>

              {{-- AKSI --}}
              <td class="px-4 py-4">

                <form action="{{ route('absen.manual') }}"
                  method="POST"
                  class="flex flex-wrap justify-center gap-2">

                  @csrf

                  <input type="hidden"
                    name="pesertakelas_id"
                    value="{{ $row['peserta_id'] }}">

                  <input type="hidden"
                    name="sesikelas_id"
                    value="{{ $sesi->id }}">

                  <button type="submit"
                    name="status"
                    value="hadir"
                    class="px-3 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold transition shadow-sm">
                    Hadir
                  </button>

                  <button type="submit"
                    name="status"
                    value="izin"
                    class="px-3 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold transition shadow-sm">
                    Izin
                  </button>

                  <button type="submit"
                    name="status"
                    value="sakit"
                    class="px-3 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold transition shadow-sm">
                    Sakit
                  </button>

                  <button type="submit"
                    name="status"
                    value="alfa"
                    class="px-3 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-xs font-semibold transition shadow-sm">
                    Alfa
                  </button>

                </form>

              </td>

            </tr>

            @empty

            <tr>

              <td colspan="5" class="py-16 text-center">

                <div class="flex flex-col items-center justify-center">

                  <div class="text-5xl mb-4">
                    📚
                  </div>

                  <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-200">
                    Data Peserta Tidak Ditemukan
                  </h3>

                  <p class="text-sm text-slate-500 mt-1">
                    Belum ada siswa pada kelas ini
                  </p>

                </div>

              </td>

            </tr>

            @endforelse

          </tbody>

        </table>

      </div>

    </div>

  </div>
</x-app-layout>