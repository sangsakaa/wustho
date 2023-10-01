<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMEDI @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    .jumbotron {
        padding-top: 6rem;
        background-color: #e2edff;
        padding-bottom: 0%;
    }

    #project {
        background-color: #e2edff;
    }

    .card {
        margin-bottom: 0.5rem;
    }

    .footer {
        padding-bottom: 0%;
    }

    section {
        padding-top: 4rem;
    }

    .p {
        font-family: bold;
    }
</style>

<body id="home">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container">
            <img src="asset/images/logo.png" class=" px-2" alt="" width="60px">
            <a class="navbar-brand uppercase" href="/">{{$kelasmi->jenjang}} </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project">Faculty</a>
                    </li>
                    <li class="nav-item bg-sky-300">

                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- end Navbar -->
    <!-- Jumbotron -->
    <section class="jumbotron jumbotron-fluid text-center">
        <center>
            <img src="asset/images/logo.png" alt="" width="150px">
            <h1 class="display-4 text-md ">Madrasah Diniyah {{$kelasmi->jenjang}} Wahidiyah</h1>
            <p class="lead text-monospace">"Mencetak Wali yang Intelek dan Intelektual yang Wali"</p>
            <div class=" py-4">
                <a class="py-2 text-white bg-blue-600 rounded-md px-4" href="{{ route('login') }}">Masuk</a>
            </div>
        </center>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,250.7C384,267,480,277,576,240C672,203,768,117,864,106.7C960,96,1056,160,1152,197.3C1248,235,1344,245,1392,250.7L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>
    <!-- end Jumbotron -->
    <!-- Abouts -->
    <section id="about">
        <div class="container">
            <div class="row text-center mb-3">
                <div class="col">
                    <h2>About</h2>
                </div>
            </div>
            <div class="row justify-content-center text-center text-monospace">
                <div class="col-sm-4">
                    Sejarah <br>
                    //
                </div>
                <div class="col-sm-4">
                    Visi <br>

                    <br>

                    Misi <br>

                </div>
                <div class="col-sm-4">
                    Tujuan <br>

                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#e2edff" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,250.7C384,267,480,277,576,240C672,203,768,117,864,112C960,107,1056,181,1152,192C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>
    <!-- end about -->
    <!-- Project -->
    <section id="project">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-center mb-3">
                    <h2> MADRASAH DINIYAH WAHIDIYAH</h2>
                </div>
            </div>
            <div class="  grid grid-cols-3">
                <div class=" grid justify-center justify-items-center">
                    <img src="asset/images/logo.png" class=" px-2" alt="" width="160px">
                    <div class="card-body">
                        <h3 class="card-text">MADIN ULA WAHIDIYAH </h3>
                    </div>

                </div>
                <div class=" grid justify-center justify-items-center">
                    <img src="asset/images/logo.png" class=" px-2" alt="" width="160px">
                    <div class="card-body">
                        <h3 class="card-text">MADIN WUSTHA WAHIDIYAH </h3>
                    </div>
                </div>
                <div class=" grid justify-center justify-items-center">
                    <img src="asset/images/logo.png" class=" px-2" alt="" width="160px">
                    <div class="card-body">
                        <h3 class="card-text">MADIN ULYA WAHIDIYAH</h3>
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1" d="M0,160L48,165.3C96,171,192,181,288,176C384,171,480,149,576,128C672,107,768,85,864,90.7C960,96,1056,128,1152,128C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>
    <!-- end Project -->
    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col text-center mb-3">
                    <h2>
                        Contact Me
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center mb-3 ">
                <div class="col-sm-6">
                    <form>
                        <div class="form-group text-center">
                            <a type="button" class="btn btn-danger" href=""><i class="bi bi-globe"></i> Pendaftaran</a>

                            <a type="button" class="btn btn-danger" href="https://chat.whatsapp.com/Eo33aM3j6XDHNV8L08x25m">Join Group</a>
                            <br>
                            <small>jika ada kendala bisa hubungi nomor di atas atau join ini</small>
                        </div>



                    </form>
                </div>
            </div>

        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0d6efd" fill-opacity="1" d="M0,160L48,181.3C96,203,192,245,288,234.7C384,224,480,160,576,149.3C672,139,768,181,864,186.7C960,192,1056,160,1152,128C1248,96,1344,64,1392,48L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>
    <!-- end Contact -->
    <!-- Footer -->
    <footer class="bg-primary text-center  text-white pb-5">
        <p>
            Create with <i class="bi bi-heart-fill text-danger"></i> Madin Diniyah Wustho By &copy; 2022
        </p>
    </footer>
    <!-- endfooter -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
    </script>

</body>



</html>