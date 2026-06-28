<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Raport Siswa</title>

  <style>
    body {
      font-family: 'Arial', sans-serif;
      font-size: 12px;
      margin: 25px;
      color: #111;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
    }

    .title {
      font-size: 18px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .subtitle {
      font-size: 13px;
      font-weight: bold;
      margin-top: 3px;
    }

    .line {
      border-top: 2px solid #166534;
      margin: 10px 0 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 6px;
      font-size: 11px;
    }

    th {
      background: #166534;
      color: white;
      text-transform: uppercase;
      font-size: 10px;
      letter-spacing: .5px;
    }

    .info td {
      border: none;
      padding: 3px 0;
    }

    .label {
      width: 200px;
      color: #333;
    }

    .bold {
      font-weight: bold;
    }

    .center {
      text-align: center;
    }

    .right {
      text-align: right;
    }

    .section-title {
      font-weight: bold;
      margin: 10px 0 5px;
      font-size: 13px;
      border-left: 4px solid #166534;
      padding-left: 6px;
    }

    .footer {
      width: 100%;
      margin-top: 30px;
      text-align: right;
    }

    .signature {
      margin-top: 60px;
    }

    .badge {
      display: inline-block;
      padding: 2px 6px;
      background: #166534;
      color: white;
      font-size: 10px;
      border-radius: 3px;
    }
  </style>
</head>

<body>

  {{-- HEADER --}}
  <div class="header">
    <div class="title">DAFTAR NILAI HASIL TADRIS</div>
    <div class="subtitle">MADRASAH DINIYAH WUSTHO WAHIDIYAH</div>
    <div class="badge">
      Tahun Pelajaran {{ $siswa->periode }} {{ $siswa->ket_periode }} {{ $siswa->ket_semester }}
    </div>
  </div>

  <div class="line"></div>

  {{-- INFO SISWA --}}
  <table class="info">
    <tr>
      <td class="label">Nomor Induk Siswa</td>
      <td>: <b>{{ $siswa->nis }}</b></td>
    </tr>
    <tr>
      <td class="label">Nama Lengkap</td>
      <td>: {{ $siswa->nama_siswa }}</td>
    </tr>
    <tr>
      <td class="label">Tempat, Tanggal Lahir</td>
      <td>:
        {{ $siswa->tempat_lahir }},
        {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
      </td>
    </tr>
    <tr>
      <td class="label">Kelas</td>
      <td>: {{ $siswa->kelas }} / {{ $siswa->nama_kelas }} / {{ $siswa->madrasah_diniyah }}</td>
    </tr>
  </table>

  <div class="line"></div>

  {{-- NILAI --}}
  <div class="section-title">A. Nilai Mata Pelajaran</div>

  <table>
    <thead>
      <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Mata Pelajaran</th>
        <th rowspan="2">Guru</th>
        <th colspan="2">NILAI</th>
      </tr>
      <tr>
        <th>YAUMIYAH</th>
        <th>IMTIHANIYAH</th>
      </tr>

    </thead>

    <tbody>
      @foreach ($data as $item)
      <tr>
        <td class="center">{{ $loop->iteration }}</td>
        <td>{{ $item->mapel }}</td>
        <td>{{ $item->nama_guru }}</td>
        <td class="center">{{ $item->nilai_harian }}</td>
        <td class="center">{{ $item->nilai_ujian }}</td>
      </tr>
      @endforeach

      <tr>
        <td colspan="3" class="right bold">Jumlah</td>
        <td class="center">{{ $ringkasan['jmlharian'] }}</td>
        <td class="center">{{ $ringkasan['jmlujian'] }}</td>
      </tr>

      <tr>
        <td colspan="3" class="right bold">Rata-rata</td>
        <td class="center">{{ number_format($ringkasan['rata2harian'], 2) }}</td>
        <td class="center">{{ number_format($ringkasan['rata2ujian'], 2) }}</td>
      </tr>

      <tr>
        <td colspan="3" class="right bold">Peringkat</td>
        <td class="center">{{ $peringkat }}</td>
        <td class="center">{{ $peringkat }} / {{ $jumlahsiswa }}</td>
      </tr>
    </tbody>
  </table>

  {{-- AMALIYAH --}}
  <div class="section-title">B. Nilai Amaliyah</div>

  <table>
    <tr>
      <th>No</th>
      <th>Kegiatan</th>
      <th>Nilai</th>
      <th>Al Bayan</th>
    </tr>
    <tr>
      <td class="center">1</td>
      <td>Jama'ah Al Maktubah</td>
      <td class="center">Jayyid</td>
      <td rowspan="4" class="center al-bayan">
        <strong>Al Bayan</strong><br><br>
        1. Rodi' : Buruk / Jelek<br>
        2. Makbul : Cukup<br>
        3. Jayyid : Baik<br>
        4. Mumtaz : Istimewa
        <style>
          .al-bayan {
            text-align: left;
            vertical-align: top;
            line-height: 1.6;
            padding: 2px;
            font-size: 11px;
          }

          .section-title {
            font-weight: bold;
            margin-bottom: 5px;

          }

          .center {
            text-align: center;
          }

          .ttd {
            margin-top: 50px;
          }
        </style>
      </td>
    </tr>
    <tr>
      <td class="center">2</td>
      <td>Al Mujahadah</td>
      <td class="center">Jayyid</td>
    </tr>
    <tr>
      <td class="center">3</td>
      <td>Al Muhadhdhoroh</td>
      <td class="center">Jayyid</td>
    </tr>
    <tr>
      <td class="center">4</td>
      <td>An Nadzhofah</td>
      <td class="center">Jayyid</td>
    </tr>

  </table>

  <table style="width:100%; border:none; margin-top:15px;">
    <tr>
      {{-- KEHADIRAN --}}
      <td style="width:50%; vertical-align:top; border:none; padding-right:10px;">

        <div class="section-title">C. Kehadiran</div>

        <table>
          <tr>
            <th>Keterangan</th>
            <th>Jumlah</th>
          </tr>

          <tr>
            <td>IZIN</td>
            <td class="center">{{ $siswa->izin ?: '-' }}</td>
          </tr>
          <tr>
            <td>SAKIT</td>
            <td class="center">{{ $siswa->sakit ?: '-' }}</td>
          </tr>
          <tr>
            <td>ALFA</td>
            <td class="center">{{ $siswa->alfa ?: '-' }}</td>
          </tr>
        </table>

      </td>

      {{-- TANDA TANGAN --}}
      <td style="width:50%; vertical-align:top;  border:none; text-align:center; " class="ttd">
        <br><br><br>
        Kedunglo, {{ now()->isoFormat('D MMMM YYYY') }}<br>
        Kepala Madrasah

        <div style="height:80px;"></div>

        <b>Muh. Bahrul Ulum, S.H</b>

      </td>
    </tr>
  </table>

</body>

</html>