<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      font-family: sans-serif;
      font-size: 11px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid black;
      padding: 4px;
      text-align: center;
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

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Guru</th>
        @foreach ($laporan->pluck('nama_kelas')->unique()->sort() as $nama_kelas)
        <th>{{ $nama_kelas }}</th>
        @endforeach
        <th>Total Mapel</th>
        <th>Total Kelas</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($laporan->pluck('nama_guru')->unique()->sort() as $nama_guru)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td style="text-align:left">{{ $nama_guru }}</td>

        @foreach ($laporan->pluck('nama_kelas')->unique()->sort() as $nama_kelas)
        @php
        $jumlah = $laporan
        ->where('nama_guru', $nama_guru)
        ->where('nama_kelas', $nama_kelas)
        ->sum('jumlah_mapel');
        @endphp
        <td>{{ $jumlah }}</td>
        @endforeach

        <td>
          {{ $laporan->where('nama_guru', $nama_guru)->sum('jumlah_mapel') }}
        </td>
        <td>
          {{ $laporan->where('nama_guru', $nama_guru)->count() }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</body>

</html>