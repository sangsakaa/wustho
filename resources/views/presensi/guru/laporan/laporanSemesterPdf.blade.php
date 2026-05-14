<!DOCTYPE html>
<html>

<head>
  <title>Laporan Presensi Guru</title>

  <style>
    @page {
      size: F4 landscape;
      margin: 10mm;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
    }

    /* ================= KOP ================= */
    .kop {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .kop img {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }

    .kop .text {
      text-align: center;
      line-height: 1.2;
    }

    .u1 {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 12px;
    }

    .u2 {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 16px;
    }

    .u3 {
      font-size: 11px;
    }

    /* ================= JUDUL ================= */
    .judul {
      text-align: center;
      margin-bottom: 10px;
    }

    .judul .title {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 14px;
    }

    .judul .sub {
      font-size: 12px;
    }

    /* ================= TABLE ================= */
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 10px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 5px;
      text-align: center;
    }

    thead {
      display: table-header-group;
    }

    tr {
      page-break-inside: avoid;
    }
  </style>
</head>

<body>

  <!-- ================= KOP ================= -->
  <div class="kop">

    @php
    $logo = base64_encode(file_get_contents(public_path('asset/images/logo.png')));
    @endphp

    <img src="data:image/png;base64,{{ $logo }}">

    <div class="text">
      <div class="u1">Departemen Pendidikan Diniyah Wahidiyah</div>
      <div class="u2">Madrasah Diniyah Wustho Wahidiyah</div>
      <div class="u3">
        {{ $periode->semester->ket_semester ?? '-' }}
        | TP {{ $periode->periode ?? '-' }}
      </div>
    </div>
  </div>

  <!-- ================= JUDUL ================= -->
  <div class="judul">
    <div class="title">Laporan Presensi Guru</div>
    <div class="sub">
      @if($mode=='harian')
      Harian - {{ $tanggal->format('d F Y') }}
      @elseif($mode=='semester')
      Semester - {{ $periode->semester->ket_semester ?? '-' }}
      @else
      Bulanan - {{ $tanggal->translatedFormat('F Y') }}
      @endif
    </div>
  </div>

  <!-- ================= TABLE ================= -->
  <!-- ================= TABLE ================= -->
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Guru</th>
        <th>Kelas</th>
        <th>Hari</th>
        <th>Sesi</th>
        <th>Total</th>
        <th>Hadir</th>
        <th>Izin</th>
        <th>Sakit</th>
        <th>Alfa</th>
      </tr>
    </thead>

    <tbody>

      @php
      $sorted = $laporan->sortBy(function ($row) {

      // ambil nama bersih
      $name = trim($row->nama_guru ?? '');

      // kalau kosong / NULL / '-' → taruh paling bawah
      if ($name === '' || $name === '-') {
      return 'zzz';
      }

      // case-insensitive biar urutan rapi
      return strtolower($name);
      });
      @endphp

      @forelse($sorted as $i => $row)
      <tr>
        <td>{{ $i+1 }}</td>

        <td>
          {{ $row->nama_guru && $row->nama_guru !== '' ? $row->nama_guru : '-' }}
        </td>

        <td>{{ $row->nama_kelas }}</td>
        <td>{{ $row->hari }}</td>
        <td>{{ $row->sesi }}</td>
        <td>{{ $row->total }}</td>
        <td>{{ $row->hadir }}</td>
        <td>{{ $row->izin }}</td>
        <td>{{ $row->sakit }}</td>
        <td>{{ $row->alfa }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="10">Tidak ada data</td>
      </tr>
      @endforelse

    </tbody>
  </table>

</body>

</html>