<!DOCTYPE html>
<html>

<head>
  <style>
    @page {
      margin: 10px;
      size: A4 landscape;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 10px;
      margin: 0;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      page-break-inside: auto;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 4px;
      text-align: center;
      vertical-align: middle;
    }

    th {
      font-weight: bold;
      background: #f2f2f2;
    }

    .left {
      text-align: left;
      padding-left: 5px;
    }

    h1,
    h2,
    p {
      text-align: center;
      margin: 2px;
    }
  </style>
</head>

<body>

  <h1>MADRASAH DINIYAH WUSTHO WAHIDIYAH</h1>
  <h2>LAPORAN PLOTING GURU</h2>
  <p>
    Tahun Pelajaran {{ $Periode->periode }} {{ $Periode->ket_semester }}
  </p>

  <br>

  @php
  $kelasList = [
  '1A','1B','1C','1D',
  '2A','2B','2C','2D',
  '3A','3B','3C','3D'
  ];

  function norm($val) {
  return strtoupper(str_replace(' ', '', trim($val)));
  }

  // FIX: groupBy mapel
  $data = $laporan->groupBy('nama_guru')->map(function ($items) {
  return $items->groupBy('mapel');
  });

  $no = 1;
  @endphp

  <table>
    <thead>
      <tr>
        <th rowspan="2">NO</th>
        <th rowspan="2">NAMA GURU</th>
        <th rowspan="2">PELAJARAN</th>
        <th colspan="{{ count($kelasList) }}">KELAS</th>
        <th rowspan="2">JUMLAH KELAS</th>
        <th rowspan="2">JUMLAH JAM</th>
      </tr>
      <tr>
        @foreach ($kelasList as $k)
        <th>{{ $k }}</th>
        @endforeach
      </tr>
    </thead>

    <tbody>
      @foreach ($data as $guru => $mapels)

      @php
      $rowspanGuru = $mapels->count();
      $firstGuru = true;
      @endphp

      @foreach ($mapels as $mapel => $items)

      @php
      $kelasAktif = $items->pluck('nama_kelas')->toArray();
      $jumlahKelas = count(array_unique($kelasAktif));
      $jumlahJam = $jumlahKelas * 2;
      @endphp

      <tr>

        @if ($firstGuru)
        <td rowspan="{{ $rowspanGuru }}">{{ $no++ }}</td>
        <td rowspan="{{ $rowspanGuru }}" class="left">
          {{ $guru }}
        </td>
        @php $firstGuru = false; @endphp
        @endif

        <td class="left">
          {{ ucwords(strtolower($mapel)) }}
        </td>

        @foreach ($kelasList as $kelas)
        @php
        $ada = in_array($kelas, $kelasAktif);
        @endphp

        <td>
          {{ $ada ? 2 : '' }}
        </td>
        @endforeach

        <td>
          <b>{{ $jumlahKelas }}</b>
        </td>

        <td>
          <b>{{ $jumlahJam }}</b>
        </td>
      </tr>

      @endforeach
      @endforeach

      {{-- TOTAL --}}
      <tr>
        <td colspan="3"><b>TOTAL JAM</b></td>

        @foreach ($kelasList as $kelas)
        @php
        $total = $laporan->where('nama_kelas', $kelas)->count() * 2;
        @endphp
        <td><b>{{ $total ?: '' }}</b></td>
        @endforeach

        <td>
          <b>{{ $laporan->count() }}</b>
        </td>

        <td>
          <b>{{ $laporan->count() * 2 }}</b>
        </td>
      </tr>
    </tbody>
  </table>

</body>

</html>