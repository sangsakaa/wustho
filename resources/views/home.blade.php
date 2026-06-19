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
        :root {
            --primary: #198754;
            --secondary: #20c997;
            --dark: #14532d;
            --light: #f5fff8;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8faf9;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--dark)) !important;
            padding: 12px 0;
            transition: .3s;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin-left: 10px;
            transition: .3s;
        }

        .nav-link:hover {
            color: #d1fae5 !important;
        }

        /* Hero Section */
        .jumbotron {
            min-height: 100vh;
            padding-top: 130px;
            padding-bottom: 80px;

            background: linear-gradient(rgba(20, 83, 45, .85),
                rgba(25, 135, 84, .85)),
            url('{{ asset(' asset/images/bg.jpg') }}');

            background-size: cover;
            background-position: center;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
        }

        .hero-logo {
            width: 180px;
            background: white;
            padding: 12px;
            border-radius: 50%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .2);
            margin-bottom: 25px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: .9;
            margin-bottom: 30px;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
        }

        /* Feature Section */
        .feature-section {
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .feature-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            text-align: center;
            transition: .4s;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px rgba(25, 135, 84, .15);
        }

        .feature-card p {
            margin-top: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
        }

        /* Info Section */
        .info-section {
            padding: 80px 0;
        }

        .info-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .info-box h3 {
            color: var(--primary);
            font-weight: 700;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg,
                    var(--dark),
                    var(--primary));
            color: white;
            padding: 25px 0;
        }

        @media(max-width:768px) {

            .hero-title {
                font-size: 2rem;
            }

            .hero-logo {
                width: 130px;
            }

            .feature-section {
                margin-top: 0;
                padding-top: 30px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
        <div class="container">

            <a class="navbar-brand text-uppercase" href="/">
                {{ $kelasmi->jenjang }}
            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse"
                id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('login') }}">
                            MASUK
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                            href="/nism-siswa">
                            NISN
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    <!-- HERO -->
    <section class="jumbotron">

        <div class="hero-content">

            <img src="{{ asset('asset/images/logo.png') }}"
                class="hero-logo"
                alt="Logo">

            <h1 class="hero-title">
                MADRASAH DINIYAH WAHIDIYAH
            </h1>

            <p class="hero-subtitle text-uppercase">
                Madrasah Diniyah
                {{ $kelasmi->jenjang }}
                Wahidiyah
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">

                <a href="{{ route('login') }}"
                    class="btn btn-light btn-custom">
                    Masuk Sistem
                </a>

                <a href="/nism-siswa"
                    class="btn btn-outline-light btn-custom">
                    Cek NISN
                </a>

            </div>

        </div>

    </section>

    <!-- FEATURE -->
    <div class="container feature-section">

        <div class="row g-4">

            <div class="col-md-6">

                <div class="feature-card">

                    <lord-icon
                        src="https://cdn.lordicon.com/amjaykqd.json"
                        trigger="hover"
                        style="width:180px;height:180px">
                    </lord-icon>

                    <p>Consultation</p>

                </div>

            </div>

            <div class="col-md-6">

                <div class="feature-card">

                    <lord-icon
                        src="https://cdn.lordicon.com/yypubrzc.json"
                        trigger="hover"
                        style="width:180px;height:180px">
                    </lord-icon>

                    <p>Development</p>

                </div>

            </div>

        </div>

    </div>

    <!-- ABOUT -->
    <section class="info-section">

        <div class="container">

            <div class="info-box text-center">

                <h3 class="mb-3">
                    Sistem Madrasah Diniyah Wahidiyah
                </h3>

                <p class="text-muted mb-0">
                    Sistem informasi akademik Madrasah Diniyah
                    Wahidiyah yang digunakan untuk mengelola data
                    siswa, nilai, kelas, NISN, dan berbagai layanan
                    administrasi pendidikan secara digital.
                </p>

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <footer>

        <div class="container text-center">

            <h6 class="mb-2">
                Madrasah Diniyah Wahidiyah
            </h6>

            <small>
                © {{ date('Y') }}
                Madin Wustha Wahidiyah.
                All Rights Reserved.
            </small>

        </div>

    </footer>

    <!-- SCRIPT -->
    <script src="https://cdn.lordicon.com/lordicon-1.3.0.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>