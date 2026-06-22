<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">

      <h2 class="text-2xl font-bold">
        📚 Dashboard Calon Siswa
        @if(session('active_jenjang'))
        - {{ session('active_jenjang') }}
        @endif

        @if(session('active_status'))
        / {{ session('active_status') }}
        @endif
      </h2>

      <div class="flex gap-2">

        {{-- ================= SYNC ================= --}}
        <button onclick="syncData()"
          class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
          🔄 Sync Data
        </button>

        @if(session('active_jenjang') || session('active_status'))
        <span class="text-sm px-3 py-1 bg-gray-100 rounded-full">
          Mode:
          {{ session('active_jenjang') ?? 'ALL' }}
          |
          {{ session('active_status') ?? 'ALL STATUS' }}
        </span>
        @endif

      </div>

    </div>
  </x-slot>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <div class="py-6 max-w-7xl mx-auto space-y-4">

    {{-- ================= TAB JENJANG ================= --}}
    <div class="flex gap-2">

      <a href="{{ request()->fullUrlWithQuery(['jenjang' => null]) }}"
        class="px-4 py-2 rounded text-sm {{ !session('active_jenjang') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Semua
      </a>

      <a href="{{ request()->fullUrlWithQuery(['jenjang' => 'SMP']) }}"
        class="px-4 py-2 rounded text-sm {{ session('active_jenjang') == 'SMP' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        SMP
      </a>

      <a href="{{ request()->fullUrlWithQuery(['jenjang' => 'SMA']) }}"
        class="px-4 py-2 rounded text-sm {{ session('active_jenjang') == 'SMA' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        SMA
      </a>

    </div>

    {{-- ================= TAB STATUS ================= --}}
    <div class="flex gap-2">

      <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
        class="px-4 py-2 rounded text-sm {{ !session('active_status') ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
        Semua Status
      </a>

      <a href="{{ request()->fullUrlWithQuery(['status' => 'calon-siswa']) }}"
        class="px-4 py-2 rounded text-sm {{ session('active_status') == 'calon-siswa' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
        Calon
      </a>

      <a href="{{ request()->fullUrlWithQuery(['status' => 'dipindah_ke_siswa']) }}"
        class="px-4 py-2 rounded text-sm {{ session('active_status') == 'dipindah_ke_siswa' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
        Dipindah
      </a>

      <a href="{{ request()->fullUrlWithQuery(['status' => 'done-briva']) }}"
        class="px-4 py-2 rounded text-sm {{ session('active_status') == 'done-briva' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
        BRIVA
      </a>

    </div>

    {{-- ================= DASHBOARD ================= --}}
    <div class="grid grid-cols-4 gap-3">

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">Total</p>
        <b class="text-lg">{{ $stats['all'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">SMP</p>
        <b class="text-lg text-blue-600">{{ $stats['smp'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">SMA</p>
        <b class="text-lg text-green-600">{{ $stats['sma'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-gray-500 text-sm">Calon</p>
        <b class="text-lg text-yellow-600">{{ $stats['calon'] ?? 0 }}</b>
      </div>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

      <table class="w-full text-sm">

        <thead class="bg-gray-100">
          <tr>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Jenjang</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Aksi</th>
          </tr>
        </thead>

        <tbody>

          @forelse($data as $row)
          <tr id="row-{{ $row->id }}" class="border-b hover:bg-gray-50">

            <td class="p-3 font-medium">{{ $row->nama }}</td>

            <td class="p-3">
              <span class="px-2 py-1 text-xs rounded bg-blue-100">
                {{ $row->jenjang }}
              </span>
            </td>

            <td class="p-3">
              <span id="status-{{ $row->id }}" class="px-2 py-1 text-xs rounded bg-gray-200">
                {{ $row->status }}
              </span>
            </td>

            <td class="p-3 space-x-2">

              <button
                onclick="kirim({{ $row->id }}, this)"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                Kirim
              </button>

              <button
                onclick="resetData({{ $row->id }})"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                Reset
              </button>

            </td>

          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center p-6 text-gray-500">
              Tidak ada data calon siswa
            </td>
          </tr>
          @endforelse

        </tbody>

      </table>

    </div>

  </div>

  {{-- ================= JS ================= --}}
  <script>
    function updateRow(id, status) {
      const el = document.getElementById(`status-${id}`);
      if (el) el.innerText = status;
    }

    // ================= SYNC =================
    function syncData() {

      Swal.fire({
        title: 'Sinkronisasi data?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Sync',
        cancelButtonText: 'Batal'
      }).then(res => {

        if (!res.isConfirmed) return;

        Swal.fire({
          title: 'Sync berjalan...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        fetch(`/calon-siswa/sinkron`, {
            method: 'GET',
            headers: {
              'Accept': 'application/json'
            }
          })
          .then(r => r.json())
          .then(res => {

            Swal.fire({
              icon: 'success',
              title: res.message,
              timer: 1500,
              showConfirmButton: false
            });

            setTimeout(() => location.reload(), 1000);

          })
          .catch(() => {
            Swal.fire({
              icon: 'error',
              title: 'Sync gagal'
            });
          });

      });

    }

    // ================= KIRIM =================
    function kirim(id, btn) {

      Swal.fire({
        title: 'Push ke Siswa?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
      }).then(res => {

        if (!res.isConfirmed) return;

        btn.disabled = true;
        btn.innerText = "Proses...";

        fetch(`/calon-siswa/${id}/push`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(r => r.json())
          .then(res => {
            updateRow(id, res.data.status);

            Swal.fire({
              icon: 'success',
              title: res.message,
              timer: 1200,
              showConfirmButton: false
            });
          })
          .finally(() => {
            btn.disabled = false;
            btn.innerText = "Kirim";
          });

      });

    }

    // ================= RESET =================
    function resetData(id) {

      Swal.fire({
        title: 'Reset status?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
      }).then(res => {

        if (!res.isConfirmed) return;

        fetch(`/calon-siswa/${id}/reset-status`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          })
          .then(r => r.json())
          .then(res => {
            updateRow(id, res.data.status);

            Swal.fire({
              icon: 'success',
              title: res.message,
              timer: 1200,
              showConfirmButton: false
            });
          });

      });

    }
  </script>

</x-app-layout>