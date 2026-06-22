<x-app-layout>

  <x-slot name="header">
    <h2 class="text-2xl font-bold">📚 Dashboard Calon Siswa</h2>
  </x-slot>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <div class="py-6 max-w-7xl mx-auto space-y-4">

    {{-- ================= DASHBOARD ================= --}}
    <div class="grid grid-cols-4 gap-3">
      <div class="bg-white p-4 rounded-xl shadow">
        <p>Total</p>
        <b>{{ $stats['all'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p>SMP</p>
        <b>{{ $stats['smp'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p>SMA</p>
        <b>{{ $stats['sma'] ?? 0 }}</b>
      </div>

      <div class="bg-white p-4 rounded-xl shadow">
        <p>Calon</p>
        <b>{{ $stats['calon'] ?? 0 }}</b>
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
          <tr id="row-{{ $row->id }}" class="border-b">

            <td class="p-3">{{ $row->nama }}</td>

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

              <button onclick="kirim({{ $row->id }}, this)"
                class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                Kirim
              </button>

              <button onclick="resetData({{ $row->id }})"
                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                Reset
              </button>

            </td>

          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center p-4 text-gray-500">
              Data tidak ditemukan
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>

    </div>

    {{-- ================= JS ================= --}}
    <script>
      // ================= UPDATE STATUS =================
      function updateRow(id, status) {
        const el = document.getElementById(`status-${id}`);
        if (el) el.innerText = status;
      }

      // ================= KIRIM =================
      function kirim(id, btn) {

        btn.disabled = true;
        btn.innerText = "Proses...";

        Swal.fire({
          title: 'Push To Siswa?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal'
        }).then(res => {

          if (!res.isConfirmed) {
            btn.disabled = false;
            btn.innerText = "Kirim";
            return;
          }

          fetch(`/calon-siswa/${id}/push`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              }
            })
            .then(async r => {
              const data = await r.json();

              if (!r.ok) throw data;

              return data;
            })
            .then(res => {

              updateRow(id, res.data.status);

              Swal.fire({
                icon: 'success',
                title: res.message || 'Berhasil',
                timer: 1500,
                showConfirmButton: false
              });

            })
            .catch(err => {

              Swal.fire({
                icon: 'error',
                title: err.message || 'Gagal proses',
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
            .then(async r => {
              const data = await r.json();
              if (!r.ok) throw data;
              return data;
            })
            .then(res => {

              updateRow(id, res.data.status);

              Swal.fire({
                icon: 'success',
                title: res.message,
                timer: 1200,
                showConfirmButton: false
              });

            })
            .catch(err => {

              Swal.fire({
                icon: 'error',
                title: err.message || 'Error reset',
              });

            });

        });

      }
    </script>

  </div>

</x-app-layout>