<x-app-layout>
  {{-- ================= HEADER ================= --}}
  <x-slot name="header">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
        📚 Dashboard Calon Siswa
      </h1>
      <p class="text-sm text-slate-500">
        Kelola data calon siswa dan proses mutasi ke siswa aktif
      </p>
    </div>
  </x-slot>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @php
  $total = ($stats['mondok'] ?? 0) + ($stats['tidak_mondok'] ?? 0);
  $mondokPercent = $total ? round(($stats['mondok'] / $total) * 100) : 0;
  $tidakPercent = $total ? round(($stats['tidak_mondok'] / $total) * 100) : 0;
  @endphp

  <div class="max-w-7xl mx-auto px-6 py-6 space-y-6">

    {{-- ================= TOP BAR ================= --}}
    <div class="bg-white rounded-2xl shadow p-6">

      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b pb-4">

        <div>
          <h2 class="text-lg font-semibold text-slate-800">
            Distribusi Calon Siswa
          </h2>
          <p class="text-sm text-slate-500">
            Monitoring data Provinsi dan Kabupaten
          </p>
        </div>

        <div class="flex flex-wrap gap-2">

          <a href="{{ route('debug.sync') }}"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white shadow hover:bg-amber-600 transition">
            🐞 Debug API
          </a>

          <button
            onclick="syncData()"
            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-emerald-700 transition">
            🔄 Sync Data
          </button>

        </div>

      </div>

      <!-- Grafik -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <!-- Grafik Provinsi -->
        <div class="rounded-xl border bg-white p-4 shadow-sm">
          <h3 class="text-sm font-semibold text-slate-700 mb-4">
            📍 Grafik Calon Siswa Berdasarkan Provinsi
          </h3>

          <canvas id="chartProvinsi" height="280"></canvas>
        </div>

        <!-- Grafik Kabupaten -->
        <div class="rounded-xl border bg-white p-4 shadow-sm">
          <h3 class="text-sm font-semibold text-slate-700 mb-4">
            🏙️ Grafik Calon Siswa Berdasarkan Kabupaten
          </h3>

          <canvas id="chartKabupaten" height="280"></canvas>
        </div>

      </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">

      <form method="GET" class="bg-white p-4 rounded-2xl shadow">
        <div class="flex flex-col md:flex-row gap-3">
          <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama siswa..."
            class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">

          <button
            type="submit"
            class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold">
            Cari
          </button>
        </div>
      </form>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-slate-500">Total</p>
        <p class="text-xl font-bold">{{ $stats['all'] }}</p>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-slate-500">Calon</p>
        <p class="text-xl font-bold text-yellow-600">
          {{ $stats['calon'] }}
        </p>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-slate-500">Dipindah</p>
        <p class="text-xl font-bold text-green-600">
          {{ $stats['dipindah'] }}
        </p>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-slate-500">Mondok / Tidak</p>
        <p class="text-sm font-bold text-red-600">
          {{ $stats['mondok'] }}
          /
          <span class="text-blue-600">
            {{ $stats['tidak_mondok'] }}
          </span>
        </p>
      </div>

    </div>

    {{-- ================= FILTER ================= --}}
    <div class="bg-white shadow rounded-2xl p-3 overflow-x-auto">
      <div class="flex gap-2 min-w-max">

        {{-- JENJANG --}}
        <a href="{{ request()->fullUrlWithQuery(['jenjang' => null]) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ !request('jenjang') ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          Semua
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenjang' => 'SMP']) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ request('jenjang') == 'SMP' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          SMP
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenjang' => 'SMA']) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ request('jenjang') == 'SMA' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          SMA
        </a>

        <div class="w-px bg-slate-200 mx-2"></div>

        {{-- STATUS --}}
        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ !request('status') ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600' }}">
          Semua Status
        </a>

        <a href="{{ request()->fullUrlWithQuery(['status' => 'calon-siswa']) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ request('status') == 'calon-siswa' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600' }}">
          Calon
        </a>

        <a href="{{ request()->fullUrlWithQuery(['status' => 'dipindah_ke_siswa']) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ request('status') == 'dipindah_ke_siswa' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600' }}">
          Dipindah
        </a>

        <div class="w-px bg-slate-200 mx-2"></div>

        {{-- RENCANA --}}
        <a href="{{ request()->fullUrlWithQuery(['rencana_pendidikan' => null]) }}"
          class="px-4 py-2 text-sm rounded-xl border {{ !request('rencana_pendidikan') ? 'bg-purple-600 text-white' : 'bg-white text-slate-600' }}">
          Semua Rencana
        </a>

        <a href="{{ request()->fullUrlWithQuery(['rencana_pendidikan' => 'Mondok']) }}"
          class="px-4 py-2 text-sm rounded-xl border flex items-center gap-2 {{ request('rencana_pendidikan') == 'Mondok' ? 'bg-red-600 text-white' : 'bg-white text-slate-600' }}">
          Mondok
          <span class="text-xs px-2 py-0.5 rounded-full bg-white text-red-600">
            {{ $stats['mondok'] ?? 0 }}
          </span>
        </a>

        <a href="{{ request()->fullUrlWithQuery(['rencana_pendidikan' => 'Tidak Mondok']) }}"
          class="px-4 py-2 text-sm rounded-xl border flex items-center gap-2 {{ request('rencana_pendidikan') == 'Tidak Mondok' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          Tidak Mondok
          <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-600">
            {{ $stats['tidak_mondok'] ?? 0 }}
          </span>
        </a>

      </div>
    </div>

    {{-- ================= PROGRESS ================= --}}
    <div class="bg-white p-4 rounded-2xl shadow">
      <div class="flex justify-between text-sm mb-2">
        <span class="text-red-600 font-semibold">Mondok</span>
        <span class="text-blue-600 font-semibold">Tidak Mondok</span>
      </div>

      <div class="w-full bg-slate-200 h-3 rounded-full overflow-hidden flex">
        <div
          class="bg-red-500 h-3"
          style="width: {{ $mondokPercent }}%">
        </div>

        <div
          class="bg-blue-500 h-3"
          style="width: {{ $tidakPercent }}%">
        </div>
      </div>
    </div>

    {{-- ================= TABLE DESKTOP ================= --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden hidden lg:block">

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
              <th class="p-4 text-left">Nama</th>
              <th class="p-4 text-left">Jenjang</th>
              <th class="p-4 text-left">Status</th>
              <th class="p-4 text-left">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y">
            @forelse($data as $row)
            @php
            $rencana = $row->data_api['rencana_pendidikan'] ?? '-';
            @endphp

            <tr class="hover:bg-slate-50">
              <td class="p-4 font-semibold">
                {{ $row->nama }} <br>
                <span class=" text-xs text-gray-500">
                  {{$row->tempat_lahir}} -
                  {{ \Carbon\Carbon::parse($row->tanggal_lahir)->translatedFormat('l, d F Y') }}
                  {{ $row->provinsi ?? '-' }}
                  {{ $row->kabupaten ??'-'}}
                </span>
              </td>

              <td class="p-4">
                <span class="px-3 py-1 text-xs rounded-xl {{ $rencana == 'Mondok' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                  {{ $row->jenjang }} - {{ $rencana }}
                </span>
              </td>

              <td class="p-4">
                <span
                  id="status-{{ $row->id }}"
                  class="px-3 py-1 text-xs rounded-xl bg-slate-200">
                  {{ $row->status }}
                </span>
              </td>

              <td class="p-4 flex gap-2">

                @if($row->status == 'calon-siswa')
                <button
                  onclick="kirim({{ $row->id }})"
                  class="px-3 py-1 text-xs rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                  Jadikan Siswa
                </button>
                @endif

                @if($row->status == 'dipindah_ke_siswa')
                <button
                  onclick="resetData({{ $row->id }})"
                  class="px-3 py-1 text-xs rounded-xl bg-yellow-500 text-white hover:bg-yellow-600">
                  Reset
                </button>
                @endif

              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="p-6 text-center text-slate-400">
                Tidak ada data
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if ($data->hasPages())
      <div class="p-4 border-t">
        {{ $data->links() }}
      </div>
      @endif
    </div>

    {{-- ================= MOBILE CARD ================= --}}
    <div class="lg:hidden bg-white rounded-2xl shadow divide-y">
      {{-- isi mobile card tetap seperti milik Anda --}}
    </div>

  </div>

  {{-- ================= JAVASCRIPT ================= --}}
  <script>
    function syncData() {
      Swal.fire({
        title: 'Sinkronisasi Data?',
        text: 'Data calon siswa akan diperbarui dari sumber API.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Sinkronkan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
          popup: 'rounded-3xl',
          confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2 rounded-xl mx-2',
          cancelButton: 'bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-5 py-2 rounded-xl mx-2'
        },
        buttonsStyling: false
      }).then((result) => {

        if (!result.isConfirmed) return;

        Swal.fire({
          title: 'Memproses...',
          html: 'Sedang melakukan sinkronisasi data',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        fetch("{{ route('calon-siswa.sync') }}")
          .then(r => r.json())
          .then(res => {
            Swal.fire({
              icon: 'success',
              title: 'Sinkronisasi Berhasil',
              text: res.message,
              confirmButtonText: 'OK',
              customClass: {
                popup: 'rounded-3xl',
                confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl'
              },
              buttonsStyling: false
            }).then(() => {
              location.reload();
            });
          });
      });
    }

    function kirim(id) {

      Swal.fire({
        title: 'Jadikan Siswa Aktif?',
        text: 'Data calon siswa akan dipindahkan menjadi siswa aktif.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Jadikan Siswa',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
          popup: 'rounded-3xl',
          confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-xl mx-2',
          cancelButton: 'bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-5 py-2 rounded-xl mx-2'
        },
        buttonsStyling: false
      }).then(async (result) => {

        if (!result.isConfirmed) return;

        Swal.fire({
          title: 'Memproses...',
          html: 'Sedang memindahkan data siswa',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
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
              res.message ||
              'Terjadi kesalahan saat memindahkan siswa'
            );
          }

          updateStatus(id, res.data.status);

          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: res.message || 'Siswa berhasil dipindahkan',
            confirmButtonText: 'OK',
            customClass: {
              popup: 'rounded-3xl',
              confirmButton: 'bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl'
            },
            buttonsStyling: false
          });

        } catch (error) {

          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: error.message,
            confirmButtonText: 'Tutup',
            customClass: {
              popup: 'rounded-3xl',
              confirmButton: 'bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl'
            },
            buttonsStyling: false
          });

        }

      });
    }

    function resetData(id) {

      Swal.fire({
        title: 'Reset Status?',
        text: 'Status siswa akan dikembalikan menjadi calon siswa.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then(async (result) => {

        if (!result.isConfirmed) return;

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
              res.message || 'Gagal mereset status siswa'
            );
          }

          updateStatus(id, res.data.status);

          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: res.message || 'Status berhasil direset'
          });

        } catch (error) {

          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: error.message
          });

        }

      });
    }

    function updateStatus(id, status) {
      const desktop = document.getElementById(`status-${id}`);
      const mobile = document.getElementById(`status-mobile-${id}`);

      const cls = status === 'dipindah_ke_siswa' ?
        'px-3 py-1 text-xs rounded-xl bg-green-100 text-green-700' :
        'px-3 py-1 text-xs rounded-xl bg-yellow-100 text-yellow-700';

      if (desktop) {
        desktop.innerText = status;
        desktop.className = cls;
      }

      if (mobile) {
        mobile.innerText = status;
        mobile.className = cls;
      }

      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Status berhasil diperbarui',
        timer: 1500,
        showConfirmButton: false
      });
    }
  </script>
  <script>
    const chartProvinsi = @json($chartProvinsi);
    const chartKabupaten = @json($chartKabupaten);

    new Chart(document.getElementById('chartProvinsi'), {
      type: 'bar',
      data: {
        labels: chartProvinsi.map(item => item.name),
        datasets: [{
          label: 'Jumlah Calon Siswa',
          data: chartProvinsi.map(item => item.total),
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    new Chart(document.getElementById('chartKabupaten'), {
      type: 'bar',
      data: {
        labels: chartKabupaten.map(item => item.name),
        datasets: [{
          label: 'Jumlah Calon Siswa',
          data: chartKabupaten.map(item => item.total),
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        indexAxis: 'y',
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  </script>
</x-app-layout>