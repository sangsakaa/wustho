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
    }

    h2 {
      margin: 0;
      font-size: 16px;
      letter-spacing: 0.5px;
    }

    .subtitle {
      margin-top: 2px;
      font-size: 11px;
      color: #555;
    }

    h3 {
      margin-top: 18px;
      margin-bottom: 6px;
      font-size: 12px;
      border-bottom: 1px solid #bbb;
      padding-bottom: 3px;

      /* 🔥 pindah halaman per kelas */
      page-break-before: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-top: 6px;
      page-break-inside: auto;
    }

    th {
      background: #f3f3f3;
      border: 1px solid #ccc;
      padding: 6px;
      text-align: center;
      font-size: 11px;
    }

    td {
      border: 1px solid #ddd;
      padding: 6px;
      vertical-align: top;

      /* 🔥 anti pecah */
      page-break-inside: avoid;
      word-wrap: break-word;
    }

    thead {
      display: table-header-group;
    }

    tr {
      page-break-inside: avoid;
      page-break-after: auto;
    }

    tbody {
      page-break-inside: auto;
    }

    /* 🔥 blok per mapel (kunci utama) */
    .mapel-group {
      page-break-inside: avoid;
    }

    /* kolom */
    .no {
      width: 5%;
      text-align: center;
    }

    .mapel {
      width: 20%;
      font-weight: bold;
    }

    .kitab {
      width: 20%;
      color: #444;
    }

    .guru {
      width: 20%;
    }

    .kelas {
      width: 15%;
      text-align: center;
    }

    .hari {
      width: 10%;
      text-align: center;
      text-transform: capitalize;
    }

    .muted {
      color: #777;
      font-size: 10px;
      margin-top: 2px;
    }

    .empty {
      text-align: center;
      color: #777;
    }
  </style>
</head>

<body>

  {{-- HEADER --}}
  <div class="center">
    <h2>LAPORAN KURIKULUM</h2>
    <div class="subtitle">
      Periode: {{ $periode->periode ?? '-' }}
      ({{ $periode->semester->ket_semester ?? '-' }})
    </div>
  </div>

  {{-- LOOP KELAS --}}
  @forelse($data as $kelas => $mapels)

  <h3>Kelas: {{ $kelas }}</h3>

  <table>
    <thead>
      <tr>
        <th class="no">No</th>
        <th class="mapel">Mata Pelajaran</th>
        <th class="kitab">Kitab</th>
        <th class="guru">Guru</th>
        <th class="kelas">Kelas</th>
        <th class="hari">Hari</th>
      </tr>
    </thead>

    <tbody>

      @forelse($mapels as $mapel)

      @php
      $rows = [];

      foreach ($mapel->daftar_jadwal as $dj) {
      $key = ($dj->guru_id ?? '') . '-' .
      ($dj->jadwal->kelasmi_id ?? '') . '-' .
      ($dj->jadwal->hari ?? '');

      $rows[$key] = [
      'guru' => $dj->guru->nama_guru ?? '-',
      'kelas' => $dj->jadwal->kelasmi->nama_kelas ?? '-',
      'hari' => $dj->jadwal->hari ?? '-',
      ];
      }

      $rows = array_values($rows);
      $rowspan = count($rows) ?: 1;
      @endphp

      {{-- 🔥 GROUP PER MAPEL --}}
      @forelse($rows as $index => $r)
      <tr class="mapel-group">

        {{-- ROWSPAN --}}
        @if($index == 0)
        <td class="no" rowspan="{{ $rowspan }}">
          {{ $loop->parent->iteration }}
        </td>

        <td class="mapel" rowspan="{{ $rowspan }}">
          {{ $mapel->mapel }}
          <div class="muted">{{ $mapel->nama_kitab ?? '-' }}</div>
        </td>

        <td class="kitab" rowspan="{{ $rowspan }}">
          {{ $mapel->nama_kitab ?? '-' }}
        </td>
        @endif

        {{-- DETAIL --}}
        <td class="guru">{{ $r['guru'] }}</td>
        <td class="kelas">{{ $r['kelas'] }}</td>
        <td class="hari">{{ $r['hari'] }}</td>

      </tr>
      @empty
      <tr>
        <td class="no">{{ $loop->iteration }}</td>
        <td class="mapel">{{ $mapel->mapel }}</td>
        <td class="kitab">{{ $mapel->nama_kitab ?? '-' }}</td>
        <td colspan="3" class="empty">Tidak ada jadwal</td>
      </tr>
      @endforelse

      @endforeach

    </tbody>
  </table>

  @empty
  <p class="center empty">Tidak ada data laporan</p>
  @endforelse

</body>

</html>