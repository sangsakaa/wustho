<x-app-layout>

  <x-slot name="header">
    <h2 class="text-2xl font-bold">📚 Dashboard Calon Siswa</h2>
  </x-slot>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <div class="py-6 max-w-7xl mx-auto space-y-4">

    {{-- ================= DASHBOARD ================= --}}
    <div class="grid grid-cols-3 gap-3">

      <div class="bg-white p-4 rounded-xl shadow">
        <p>Total</p>
        <b>{{ $stats['all'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p>Calon</p>
        <b>{{ $stats['calon'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p>Dipindah</p>
        <b>{{ $stats['dipindah'] ?? 0 }}</b>
      </div>

    </div>

    {{-- ================= FILTER ================= --}}
    <form class="bg-white p-4 rounded-xl shadow space-y-3">

      <input name="search"
        value="{{ request('search') }}"
        class="w-full border rounded px-3 py-2"
        placeholder="Cari nama...">

      <div class="flex gap-2">

        @foreach(['','calon-siswa','dipindah_ke_siswa','done-briva'] as $s)
        <a href="?status={{ $s }}"
          class="px-3 py-1 rounded text-sm
  {{ request('status')==$s?'bg-black text-white':'bg-gray-200' }}">
          {{ $s ?: 'Semua' }}
        </a>
        @endforeach

      </div>

    </form>

    {{-- ================= SYNC ================= --}}
    <div class="bg-white p-4 rounded-xl shadow">

      <button onclick="syncData()" class="bg-green-600 text-white px-4 py-2 rounded">
        Live Sync
      </button>

      <div class="w-full bg-gray-200 h-2 mt-3 rounded">
        <div id="bar" class="bg-green-500 h-2 w-0 rounded"></div>
      </div>

      <p id="syncText" class="text-sm mt-2"></p>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

      <table class="w-full text-sm">

        <thead class="bg-gray-100">
          <tr>
            <th>Nama</th>
            <th>Jenjang</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>

          @foreach($data as $row)
          <tr id="row-{{ $row->id }}" class="border-b">

            <td class="p-3">{{ $row->nama }}</td>

            <td class="p-3">{{ $row->jenjang }}</td>

            <td class="p-3">
              <span id="status-{{ $row->id }}"
                class="px-2 py-1 text-xs rounded bg-gray-200">
                {{ $row->status }}
              </span>
            </td>

            <td class="p-3 space-x-2">

              <button onclick="kirim({{ $row->id }})"
                class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                Kirim
              </button>

              <button onclick="resetData({{ $row->id }})"
                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                Reset
              </button>

            </td>

          </tr>
          @endforeach

        </tbody>

      </table>

    </div>

  </div>

  {{-- ================= JS ================= --}}
  <script>
    function updateRow(id, status) {
      document.getElementById(`status-${id}`).innerText = status;
    }

    // KIRIM
    function kirim(id) {

      Swal.fire({
        title: 'Push To Siswa?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',

        buttonsStyling: false, // 🔥 WAJIB supaya Tailwind aktif

        customClass: {
          popup: 'rounded-2xl bg-white dark:bg-gray-900 shadow-xl',
          title: 'text-gray-800 dark:text-white text-lg font-semibold',
          icon: 'text-blue-500',
          confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium mx-1 transition',
          cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium mx-1 transition'
        }
      }).then(res => {

        if (!res.isConfirmed) return;

        fetch(`/calon-siswa/${id}/push`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          })
          .then(r => r.json())
          .then(res => {

            if (res.success) {
              updateRow(id, res.data.status);

              Swal.fire({
                icon: 'success',
                title: res.message,
                timer: 1200,
                showConfirmButton: false
              });

            }
          });
      });

    }

    // RESET
    function resetData(id) {

      Swal.fire({
        title: 'Reset?',
        icon: 'warning',
        showCancelButton: true
      }).then(res => {

        if (!res.isConfirmed) return;

        fetch(`/calon-siswa/${id}/reset-status`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'X-HTTP-Method-Override': 'PUT',
              'Accept': 'application/json'
            }
          })
          .then(r => r.json())
          .then(res => {

            if (res.success) {
              updateRow(id, res.data.status);

              Swal.fire({
                icon: 'success',
                title: res.message,
                timer: 1200,
                showConfirmButton: false
              });
            }

          });

      });

    }

    // LIVE SYNC
    function syncData() {

      let bar = document.getElementById('bar');
      let text = document.getElementById('syncText');

      bar.style.width = '10%';
      text.innerText = 'Sync...';

      let p = 10;

      let i = setInterval(() => {

        p += 10;
        bar.style.width = p + '%';

        if (p >= 90) clearInterval(i);

      }, 200);

      fetch('/calon-siswa/live-sync')
        .then(r => r.json())
        .then(res => {

          bar.style.width = '100%';

          if (res.success) {
            text.innerText = `Selesai ${res.total} data`;

            Swal.fire({
              icon: 'success',
              title: 'Sync selesai',
              timer: 1500,
              showConfirmButton: false
            });

          } else {
            text.innerText = res.message;
          }

        });

    }
  </script>

</x-app-layout>