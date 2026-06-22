<x-app-layout>

  <x-slot name="header">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

      <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
          📚 Dashboard Calon Siswa
        </h1>

        <p class="text-sm text-slate-500 mt-1">
          Kelola data calon siswa dan proses mutasi ke siswa aktif
        </p>
      </div>



    </div>
  </x-slot>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <div class="px-6 py-6 max-w-7xl mx-auto space-y-6">

    {{-- =========================================================
            TAB JENJANG
        ========================================================= --}}
    <div class=" flex gap-2">
      <div class="flex flex-wrap gap-2 border-b pb-3">

        <a href="{{ request()->fullUrlWithQuery(['jenjang' => null]) }}"
          class="px-4 py-2 text-sm rounded-xl border
   {{ !request('jenjang') ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          Semua
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenjang' => 'SMP']) }}"
          class="px-4 py-2 text-sm rounded-xl border
   {{ request('jenjang') == 'SMP' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          SMP
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenjang' => 'SMA']) }}"
          class="px-4 py-2 text-sm rounded-xl border
   {{ request('jenjang') == 'SMA' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600' }}">
          SMA
        </a>

      </div>

      {{-- =========================================================
            TAB STATUS
        ========================================================= --}}
      <div class="flex flex-wrap gap-2 border-b pb-3">

        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
          class="px-4 py-2 text-sm rounded-xl border
                {{ !session('active_status') ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600' }}">
          Semua Status
        </a>

        <a href="{{ request()->fullUrlWithQuery(['status' => 'calon-siswa']) }}"
          class="px-4 py-2 text-sm rounded-xl border
                {{ session('active_status') == 'calon-siswa' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600' }}">
          Calon
        </a>

        <a href="{{ request()->fullUrlWithQuery(['status' => 'dipindah_ke_siswa']) }}"
          class="px-4 py-2 text-sm rounded-xl border
                {{ session('active_status') == 'dipindah_ke_siswa' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600' }}">
          Dipindah
        </a>
        <button onclick="syncData()"
          class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 transition">
          🔄 Sync Data
        </button>

        @if(session('active_jenjang') || session('active_status'))
        <div class="rounded-xl bg-slate-100 px-4 py-2 text-xs text-slate-600">
          Mode:
          {{ session('active_jenjang') ?? 'ALL' }} |
          {{ session('active_status') ?? 'ALL' }}
        </div>
        @endif
      </div>
    </div>

    {{-- =========================================================
            DASHBOARD STATS
        ========================================================= --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

      <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs text-slate-500">Total</p>
        <h3 class="text-2xl font-bold">{{ $stats['all'] ?? 0 }}</h3>
      </div>

      <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs text-slate-500">SMP</p>
        <h3 class="text-2xl font-bold text-blue-600">{{ $stats['SMP'] ?? 0 }}</h3>
      </div>

      <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs text-slate-500">SMA</p>
        <h3 class="text-2xl font-bold text-green-600">{{ $stats['SMA'] ?? 0 }}</h3>
      </div>

      <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs text-slate-500">Calon</p>
        <h3 class="text-2xl font-bold text-yellow-600">{{ $stats['calon'] ?? 0 }}</h3>
      </div>

    </div>

    {{-- =========================================================
            TABLE
        ========================================================= --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

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
            <tr id="row-{{ $row->id }}" class="hover:bg-slate-50">

              <td class="p-4 font-semibold">
                {{ $row->nama }}
              </td>

              <td class="p-4">
                <span class="px-3 py-1 text-xs rounded-xl bg-blue-100 text-blue-700">
                  {{ $row->jenjang }}
                </span>
              </td>

              <td class="p-4">
                <span id="status-{{ $row->id }}"
                  class="px-3 py-1 text-xs rounded-xl bg-slate-200">
                  {{ $row->status }}
                </span>
              </td>

              <td class="p-4 flex gap-2">

                <button onclick="kirim({{ $row->id }}, this)"
                  class="px-3 py-1 text-xs rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all duration-200 disabled:opacity-100 disabled:bg-blue-600">
                  Jadikan Siswa
                </button>

                <button onclick="resetData({{ $row->id }})"
                  class="px-3 py-1 text-xs rounded-xl bg-yellow-500 text-white hover:bg-yellow-600">
                  Reset
                </button>

              </td>

            </tr>
            @empty
            <tr>
              <td colspan="4" class="p-6 text-center text-slate-400">
                Tidak ada data calon siswa
              </td>
            </tr>
            @endforelse

          </tbody>

        </table>
      </div>

    </div>

  </div>

  {{-- =========================================================
        JAVASCRIPT (TIDAK DIHAPUS)
    ========================================================= --}}
  <script>
    function syncData() {
      Swal.fire({
        title: 'Sinkronisasi data?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Sync'
      }).then(res => {
        if (!res.isConfirmed) return;

        Swal.fire({
          title: 'Loading...',
          didOpen: () => Swal.showLoading()
        });

        fetch("{{ route('calon-siswa.sync') }}")
          .then(r => r.json())
          .then(res => {
            Swal.fire('Success', res.message, 'success');
            setTimeout(() => location.reload(), 800);
          })
          .catch(() => Swal.fire('Error', 'Sync gagal', 'error'));
      });
    }

    function kirim(id, btn) {
      Swal.fire({
        title: 'Jadikan Siswa?',
        text: 'Data akan dipindahkan ke tabel siswa aktif',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Proses',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563eb', // blue-600
        cancelButtonColor: '#64748b' // slate-500
      }).then(res => {
        if (!res.isConfirmed) return;

        // ================= LOADING BUTTON STYLE =================
        btn.disabled = true;
        btn.innerHTML = `
      <span class="flex items-center gap-2">
        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Memproses...
      </span>
    `;

        btn.className =
          "px-3 py-1 text-xs rounded-xl bg-slate-400 text-white cursor-not-allowed";

        fetch(`/calon-siswa/${id}/push`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          })
          .then(r => r.json())
          .then(res => {

            updateStatus(id, res.data.status);

            Swal.fire({
              title: 'Berhasil!',
              text: res.message,
              icon: 'success',
              confirmButtonColor: '#22c55e' // green-500
            });

            // ================= SUCCESS BUTTON STYLE =================
            btn.innerHTML = '✓ Selesai';
            btn.className =
              "px-3 py-1 text-xs rounded-xl bg-green-600 text-white";

          })
          .catch(() => {
            Swal.fire({
              title: 'Gagal!',
              text: 'Terjadi kesalahan saat proses data',
              icon: 'error',
              confirmButtonColor: '#ef4444'
            });

            // ================= RESET BUTTON =================
            btn.disabled = false;
            btn.innerHTML = 'Jadikan Siswa';
            btn.className =
              "px-3 py-1 text-xs rounded-xl bg-blue-600 text-white hover:bg-blue-600";
          })
          .finally(() => {
            if (!btn.disabled) {
              btn.disabled = false;
              btn.innerHTML = 'Jadikan Siswa';
              btn.className =
                "px-3 py-1 text-xs rounded-xl bg-blue-600 text-white hover:bg-blue-600";
            }
          });
      });
    }

    function resetData(id) {
      fetch(`/calon-siswa/${id}/reset-status`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
        .then(r => r.json())
        .then(res => {
          updateStatus(id, res.data.status);
          Swal.fire('Success', res.message, 'success');
        });
    }

    function updateStatus(id, status) {
      const el = document.getElementById(`status-${id}`);
      if (!el) return;

      el.innerText = status;

      el.className =
        'px-3 py-1 text-xs rounded-xl ' +
        (status === 'dipindah_ke_siswa' ?
          'bg-green-200' :
          'bg-slate-200');
    }
  </script>

</x-app-layout>