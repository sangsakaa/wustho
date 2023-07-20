<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMEDI @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class=" ">
        <div class=" px-2 py-2 grid grid-cols-2  w-full bg-blue-200 ">
            <div>
                <a class="navbar-brand" href="/">
                    <img src="asset/images/logo.png" alt="" width="70px">
                </a>
            </div>
            <div class=" justify-end grid">
                <div class=" mt-4 mx-4 ">
                    <a class=" py-2 bg-blue-700 text-white px-4 " href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="dropdown" data-bs-theme="dark"> -->
    <div class=" px-2 mt-2">
        <div class=" bg-white px-2 py-2">
            <center>
                <div class=" uppercase text-green-800  block sm:hidden">
                    <p class=" text-2xl">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                    <p class=" text-3xl">Laporan Kehadiran</p>
                    <p class=" text-md">Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}}{{$periode = $kelasmi->ket_semester ?? ' ';}}</p>
                    <hr class=" border border-b-2 border-green-800">
            </center>
            <div class=" grid grid-cols-2 ">
                <div class="  w-full grid grid-cols-1">
                    <form action="/" method="get" class="  text-sm gap-1 ">
                        <div class=" w-full px-4 gap-2">
                            <div class=" py-1">
                                <input type="text" max="8" name="cari" value="{{ request('cari') }}" class=" border w-full  py-2 px-2 " placeholder=" Masukan NIMW : 20220200109" autofocus>
                            </div>
                            <button type="submit" class=" px-2 py-2 rounded-md    bg-blue-500   text-white">
                                Cari By NIMW </button>
                        </div>
                    </form>
                </div>
                <div class="">
                    <div class="grid-cols-2 flex">
                        <div>
                            <img src="asset/images/logo.png" alt="" width="80px">
                        </div>
                        <div class=" px-1">
                            <p>MADRASAH DINIYAH WAHIDIYAH</p>
                            <p class=" text-2xl">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                            <p>Alamat : Pondok Pesantren Kedunglo
                                Jl.KH. Wachid Hasyim Kota Kediri
                                Jawa Timur
                            </p>
                            <hr class=" ">
                            <div>

                                @if($dataNIS->isEmpty())
                                <p>No data available.</p>
                                @else
                                @foreach($dataNIS as $detail)
                                @if($detail->id == request('cari'))
                                @else
                                <div class=" grid grid-cols-2">
                                    <div>
                                        NIMW
                                    </div>
                                    <div>
                                        : {{$detail->nis}}
                                    </div>
                                </div>
                                <hr>
                                <div class=" grid grid-cols-2">
                                    <div>
                                        Nama
                                    </div>
                                    <div>
                                        : {{$detail->nama_siswa}}
                                    </div>
                                </div>
                                <hr>
                                <div class=" grid grid-cols-2">
                                    <div>
                                        Tempat ,Tanggal Lahir
                                    </div>
                                    <div>
                                        : {{$detail->tempat_lahir}} , {{$detail->tanggal_lahir}}
                                    </div>
                                </div>
                                <hr>

                                @endif
                                @endforeach
                                @endif





                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- <table class=" w-full mt-2">
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
            </table> -->


        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>