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
        <table>
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Nama Siswa</th>
                    <th>Total Alfa</th>
                </tr>
            </thead>
            <tbody>
                @php
                $prevKelas = null;
                @endphp
                @foreach ($data as $item)
                <tr>
                    @if ($item->nama_kelas != $prevKelas)
                    <td class="border " rowspan="6">{{ $item->nama_kelas }}</td>
                    @php
                    $prevKelas = $item->nama_kelas;
                    @endphp
                    @endif
                    <td class="border ">{{ $item->nama_siswa }}</td>
                    <td class="border ">{{ $item->total_alfa }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>