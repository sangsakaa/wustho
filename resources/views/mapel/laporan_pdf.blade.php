<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11px;
      color: #222;
    }

    .center {
      text-align: center;
      margin-bottom: 10px;
    }

    h2 {
      margin: 0;
      font-size: 17px;
      font-weight: bold;
    }

    .subtitle {
      margin-top: 4px;
      font-size: 11px;
      color: #555;
    }

    h3 {
      margin: 12px 0 8px;
      font-size: 12px;
      border-left: 4px solid #333;
      padding-left: 8px;
    }

    /* 🔥 1 KELAS = 1 HALAMAN */
    .kelas-page {
      page-break-after: always;
    }

    .kelas-page:last-child {
      page-break-after: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    th {
      background: #e9ecef;
      border: 1px solid #bbb;
      padding: 8px;
      text-align: center;
      font-size: 11px;
    }

    td {
      border: 1px solid #ddd;
      padding: 6px;
      vertical-align: top;
      word-wrap: break-word;
    }

    tbody tr:nth-child(even) {
      background: #fafafa;
    }

    thead {
      display: table-header-group;
    }

    tr {
      page-break-inside: avoid;
    }

    /* kolom */
    .no {
      width: 5%;
      text-align: center;
    }

    .mapel {
      width: 22%;
      font-weight: bold;
    }

    .kitab {
      width: 18%;
      color: #444;
    }

    .guru {
      width: 25%;
    }

    .kelas {
      width: 15%;
      text-align: center;
    }

    .hari {
      width: 15%;
      text-align: center;
      text-transform: capitalize;
    }

    .muted {
      font-size: 10px;
      color: #777;
    }

    .empty {
      text-align: center;
      color: #777;
    }
  </style>
</head>

<body>

  <div class="center">
    <h2>LAPORAN KURIKULUM</h2>
    <div class="subtitle">
      Periode: {{ $periode->periode ?? '-' }}
      ({{ $periode->semester->ket_semester ?? '-' }})
    </div>
  </div>

  {{-- LOOP KELAS --}}
  @forelse($data as $kelas => $mapels)

  <div class="kelas-page">

    <h3>Kelas: {{ $kelas }}</h3>

    {{-- 🔥 SATU TABEL UNTUK SEMUA MAPEL --}}
    <table>

      <thead>
        <tr>
          <th class="no">No</th>
          <th class="mapel">Mata Pelajaran</th>
          <th class="kitab">Kitab</th>
          <th class="guru">Guru Pengampu</th>
          <th class="kelas">Kelas</th>
          <th class="hari">Hari</th>
        </tr>
      </thead>

      <tbody>

        @php $no = 1; @endphp

        @foreach($mapels as $mapel)

        @php
        $rows = [];

        foreach ($mapel->daftar_jadwal as $dj) {
        $rows[] = [
        'guru' => $dj->guru->nama_guru ?? '-',
        'kelas' => $dj->jadwal->kelasmi->nama_kelas ?? '-',
        'hari' => $dj->jadwal->hari ?? '-',
        ];
        }

        $rowspan = count($rows) ?: 1;
        @endphp

        @forelse($rows as $index => $r)
        <tr>

          @if($index == 0)
          <td class="no" rowspan="{{ $rowspan }}">{{ $no++ }}</td>

          <td class="mapel" rowspan="{{ $rowspan }}">
            {{ $mapel->mapel }}
            <div class="muted">{{ $mapel->nama_kitab ?? '-' }}</div>
          </td>

          <td class="kitab" rowspan="{{ $rowspan }}">
            {{ $mapel->nama_kitab ?? '-' }}
          </td>
          @endif

          <td class="guru">{{ $r['guru'] }}</td>
          <td class="kelas">{{ $r['kelas'] }}</td>
          <td class="hari">{{ $r['hari'] }}</td>

        </tr>
        @empty
        <tr>
          <td class="no">{{ $no++ }}</td>
          <td class="mapel">{{ $mapel->mapel }}</td>
          <td class="kitab">{{ $mapel->nama_kitab ?? '-' }}</td>
          <td colspan="3" class="empty">Tidak ada jadwal</td>
        </tr>
        @endforelse

        @endforeach

      </tbody>

    </table>

  </div>

  @empty
  <p class="center empty">Tidak ada data laporan</p>
  @endforelse

</body>

</html>