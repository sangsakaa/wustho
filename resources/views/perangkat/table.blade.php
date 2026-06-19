<thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-slate-600 text-xs uppercase tracking-wider">
  <tr>
    <th class="px-4 py-3.5 text-center w-12">No</th>
    <th class="px-4 py-3.5 text-center">NIG</th>
    <th class="px-4 py-3.5 text-left">Nama</th>
    <th class="px-4 py-3.5 text-left">Jabatan</th>
    <th class="px-4 py-3.5 text-center">JK</th>
    <th class="px-4 py-3.5 text-center">Masuk</th>
    <th class="px-4 py-3.5 text-center">Status</th>
    <th class="px-4 py-3.5 text-center">Aksi</th>
  </tr>
</thead>

<tbody class="divide-y divide-slate-100">
  @forelse ($data as $item)
  <tr class="hover:bg-slate-50 transition-colors duration-150 even:bg-slate-50/50">
    <td class="px-4 py-3.5 text-center text-slate-500 text-xs">{{ $loop->iteration }}</td>

    <td class="px-4 py-3.5 text-center">
      <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded">
        {{ optional($item->NigTerakhir)->nig ?? '-' }}
      </span>
    </td>

    <td class="px-4 py-3.5 font-medium text-slate-800">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-sky-400 flex items-center justify-center text-white text-xs font-bold shrink-0">
          {{ strtoupper(substr($item->nama_perangkat, 0, 1)) }}
        </div>
        <span>{{ $item->nama_perangkat }}</span>
      </div>
    </td>

    <td class="px-4 py-3.5">
      <div class="flex flex-wrap gap-1">
        @forelse($item->jabatan as $jab)
        <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-full text-xs font-medium">
          {{ $jab->nama_jabatan }}
        </span>
        @empty
        <span class="text-slate-400 text-xs">-</span>
        @endforelse
      </div>
    </td>

    <td class="px-4 py-3.5 text-center">
      <span class="text-xs {{ $item->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">
        {{ $item->jenis_kelamin }}
      </span>
    </td>
    <td class="px-4 py-3.5 text-center text-xs text-slate-600">
      {{ $item->tanggal_masuk 
                ? \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D/MM/Y') 
                : '-' }}
    </td>

    <td class="px-4 py-3.5 text-center">
      @if($item->status == 'aktif')
      <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2.5 py-0.5 rounded-full text-xs font-medium">
        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
        Aktif
      </span>
      @else
      <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 border border-slate-200 px-2.5 py-0.5 rounded-full text-xs font-medium">
        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
        {{ $item->status }}
      </span>
      @endif
    </td>

    <td class="px-4 py-3.5">
      <div class="flex justify-center gap-1.5">
        <a href="/detail-perangkat/{{ $item->id }}"
          class="inline-flex items-center gap-1 bg-sky-500 hover:bg-sky-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          Detail
        </a>

        <a href="/edit-form-perangkat/{{ $item->id }}/edit"
          class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          Edit
        </a>

        <form action="/edit-form-perangkat/{{ $item->id }}" method="post"
          onsubmit="return confirm('Yakin hapus {{ $item->nama_perangkat }}?')">
          @csrf
          @method('delete')

          <button type="submit"
            class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Hapus
          </button>
        </form>
      </div>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="10" class="text-center py-12 text-slate-400">
      <div class="flex flex-col items-center gap-2">
        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <span>Data tidak ditemukan</span>
      </div>
    </td>
  </tr>
  @endforelse
</tbody>