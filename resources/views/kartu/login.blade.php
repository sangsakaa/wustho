<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Kartu Login Siswa</title>

  <style>
   

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: #fff;
    }

    .card {
      width: 85.6mm;
      height: 53.98mm;
      box-sizing: border-box;
      padding: 4mm;
      border: 1px solid #111;
      position: relative;
    }

    /* HEADER */
    .header {
      text-align: center;
      border-bottom: 1px solid #000;
      padding-bottom: 2mm;
      margin-bottom: 2mm;
    }

    .header .instansi {
      font-size: 9px;
      font-weight: bold;
      letter-spacing: 0.5px;
    }

    .header .sub {
      font-size: 7px;
      margin-top: 1px;
    }

    /* BODY */
    .body {
      text-align: center;
    }

    .nama {
      font-size: 9px;
      font-weight: bold;
      margin-top: 2mm;
    }

    .nis {
      font-size: 7.5px;
      margin-top: 1mm;
      color: #333;
    }

    /* QR */
    .qr {
      margin-top: 2mm;
      text-align: center;
    }

    .qr img {
      width: 26mm;
      height: 26mm;
    }

    /* FOOTER */
    .footer {
      position: absolute;
      bottom: 2mm;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 6px;
      color: #444;
      border-top: 1px solid #ddd;
      padding-top: 1mm;
    }
  </style>
</head>

<body>

  <div class="card">

    <!-- HEADER -->
    <div class="header">
      <div class="instansi">KARTU IDENTITAS SISWA</div>
      <div class="sub">Sistem Presensi Digital Sekolah</div>
    </div>

    <!-- BODY -->
    <div class="body">
      <div class="nama">{{ $siswa->nama_siswa }}</div>
      <div class="nis">NIS: {{ $nis }}</div>

      <div class="qr">
        <img src="data:image/png;base64,{{ $qr }}">
      </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
      Kartu ini bersifat resmi untuk login & presensi siswa
    </div>

  </div>

</body>

</html>