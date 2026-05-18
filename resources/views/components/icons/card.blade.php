<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  <div class="bg-white rounded-xl shadow border p-5">
    <p class="text-sm text-slate-500">Total Kelas</p>
    <h3 class="text-3xl font-bold text-blue-600">{{ $total }}</h3>
  </div>

  <div class="bg-white rounded-xl shadow border p-5">
    <p class="text-sm text-slate-500">Selesai</p>
    <h3 class="text-3xl font-bold text-emerald-600">{{ $done }}</h3>
  </div>

  <div class="bg-white rounded-xl shadow border p-5">
    <p class="text-sm text-slate-500">Belum Selesai</p>
    <h3 class="text-3xl font-bold text-rose-600">{{ $notDone }}</h3>
  </div>

  <div class="bg-white rounded-xl shadow border p-5">
    <p class="text-sm text-slate-500">Progress</p>
    <h3 class="text-3xl font-bold text-purple-600">{{ $percent }}%</h3>
  </div>
</div>