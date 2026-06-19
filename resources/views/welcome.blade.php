<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kedunglo Wahidiyah - Sistem Informasi Pendidikan</title>

    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#15803d',
                        secondary: '#22c55e'
                    }
                }
            }
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero-bg {
            background: linear-gradient(rgba(21, 128, 61, .90),
                rgba(22, 101, 52, .90)),
            url('{{ asset("asset/images/bg.jpg") }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg border-b shadow-sm">

        <div class="max-w-7xl mx-auto px-4">

            <div class="flex items-center justify-between h-16">

                <div class="flex items-center gap-3">

                    <img src="{{ asset('asset/images/logo.png') }}"
                        alt="Logo"
                        class="w-11 h-11 rounded-xl bg-white shadow p-1">

                    <div>
                        <h1 class="font-bold text-lg text-primary">
                            Kedunglo Wahidiyah
                        </h1>
                        <p class="text-xs text-gray-500">
                            Sistem Informasi Pendidikan
                        </p>
                    </div>

                </div>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">

                    <a href="#profil"
                        class="hover:text-primary transition">
                        Profil
                    </a>

                    <a href="#jenjang"
                        class="hover:text-primary transition">
                        Jenjang
                    </a>

                    <a href="#nimw"
                        class="hover:text-primary transition">
                        Cek NIMW
                    </a>

                </nav>

                <a href="{{ route('login') }}"
                    class="bg-primary hover:bg-green-800 text-white px-5 py-2 rounded-xl shadow transition">

                    Masuk

                </a>

            </div>

        </div>

    </header>

    <!-- HERO -->
    <section class="hero-bg">

        <div class="max-w-7xl mx-auto px-4 py-24 md:py-36">

            <div class="text-center text-white max-w-4xl mx-auto">

                <img src="{{ asset('asset/images/logo.png') }}"
                    class="w-32 mx-auto mb-6 bg-white rounded-full p-3 shadow-xl">

                <h2 class="text-4xl md:text-6xl font-bold leading-tight">

                    Sistem Informasi
                    <br>
                    Kedunglo Wahidiyah

                </h2>

                <p class="mt-6 text-lg text-green-50">

                    Platform digital untuk pengelolaan data pendidikan,
                    siswa, akademik, asrama, dan administrasi
                    Madrasah Diniyah Wahidiyah secara terintegrasi.

                </p>

                <div class="flex flex-wrap justify-center gap-4 mt-8">

                    <a href="#nimw"
                        class="bg-white text-primary px-6 py-3 rounded-xl font-semibold shadow-lg hover:scale-105 transition">

                        Cek NIMW

                    </a>

                    <a href="{{ route('login') }}"
                        class="border border-white text-white px-6 py-3 rounded-xl hover:bg-white hover:text-primary transition">

                        Login Sistem

                    </a>

                </div>

            </div>

        </div>

    </section>

    <!-- STATISTIK -->
    <section class="max-w-7xl mx-auto px-4 -mt-12 relative z-10">

        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h3 class="text-primary text-xl font-bold">
                    Madrasah Ula
                </h3>
                <p class="text-gray-500 mt-2">
                    Pendidikan dasar diniyah.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h3 class="text-primary text-xl font-bold">
                    Madrasah Wustho
                </h3>
                <p class="text-gray-500 mt-2">
                    Pendidikan menengah diniyah.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h3 class="text-primary text-xl font-bold">
                    Madrasah Ulya
                </h3>
                <p class="text-gray-500 mt-2">
                    Pendidikan lanjutan diniyah.
                </p>
            </div>

        </div>

    </section>

    <!-- PROFIL -->
    <section id="profil" class="max-w-7xl mx-auto px-4 py-20">

        <div class="bg-white rounded-3xl shadow-lg p-8 md:p-10">

            <h3 class="text-3xl font-bold text-primary mb-4">
                Profil Sistem
            </h3>

            <p class="text-gray-600 leading-relaxed">

                Sistem Informasi Kedunglo Wahidiyah merupakan platform
                digital yang digunakan untuk mengelola seluruh data
                pendidikan, siswa, kelas, asrama, akademik, dan
                administrasi secara terpusat.

            </p>

        </div>

    </section>

    <!-- JENJANG -->
    <section id="jenjang" class="bg-white py-20">

        <div class="max-w-7xl mx-auto px-4">

            <h3 class="text-3xl font-bold text-center text-primary mb-12">
                Jenjang Pendidikan
            </h3>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="border rounded-3xl p-8 hover:shadow-xl transition">
                    <h4 class="font-bold text-xl text-primary">
                        Madrasah Ula
                    </h4>
                    <p class="text-gray-500 mt-3">
                        Jenjang pendidikan dasar.
                    </p>
                </div>

                <div class="border rounded-3xl p-8 hover:shadow-xl transition">
                    <h4 class="font-bold text-xl text-primary">
                        Madrasah Wustho
                    </h4>
                    <p class="text-gray-500 mt-3">
                        Jenjang pendidikan menengah.
                    </p>
                </div>

                <div class="border rounded-3xl p-8 hover:shadow-xl transition">
                    <h4 class="font-bold text-xl text-primary">
                        Madrasah Ulya
                    </h4>
                    <p class="text-gray-500 mt-3">
                        Jenjang pendidikan lanjutan.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <!-- CEK NIMW -->
    <section id="nimw" class="py-20">

        <div class="max-w-2xl mx-auto px-4">

            <div class="bg-white rounded-3xl shadow-xl p-8">

                <h3 class="text-2xl font-bold text-center text-primary">
                    Cek NIMW Siswa
                </h3>

                <p class="text-center text-gray-500 mt-2">
                    Masukkan Nomor Induk Murid Wahidiyah
                </p>

                <form action="/nism-siswa" method="GET" class="mt-6">

                    <div class="flex flex-col md:flex-row gap-3">

                        <input
                            type="text"
                            name="cari"
                            value="{{ request('cari') }}"
                            placeholder="Masukkan NIMW..."
                            class="flex-1 border rounded-xl p-4 focus:ring-2 focus:ring-green-500 outline-none">

                        <button
                            type="submit"
                            class="bg-primary hover:bg-green-800 text-white px-8 rounded-xl">

                            Cari

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- HASIL -->
        @if(isset($dataNIS))

        <div class="max-w-4xl mx-auto px-4 mt-10">

            @if($dataNIS->count() > 0)

            <div class="space-y-4">

                @foreach($dataNIS as $detail)

                <div class="bg-white rounded-3xl shadow-lg p-6 border">

                    <h4 class="font-bold text-lg text-primary mb-4">
                        Data Siswa
                    </h4>

                    <div class="grid md:grid-cols-2 gap-4 text-sm">

                        <div>
                            <span class="text-gray-500">NIMW</span>
                            <p class="font-semibold">
                                {{ $detail->NisTerakhir->nis ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Nama</span>
                            <p class="font-semibold">
                                {{ $detail->nama_siswa }}
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Kelas</span>
                            <p>
                                {{ $detail->kelasTerakhir->KelasMi->nama_kelas ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Asrama</span>
                            <p>
                                {{ $detail->asramaTerkhir->asramaSiswa->asrama->nama_asrama ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            @else

            <div class="text-center text-red-500 mt-8">
                Data siswa tidak ditemukan.
            </div>

            @endif

        </div>

        @endif

    </section>

    <!-- FOOTER -->
    <footer class="bg-green-900 text-white">

        <div class="max-w-7xl mx-auto px-4 py-8 text-center">

            <img src="{{ asset('asset/images/logo.png') }}"
                class="w-12 mx-auto mb-3">

            <h4 class="font-semibold">
                Kedunglo Wahidiyah
            </h4>

            <p class="text-sm text-green-200 mt-2">
                Sistem Informasi Pendidikan Terpadu
            </p>

            <div class="border-t border-green-700 mt-6 pt-4 text-xs text-green-300">
                © {{ date('Y') }} Kedunglo Wahidiyah. All Rights Reserved.
            </div>

        </div>

    </footer>

</body>

</html>