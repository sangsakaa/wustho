<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMEDI @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .jumbotron {
            padding-top: 6rem;
            background-color: #e2edff;
            padding-bottom: 2rem;
        }

        #project {
            background-color: #e2edff;
        }

        .card {
            margin-bottom: 0.5rem;
        }

        section {
            padding-top: 4rem;
        }

        .bold-text {
            font-weight: bold;
        }
    </style>
</head>

<body id="home">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand text-uppercase text-sm" href="/">
                {{ $kelasmi->jenjang }}
            </a>

            <!-- Button toggle mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-white">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">MASUK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/nism-siswa">NISN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="jumbotron text-center">
        <img src="{{ asset('asset/images/logo.png') }}" alt="Logo" width="150">

        <h2>MADRASAH DINIYAH WAHIDIYAH</h2>
        <p class="text-uppercase fs-5">
            Madrasah Diniyah {{ $kelasmi->jenjang }} Wahidiyah
        </p>
    </section>

    <!-- Content -->
    <div class="container py-4">
        <div class="row text-center">
            <div class="col-md-6 mb-4">
                <lord-icon
                    src="https://cdn.lordicon.com/amjaykqd.json"
                    trigger="hover"
                    style="width:223px;height:205px">
                </lord-icon>
                <p>Consultation</p>
            </div>

            <div class="col-md-6 mb-4">
                <lord-icon
                    src="https://cdn.lordicon.com/yypubrzc.json"
                    trigger="hover"
                    style="width:223px;height:205px">
                </lord-icon>
                <p>Development</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center bg-primary text-white py-3">
        <small>&copy; 2022 Madin Wustha Wahidiyah</small>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.lordicon.com/lordicon-1.3.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>