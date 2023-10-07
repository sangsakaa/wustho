<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMEDI @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <div class="container sm:text-xs">
            <a class="navbar-brand uppercase text-sm  " href="/">{{ $kelasmi->jenjang }}</a>
            <div :class="navClasses   hover:hover:bg-sky-300">
                <ul class="navbar-nav ml-auto text-white">
                    <li class="nav-item">
                        <a class="nav-link   " href="{{ route('login') }}">MASUK</a>
                    </li>
                    <li class="nav-item sm:block hidden">
                        <a class="nav-link   " href="/nism-siswa">NISN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        export default {
            data() {
                return {
                    isOpen: false,
                };
            },
            computed: {
                navClasses() {
                    return {
                        'collapse navbar-collapse': !this.isOpen,
                        'navbar-collapse': this.isOpen,
                    };
                },
            },
            methods: {
                toggleNav() {
                    this.isOpen = !this.isOpen;
                },
            },
        };
    </script>

    <style scoped>
        /* Tambahkan gaya CSS khusus di sini jika diperlukan */
    </style>
    <section class="jumbotron jumbotron-fluid text-center">
        <center>
            <img src="asset/images/logo.png" alt="" width="150px">
            <h2 class=" mt-4"> MADRASAH DINIYAH WAHIDIYAH</h2>
            <p class=" uppercase sm:text-3xl text-xs">Madrasah Diniyah {{$kelasmi->jenjang}} Wahidiyah</p>
        </center>
        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,250.7C384,267,480,277,576,240C672,203,768,117,864,106.7C960,96,1056,160,1152,197.3C1248,235,1344,245,1392,250.7L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg> -->
    </section>
    <!-- end Jumbotron -->
    <!-- Abouts -->

    <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#e2edff" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,250.7C384,267,480,277,576,240C672,203,768,117,864,112C960,107,1056,181,1152,192C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
        </path>
    </svg> -->
    <!-- end about -->
    <!-- Project -->
    <section id="project">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-center mb-3">
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
                    <div>
                        <div class="form-group text-center">
                            <a type="button" class=" bg-blue-600 btn btn-danger" href=""><i class="bi bi-globe"></i> Pendaftaran</a>

                            <a type="button" class=" bg-blue-600 btn btn-danger" href="#">INFORMASI</a>
                            <br>
                            <small>jika ada kendala bisa hubungi nomor di atas atau join ini</small>
                        </div>
                    </div>
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