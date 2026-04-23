<thead class="bg-gray-100 text-gray-700 text-xs uppercase">
  <tr>
    <th class="px-3 py-2 border">No</th>
    <th class="px-3 py-2 border">NIG</th>
    <th class="px-3 py-2 border">Nama</th>
    <th class="px-3 py-2 border">Jabatan</th>
    <th class="px-3 py-2 border">JK</th>
    <th class="px-3 py-2 border">Agama</th>
    <th class="px-3 py-2 border">TTL</th>
    <th class="px-3 py-2 border">Masuk</th>
    <th class="px-3 py-2 border">Status</th>
    <th class="px-3 py-2 border text-center">Aksi</th>
  </tr>
</thead>

<tbody>
  @forelse ($data as $item)
  <tr class="hover:bg-gray-50">
    <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>

    <td class="px-3 py-2 border text-center">
      {{ optional($item->NigTerakhir)->nig ?? '-' }}
    </td>

    <td class="px-3 py-2 border font-medium">
      {{ $item->nama_perangkat }}
    </td>

    <td class="px-3 py-2 border">
      @forelse($item->jabatan as $jab)
      <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">
        {{ $jab->nama_jabatan }}
      </span>
      @empty
      -
      @endforelse
    </td>

    <td class="px-3 py-2 border text-center">{{ $item->jenis_kelamin }}</td>
    <td class="px-3 py-2 border text-center">{{ $item->agama }}</td>

    <td class="px-3 py-2 border text-xs text-center">
      {{ $item->tempat_lahir }},
      {{ $item->tanggal_lahir 
                ? \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMM Y') 
                : '-' }}
    </td>

    <td class="px-3 py-2 border text-center">
      {{ $item->tanggal_masuk 
                ? \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D/MM/Y') 
                : '-' }}
    </td>

    <td class="px-3 py-2 border text-center">
      <span class="px-2 py-1 rounded text-xs 
                {{ $item->status == 'aktif' 
                    ? 'bg-green-100 text-green-600' 
                    : 'bg-gray-200 text-gray-600' }}">
        {{ $item->status }}
      </span>
    </td>

    <td class="px-3 py-2 border">
      <div class="flex justify-center gap-1">
        <a href="/detail-perangkat/{{ $item->id }}"
          class="bg-sky-500 text-white px-2 py-1 rounded text-xs">Detail</a>

        <a href="/edit-form-perangkat/{{ $item->id }}/edit"
          class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">Edit</a>

        <form action="/edit-form-perangkat/{{ $item->id }}" method="post"
          onsubmit="return confirm('Yakin hapus {{ $item->nama_perangkat }}?')">
          @csrf
          @method('delete')

          <button type="submit"
            class="bg-red-500 text-white px-2 py-1 rounded text-xs">
            Hapus
          </button>
        </form>
      </div>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="10" class="text-center py-4 text-gray-500">
      Data tidak ditemukan
    </td>
  </tr>
  @endforelse
</tbody>