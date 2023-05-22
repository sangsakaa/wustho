<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="asset/images/logo.png" alt="" width="50px"><br>
            </a>
            <ul class=" mx-4">
                <a class="dropdown-item active py-2" href="{{ route('login') }}">Masuk</a>
            </ul>
        </div>

    </nav>
    <div class="dropdown" data-bs-theme="dark">
        <div class=" bg-white px-2 py-2">
            <center>
                <div class=" uppercase text-green-800  block sm:hidden">
                    <p class=" text-2xl">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                    <p class=" text-3xl">Laporan Kehadiran</p>
                    <p class=" text-md">Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}}{{$periode = $kelasmi->ket_semester ?? ' ';}}</p>

                    <hr class=" border border-b-2 border-green-800">
            </center>
            <table class=" w-full mt-2">
                <thead>
                    <tr>
                        <th class=" border border-green-800  text-center px-1">Nama Kelas</th>
                        <th class=" border border-green-800  text-center px-1">Nama Siswa</th>
                        <th class=" border border-green-800  text-center px-1">Total Alfa</th>
                        <th class=" border border-green-800  text-center px-1">Total Sakit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $currentKelas = null;
                    @endphp
                    @foreach($data as $item)
                    <tr>
                        @if($currentKelas !== $item->nama_kelas)
                        @php
                        $currentKelas = $item->nama_kelas;
                        $rowCount = $data->where('nama_kelas', $item->nama_kelas)->count();
                        @endphp
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{ $item->nama_kelas }}
                        </td>
                        @endif
                        <td class="border border-green-800 px-1 py-1 capitalize">{{$loop->iteration}}. {{ strtolower($item->nama_siswa) }}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_alfa }}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_sakit }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>


        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>