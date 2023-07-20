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
        <div class=" px-2 py-2 grid grid-cols-1 sm:grid-cols-2  w-full bg-blue-200 ">
            <div class=" flex grid-cols-1">
                <div>
                    <a class="navbar-brand" href="/">
                        <img src="asset/images/logo.png" alt="" width="70px">
                    </a>
                </div>
                <div class=" py-1 px-2">
                    <p class=" text-lg">NIMW</p>
                    <p class="  text-blue-600">Nomor Induk Murid Wustho</p>
                    <p class=" text-xs">Alamat : Pondok Pesantren Kedunglo
                        Jl.KH. Wachid Hasyim Kota Kediri
                        Jawa Timur
                    </p>
                </div>
            </div>
            <div class=" justify-end grid">
                <div class="  mt-8 mx-4 ">
                    <a class=" py-2 bg-blue-700 text-white px-4 " href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="dropdown" data-bs-theme="dark"> -->
    <div>
        <div class=" grid grid-cols-1 sm:grid-cols-2 p-2 gap-2">
            <div class=" h-32 rounded-md bg-blue-300 p-2">
                <form action="/" method="get" class="  text-sm gap-1 ">
                    <div class=" w-full px-4 gap-2">
                        <span class=" uppercase">Pencarian NIMW (Nomor induk murid WUSTHO)</span>
                        <div class=" py-1">
                            <input type="text" max="8" name="cari" value="{{ request('cari') }}" class=" border w-full  py-2 px-2 " placeholder=" Masukan NIMW : 20220200109" autofocus>
                        </div>
                        <button type="submit" class=" hover:bg-blue-800 px-2 py-2 rounded-md    bg-blue-500   text-white">
                            Cari By NIMW </button>
                    </div>
                </form>
            </div>
            <div class=" bg-blue-200 p-2 rounded-md">
                <div class=" sm:flex grid ">
                    <div>
                        <img src="asset/images/logo.png" alt="" width="70px">
                    </div>
                    <div class=" px-2 mt-1">
                        <p class=" text-sm">MADRASAH DINIYAH WAHIDIYAH</p>
                        <p class=" text-xs sm:text-sm">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                        <p class=" text-sm">Alamat : Pondok Pesantren Kedunglo
                            Jl.KH. Wachid Hasyim Kota Kediri
                            Jawa Timur
                        </p>
                    </div>
                </div>
                <hr class=" mt-0.5 ">
                <div class=" grid ">
                    @if($dataNIS->isEmpty())
                    <p>No data available.</p>
                    @else
                    @foreach($dataNIS as $detail)
                    @if($detail->id == request('cari'))
                    @else
                    <div class=" grid grid-cols-2">
                        <div class=" py-2">
                            NIMW
                        </div>
                        <div class=" py-2">
                            : {{$detail->nis}}
                        </div>
                    </div>
                    <hr>
                    <div class=" grid grid-cols-2">
                        <div class=" py-2">
                            Nama
                        </div>
                        <div class=" py-2">
                            : {{$detail->nama_siswa}}
                        </div>
                    </div>
                    <hr>
                    <div class=" grid grid-cols-2">
                        <div class=" py-2">
                            Tempat ,Tanggal Lahir
                        </div>
                        <div class=" py-2">
                            : {{$detail->tempat_lahir}} , {{ \Carbon\Carbon::parse($detail->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                        </div>
                    </div>

                </div>
                <hr>
                <div class=" grid grid-cols-2">
                    <div class=" py-2">
                        Asrama
                    </div>
                    <div class=" py-2">
                        :
                    </div>
                </div>
                <hr>
                @endif
                @endforeach
                @endif
            </div>
        </div>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>