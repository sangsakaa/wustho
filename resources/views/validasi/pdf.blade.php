<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Validasi Data</title>

  <style>
    body {
      font-family: sans-serif;
      font-size: 10px;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header h2,
    .header h3,
    .header p {
      margin: 2px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th,
    table td {
      border: 1px solid #000;
      padding: 4px;
      vertical-align: top;
    }

    table th {
      background: #f3f4f6;
      text-align: center;
    }

    .text-center {
      text-align: center;
    }

    .footer {
      margin-top: 30px;
      width: 100%;
    }

    .signature {
      width: 250px;
      float: right;
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="header">
    <h2>LAPORAN VALIDASI DATA SISWA</h2>
    <h3>SMK PGRI MUARA KOMAM</h3>
    <p>Tahun Pelajaran {{ date('Y') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>JK</th>
        <th>TTL</th>
        <th>Kelas</th>
        <th>Ayah</th>
        <th>Ibu</th>
        <th>Status Anak</th>
        <th>Saudara</th>
        <th>Anak Ke</th>
        <th>Pengamal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $item)
      <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td>{{ strtoupper($item->nama_siswa) }}</td>
        <td class="text-center">{{ $item->jenis_kelamin }}</td>
        <td>
          {{ $item->tempat_lahir }},
          {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}
        </td>
        <td class="text-center">{{ $item->nama_kelas }}</td>
        <td>
          {{ $item->nama_ayah }} <br>
          {{ $item->pekerjaan_ayah }} <br>
          {{ $item->nomor_hp_ayah }}
        </td>
        <td>
          {{ $item->nama_ibu }} <br>
          {{ $item->pekerjaan_ibu }} <br>
          {{ $item->nomor_hp_ibu }}
        </td>
        <td class="text-center">{{ $item->status_anak }}</td>
        <td class="text-center">{{ $item->jumlah_saudara }}</td>
        <td class="text-center">{{ $item->anak_ke }}</td>
        <td class="text-center">{{ $item->status_pengamal }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    <div class="signature">
      <p>Muara Komam, {{ date('d F Y') }}</p>
      <p>Kepala Sekolah</p>

      <br><br><br>

      <p><b>______________________</b></p>
    </div>
  </div>

</body>

</html>