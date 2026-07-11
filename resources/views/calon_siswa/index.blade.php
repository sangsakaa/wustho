<x-app-layout>

  {{-- ================= HEADER ================= --}}
  <x-slot name="header">
    <div class="flex flex-col gap-1">
      <h1 class="text-3xl font-bold text-slate-900">
        📚 Dashboard Calon Siswa
      </h1>

      <p class="text-sm text-slate-500">
        Monitoring Data Calon Siswa • Sinkronisasi • Mutasi Menjadi Siswa
      </p>
    </div>
  </x-slot>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @php

  $total = max(($stats['all'] ?? 0),1);

  $persenCalon = round((($stats['calon'] ?? 0) / $total) *100);

  $persenDipindah = round((($stats['dipindah'] ?? 0) / $total) *100);

  $totalRencana = ($stats['mondok'] ??0)+($stats['tidak_mondok'] ??0);

  $mondokPercent = $totalRencana
  ? round(($stats['mondok']/$totalRencana)*100)
  :0;

  $tidakPercent = $totalRencana
  ? round(($stats['tidak_mondok']/$totalRencana)*100)
  :0;

  @endphp

  <div class="max-w-7xl mx-auto px-6 py-6 space-y-6">

    {{-- ================= TOP BAR ================= --}}
    <div class="bg-white rounded-2xl shadow p-6">

      <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">

        <div>

          <h2 class="text-xl font-bold text-slate-800">
            Dashboard Monitoring
          </h2>

          <p class="text-sm text-slate-500">
            Statistik realtime Calon Siswa dari API
          </p>

        </div>

        <div class="flex flex-wrap gap-2">

          <a
            href="{{ route('debug.sync') }}"
            target="_blank"
            class="px-4 py-2 rounded-xl bg-amber-500 text-white font-semibold hover:bg-amber-600">

            🐞 Debug API

          </a>

          <button
            onclick="syncData()"
            class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">

            🔄 Sync Data

          </button>

        </div>

      </div>

    </div>

    {{-- ================= CARD STATISTIK ================= --}}

    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">

      <div class="bg-white rounded-xl shadow p-5">
        <div class="text-xs text-slate-500">
          TOTAL
        </div>

        <div class="text-3xl font-bold text-slate-800">
          {{ number_format($stats['all']) }}
        </div>
      </div>

      <div class="bg-yellow-50 rounded-xl shadow p-5">

        <div class="text-xs text-yellow-700">
          CALON SISWA
        </div>

        <div class="text-3xl font-bold text-yellow-600">
          {{ $stats['calon'] }}
        </div>

      </div>

      <div class="bg-green-50 rounded-xl shadow p-5">

        <div class="text-xs text-green-700">
          SUDAH DIPINDAH
        </div>

        <div class="text-3xl font-bold text-green-600">
          {{ $stats['dipindah'] }}
        </div>

      </div>

      <div class="bg-blue-50 rounded-xl shadow p-5">

        <div class="text-xs text-blue-700">
          SMP
        </div>

        <div class="text-3xl font-bold text-blue-600">
          {{ $stats['SMP'] }}
        </div>

      </div>

      <div class="bg-purple-50 rounded-xl shadow p-5">

        <div class="text-xs text-purple-700">
          SMA
        </div>

        <div class="text-3xl font-bold text-purple-600">
          {{ $stats['SMA'] }}
        </div>

      </div>

      <div class="bg-red-50 rounded-xl shadow p-5">

        <div class="text-xs text-red-700">
          MONDOK
        </div>

        <div class="text-3xl font-bold text-red-600">
          {{ $stats['mondok'] }}
        </div>

      </div>

    </div>

    {{-- ================= PROGRESS ================= --}}

    <div class="bg-white rounded-2xl shadow p-6">

      <div class="flex justify-between mb-2">

        <span class="font-semibold text-yellow-600">

          Calon
          {{ $persenCalon }}%

        </span>

        <span class="font-semibold text-green-600">

          Dipindah
          {{ $persenDipindah }}%

        </span>

      </div>

      <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden flex">

        <div
          class="bg-yellow-500"
          style="width:{{ $persenCalon }}%">
        </div>

        <div
          class="bg-green-600"
          style="width:{{ $persenDipindah }}%">
        </div>

      </div>

    </div>
    {{-- ================= FILTER ================= --}}
    <div class="bg-white rounded-2xl shadow p-4">

      <div class="flex flex-wrap gap-2">

        {{-- ================= JENJANG ================= --}}

        <a href="{{ request()->fullUrlWithQuery(['jenjang'=>null]) }}"
          class="px-4 py-2 rounded-xl border transition
            {{ request('jenjang')==null
                ?'bg-blue-600 text-white'
                :'bg-white hover:bg-slate-50' }}">
          Semua
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenjang'=>'SMP']) }}"
          class="px-4 py-2 rounded-xl border transition
            {{ request('jenjang')=='SMP'
                ?'bg-blue-600 text-white'
                :'bg-white hover:bg-slate-50' }}">
          SMP
          <span class="ml-2 font-bold">
            {{ $stats['SMP'] }}
          </span>
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenjang'=>'SMA']) }}"
          class="px-4 py-2 rounded-xl border transition
            {{ request('jenjang')=='SMA'
                ?'bg-blue-600 text-white'
                :'bg-white hover:bg-slate-50' }}">
          SMA
          <span class="ml-2 font-bold">
            {{ $stats['SMA'] }}
          </span>
        </a>

        <div class="border-l mx-2"></div>

        {{-- ================= STATUS ================= --}}

        <a href="{{ request()->fullUrlWithQuery(['status'=>null]) }}"
          class="px-4 py-2 rounded-xl border
            {{ request('status')==null
                ?'bg-emerald-600 text-white'
                :'bg-white' }}">
          Semua Status
        </a>

        <a href="{{ request()->fullUrlWithQuery(['status'=>'calon-siswa']) }}"
          class="px-4 py-2 rounded-xl border
            {{ request('status')=='calon-siswa'
                ?'bg-yellow-500 text-white'
                :'bg-white' }}">
          Calon
          ({{ $stats['calon'] }})
        </a>

        <a href="{{ request()->fullUrlWithQuery(['status'=>'dipindah_ke_siswa']) }}"
          class="px-4 py-2 rounded-xl border
            {{ request('status')=='dipindah_ke_siswa'
                ?'bg-green-600 text-white'
                :'bg-white' }}">
          Dipindah
          ({{ $stats['dipindah'] }})
        </a>

        <div class="border-l mx-2"></div>

        {{-- ================= RENCANA ================= --}}

        <a href="{{ request()->fullUrlWithQuery(['rencana_pendidikan'=>null]) }}"
          class="px-4 py-2 rounded-xl border
            {{ request('rencana_pendidikan')==null
                ?'bg-purple-600 text-white'
                :'bg-white' }}">
          Semua
        </a>

        <a href="{{ request()->fullUrlWithQuery(['rencana_pendidikan'=>'Mondok']) }}"
          class="px-4 py-2 rounded-xl border
            {{ request('rencana_pendidikan')=='Mondok'
                ?'bg-red-600 text-white'
                :'bg-white' }}">
          Mondok
          ({{ $stats['mondok'] }})
        </a>

        <a href="{{ request()->fullUrlWithQuery(['rencana_pendidikan'=>'Tidak Mondok']) }}"
          class="px-4 py-2 rounded-xl border
            {{ request('rencana_pendidikan')=='Tidak Mondok'
                ?'bg-sky-600 text-white'
                :'bg-white' }}">
          Tidak Mondok
          ({{ $stats['tidak_mondok'] }})
        </a>

      </div>

    </div>

    {{-- ================= STATISTIK SMP & SMA ================= --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      {{-- SMP --}}
      <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="font-bold text-blue-700 text-lg mb-4">
          📘 Statistik SMP
        </h3>

        <div class="grid grid-cols-2 gap-4">

          <div class="rounded-xl bg-blue-50 p-4">
            <div class="text-xs text-slate-500">Total</div>
            <div class="text-2xl font-bold">
              {{ $stats['SMP'] }}
            </div>
          </div>

          <div class="rounded-xl bg-yellow-50 p-4">
            <div class="text-xs text-slate-500">Calon</div>
            <div class="text-2xl font-bold text-yellow-600">
              {{ $stats['smp_calon'] }}
            </div>
          </div>

          <div class="rounded-xl bg-green-50 p-4">
            <div class="text-xs text-slate-500">Dipindah</div>
            <div class="text-2xl font-bold text-green-600">
              {{ $stats['smp_dipindah'] }}
            </div>
          </div>

          <div class="rounded-xl bg-red-50 p-4">
            <div class="text-xs text-slate-500">Mondok</div>
            <div class="text-2xl font-bold text-red-600">
              {{ $stats['smp_mondok'] }}
            </div>
          </div>

        </div>

      </div>

      {{-- SMA --}}
      <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="font-bold text-purple-700 text-lg mb-4">
          📙 Statistik SMA
        </h3>

        <div class="grid grid-cols-2 gap-4">

          <div class="rounded-xl bg-purple-50 p-4">
            <div class="text-xs text-slate-500">Total</div>
            <div class="text-2xl font-bold">
              {{ $stats['SMA'] }}
            </div>
          </div>

          <div class="rounded-xl bg-yellow-50 p-4">
            <div class="text-xs text-slate-500">Calon</div>
            <div class="text-2xl font-bold text-yellow-600">
              {{ $stats['sma_calon'] }}
            </div>
          </div>

          <div class="rounded-xl bg-green-50 p-4">
            <div class="text-xs text-slate-500">Dipindah</div>
            <div class="text-2xl font-bold text-green-600">
              {{ $stats['sma_dipindah'] }}
            </div>
          </div>

          <div class="rounded-xl bg-red-50 p-4">
            <div class="text-xs text-slate-500">Mondok</div>
            <div class="text-2xl font-bold text-red-600">
              {{ $stats['sma_mondok'] }}
            </div>
          </div>

        </div>

      </div>

    </div>

    {{-- ================= PROGRESS MONDOK ================= --}}

    <div class="bg-white rounded-2xl shadow p-6">

      <div class="flex justify-between mb-2">

        <span class="text-red-600 font-semibold">
          Mondok ({{ $stats['mondok'] }})
        </span>

        <span class="text-blue-600 font-semibold">
          Tidak Mondok ({{ $stats['tidak_mondok'] }})
        </span>

      </div>

      <div class="w-full h-4 bg-slate-200 rounded-full overflow-hidden flex">

        <div
          class="bg-red-500"
          style="width:{{ $mondokPercent }}%">
        </div>

        <div
          class="bg-blue-500"
          style="width:{{ $tidakPercent }}%">
        </div>

      </div>

    </div>

    {{-- ================= GRAFIK ================= --}}



    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden hidden lg:block">

      <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

          <thead class="bg-slate-100 text-slate-600 uppercase text-xs">

            <tr>

              <th class="px-4 py-3 text-center w-16">No</th>

              <th class="px-4 py-3 text-left">
                Nama Siswa
              </th>

              <th class="px-4 py-3 text-center">
                Jenjang
              </th>

              <th class="px-4 py-3 text-center">
                Rencana
              </th>

              <th class="px-4 py-3">
                Asal Daerah
              </th>

              <th class="px-4 py-3 text-center">
                Status
              </th>

              <th class="px-4 py-3 text-center">
                Aksi
              </th>

            </tr>

          </thead>

          <tbody class="divide-y divide-slate-200">

            @forelse($data as $row)

            @php

            $rencana = data_get($row->data_api,'rencana_pendidikan','-');

            @endphp

            <tr class="hover:bg-slate-50 transition">

              <td class="px-4 py-4 text-center font-semibold">

                {{ $loop->iteration + ($data->firstItem()-1) }}

              </td>

              <td class="px-4 py-4">

                <div class="font-bold text-slate-800">

                  {{ $row->nama }}

                </div>

                <div class="text-xs text-slate-500 mt-1">

                  NISN :
                  {{ $row->nisn ?: '-' }}

                  <br>

                  NIK :
                  {{ $row->nik ?: '-' }}

                  <br>

                  {{ $row->tempat_lahir }}

                  @if($row->tanggal_lahir)

                  ,

                  {{ \Carbon\Carbon::parse($row->tanggal_lahir)->translatedFormat('d F Y') }}

                  @endif

                </div>

              </td>

              <td class="px-4 py-4 text-center">

                @if($row->jenjang=='SMP')

                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">

                  SMP

                </span>

                @elseif($row->jenjang=='SMA')

                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-semibold">

                  SMA

                </span>

                @else

                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs">

                  {{ $row->jenjang }}

                </span>

                @endif

              </td>

              <td class="px-4 py-4 text-center">

                @if($rencana=="Mondok")

                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                  🏠 Mondok

                </span>

                @else

                <span class="px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-semibold">

                  🏡 Tidak Mondok

                </span>

                @endif

              </td>

              <td class="px-4 py-4">

                <div class="text-sm">

                  <div class="font-semibold">

                    {{ $row->provinsi ?? '-' }}

                  </div>

                  <div class="text-xs text-slate-500">

                    {{ $row->kabupaten ?? '-' }}

                  </div>

                </div>

              </td>

              <td class="px-4 py-4 text-center">

                @if($row->status=="calon-siswa")

                <span
                  id="status-{{ $row->id }}"
                  class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                  Calon Siswa

                </span>

                @else

                <span
                  id="status-{{ $row->id }}"
                  class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                  Sudah Dipindah

                </span>

                @endif

              </td>

              <td class="px-4 py-4">

                <div class="flex justify-center gap-2">

                  @if($row->status=="calon-siswa")

                  <button
                    onclick="kirim({{ $row->id }})"
                    class="px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold">

                    Jadikan Siswa

                  </button>

                  @endif

                  @if($row->status=="dipindah_ke_siswa")

                  <button
                    onclick="resetData({{ $row->id }})"
                    class="px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold">

                    Reset

                  </button>

                  @endif

                </div>

              </td>

            </tr>

            @empty

            <tr>

              <td colspan="7" class="py-10 text-center text-slate-400">

                Tidak ada data calon siswa.

              </td>

            </tr>

            @endforelse

          </tbody>

        </table>

      </div>

      @if($data->hasPages())

      <div class="border-t p-4">

        {{ $data->links() }}

      </div>

      @endif

    </div>
    {{-- ================= MOBILE CARD ================= --}}
    <div class="lg:hidden space-y-4">

      @forelse($data as $no => $row)

      @php
      $rencana = data_get($row->data_api,'rencana_pendidikan','-');
      @endphp

      <div class="bg-white rounded-2xl shadow p-4">

        {{-- Header --}}
        <div class="flex justify-between items-start">

          <div>

            <h3 class="font-bold text-slate-800">
              {{ $row->nama }}
            </h3>

            <p class="text-xs text-slate-500 mt-1">
              {{ $row->tempat_lahir }}
              @if($row->tanggal_lahir)
              •
              {{ \Carbon\Carbon::parse($row->tanggal_lahir)->translatedFormat('d F Y') }}
              @endif
            </p>

          </div>

          <span
            id="status-mobile-{{ $row->id }}"
            class="px-3 py-1 rounded-full text-xs
                    {{ $row->status=='dipindah_ke_siswa'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-yellow-100 text-yellow-700'
                    }}">
            {{ $row->status }}
          </span>

        </div>

        {{-- Informasi --}}
        <div class="grid grid-cols-2 gap-3 mt-4 text-sm">

          <div>
            <div class="text-slate-400">
              Jenjang
            </div>

            <div class="font-semibold">
              {{ $row->jenjang }}
            </div>
          </div>

          <div>
            <div class="text-slate-400">
              Rencana
            </div>

            <div>
              @if($rencana=="Mondok")

              <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs">
                Mondok
              </span>

              @else

              <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                Tidak Mondok
              </span>

              @endif
            </div>
          </div>

          <div class="col-span-2">

            <div class="text-slate-400">
              Provinsi
            </div>

            <div class="font-medium">
              {{ $row->provinsi ?? '-' }}
            </div>

          </div>

          <div class="col-span-2">

            <div class="text-slate-400">
              Kabupaten
            </div>

            <div class="font-medium">
              {{ $row->kabupaten ?? '-' }}
            </div>

          </div>

        </div>

        {{-- Tombol --}}
        <div class="flex gap-2 mt-5">

          @if($row->status=='calon-siswa')

          <button
            onclick="kirim({{ $row->id }})"
            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2 text-sm font-semibold">

            Jadikan Siswa

          </button>

          @endif

          @if($row->status=='dipindah_ke_siswa')

          <button
            onclick="resetData({{ $row->id }})"
            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl py-2 text-sm font-semibold">

            Reset

          </button>

          @endif

        </div>

      </div>

      @empty

      <div class="bg-white rounded-xl shadow p-8 text-center text-slate-400">
        Tidak ada data.
      </div>

      @endforelse

      @if($data->hasPages())

      <div class="bg-white rounded-xl shadow p-4">
        {{ $data->links() }}
      </div>

      @endif

    </div>
    <script>
      /* ===========================================================
| SWEET ALERT + AJAX
===========================================================*/

      function syncData() {

        Swal.fire({
          title: 'Sinkronisasi Data?',
          text: 'Data calon siswa akan diperbarui dari server.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya, Sinkronkan',
          cancelButtonText: 'Batal',
          reverseButtons: true,
          customClass: {
            popup: 'rounded-3xl',
            confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl',
            cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-xl'
          },
          buttonsStyling: false
        }).then((result) => {

          if (!result.isConfirmed) return;

          Swal.fire({
            title: 'Sedang Sinkron...',
            html: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          fetch("{{ route('calon-siswa.sync') }}")
            .then(res => res.json())
            .then(res => {

              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                confirmButtonText: 'OK'
              }).then(() => {
                location.reload();
              });

            })
            .catch(() => {

              Swal.fire(
                'Gagal',
                'Sinkronisasi gagal.',
                'error'
              );

            });

        });

      }



      async function kirim(id) {

        const confirm = await Swal.fire({

          title: 'Jadikan Siswa Aktif?',
          text: 'Data akan dipindahkan ke tabel siswa.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal',
          reverseButtons: true

        });

        if (!confirm.isConfirmed) {
          return;
        }

        Swal.fire({

          title: 'Memproses...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }

        });

        try {

          const response = await fetch(`/calon-siswa/${id}/push`, {

            method: 'POST',

            headers: {

              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'

            }

          });

          const res = await response.json();

          if (!response.ok) {

            throw new Error(
              res.message ?? 'Terjadi Kesalahan'
            );

          }

          updateStatus(id, res.data.status);

          Swal.fire({

            icon: 'success',
            title: 'Berhasil',
            text: res.message

          }).then(() => {

            location.reload();

          });

        } catch (e) {

          Swal.fire({

            icon: 'error',
            title: 'Gagal',
            text: e.message

          });

        }

      }



      async function resetData(id) {

        const confirm = await Swal.fire({

          title: 'Reset Status?',
          text: 'Status akan dikembalikan menjadi Calon Siswa.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal',
          reverseButtons: true

        });

        if (!confirm.isConfirmed) {
          return;
        }

        Swal.fire({

          title: 'Memproses...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }

        });

        try {

          const response = await fetch(`/calon-siswa/${id}/reset-status`, {

            method: 'POST',

            headers: {

              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'

            }

          });

          const res = await response.json();

          if (!response.ok) {

            throw new Error(
              res.message ?? 'Terjadi Kesalahan'
            );

          }

          updateStatus(id, res.data.status);

          Swal.fire({

            icon: 'success',
            title: 'Berhasil',
            text: res.message

          }).then(() => {

            location.reload();

          });

        } catch (e) {

          Swal.fire({

            icon: 'error',
            title: 'Gagal',
            text: e.message

          });

        }

      }



      function updateStatus(id, status) {

        const desktop = document.getElementById(`status-${id}`);
        const mobile = document.getElementById(`status-mobile-${id}`);

        const className = status === "dipindah_ke_siswa" ?
          'px-3 py-1 text-xs rounded-full bg-green-100 text-green-700' :
          'px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700';

        if (desktop) {

          desktop.innerHTML = status;
          desktop.className = className;

        }

        if (mobile) {

          mobile.innerHTML = status;
          mobile.className = className;

        }

      }
    </script>
    {{-- ================= CHART JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      const chartProvinsi = @json($chartProvinsi);
      const chartKabupaten = @json($chartKabupaten);

      /* ===========================================================
      | GRAFIK PROVINSI
      ===========================================================*/
      new Chart(document.getElementById('chartProvinsi'), {

        type: 'bar',

        data: {

          labels: chartProvinsi.map(item => item.name ?? '-'),

          datasets: [{

            label: 'Jumlah Calon Siswa',

            data: chartProvinsi.map(item => item.total),

            borderWidth: 1,

            borderRadius: 8,

            maxBarThickness: 40

          }]

        },

        options: {

          responsive: true,

          maintainAspectRatio: false,

          plugins: {

            legend: {
              display: false
            },

            tooltip: {

              callbacks: {

                label: function(context) {

                  return context.parsed.y + ' Siswa';

                }

              }

            }

          },

          scales: {

            y: {
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }

          }

        }

      });


      /* ===========================================================
      | GRAFIK KABUPATEN
      ===========================================================*/

      new Chart(document.getElementById('chartKabupaten'), {

        type: 'bar',

        data: {

          labels: chartKabupaten.map(item => item.name ?? '-'),

          datasets: [{

            label: 'Jumlah Calon Siswa',

            data: chartKabupaten.map(item => item.total),

            borderWidth: 1,

            borderRadius: 8,

            maxBarThickness: 20

          }]

        },

        options: {

          responsive: true,

          maintainAspectRatio: false,

          indexAxis: 'y',

          plugins: {

            legend: {
              display: false
            },

            tooltip: {

              callbacks: {

                label: function(context) {

                  return context.parsed.x + ' Siswa';

                }

              }

            }

          },

          scales: {

            x: {
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }

          }

        }

      });
    </script>

    {{-- ================= FOOTER ================= --}}
    @if(session('success'))

    <script>
      Swal.fire({

        icon: 'success',

        title: 'Berhasil',

        text: '{{ session("success") }}',

        timer: 2500,

        showConfirmButton: false

      });
    </script>

    @endif


    @if(session('error'))

    <script>
      Swal.fire({

        icon: 'error',

        title: 'Gagal',

        text: '{{ session("error") }}'

      });
    </script>

    @endif

</x-app-layout>