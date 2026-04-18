<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kedunglo Wahidiyah - Sistem Informasi</title>

    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">

            <div class="flex items-center gap-3">
                <img src="{{ asset('asset/images/logo.png') }}" class="w-10 h-10 rounded-lg">
                <div>
                    <h1 class="font-bold text-lg leading-tight">Kedunglo Wahidiyah</h1>
                    <p class="text-xs text-gray-500">Sistem Informasi Terpadu</p>
                </div>
            </div>

            <nav class="hidden md:flex gap-6 text-sm text-gray-600">
                <a href="#profil" class="hover:text-blue-600">Profil</a>
                <a href="#jenjang" class="hover:text-blue-600">Jenjang</a>
                <a href="#nimw" class="hover:text-blue-600">Cek NIMW</a>
            </nav>

            <a href="{{ route('login') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-xl shadow hover:bg-blue-700 transition">
                Masuk
            </a>

        </div>
    </header>

    <!-- HERO -->
    <section class="relative overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700"></div>

        <div class="relative max-w-6xl mx-auto px-4 py-24 text-center text-white">

            <h2 class="text-4xl md:text-5xl font-bold leading-tight">
                Sistem Informasi <br> Kedunglo Wahidiyah
            </h2>

            <p class="mt-4 text-white/80 max-w-2xl mx-auto">
                Portal digital pendidikan Ula, Wustho, dan Ulya dalam satu sistem terpadu
                untuk mempermudah akses data siswa, akademik, dan informasi pesantren.
            </p>

            <a href="#nimw"
                class="inline-block mt-8 bg-white text-blue-700 font-semibold px-6 py-3 rounded-xl shadow hover:scale-105 transition">
                Cek NIMW Sekarang
            </a>

        </div>
    </section>

    <!-- PROFIL -->
    <section id="profil" class="max-w-6xl mx-auto py-16 px-4">

        <h3 class="text-2xl font-bold mb-6">Profil Singkat</h3>

        <div class="bg-white rounded-2xl shadow p-6 border leading-relaxed text-gray-600">
            Sistem ini merupakan platform digital untuk mengelola data pendidikan di lingkungan
            <b>Kedunglo Wahidiyah</b>, mencakup siswa, jenjang pendidikan, asrama, dan administrasi akademik secara terintegrasi.
        </div>

    </section>

    <!-- JENJANG -->
    <section id="jenjang" class="max-w-6xl mx-auto py-16 px-4">

        <h3 class="text-2xl font-bold mb-6">Jenjang Pendidikan</h3>

        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow border hover:-translate-y-1 transition">
                <h4 class="font-semibold text-lg">Madrasah Ula</h4>
                <p class="text-gray-500 text-sm mt-2">Tingkat dasar pendidikan diniyah.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow border hover:-translate-y-1 transition">
                <h4 class="font-semibold text-lg">Madrasah Wustho</h4>
                <p class="text-gray-500 text-sm mt-2">Tingkat menengah pendidikan diniyah.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow border hover:-translate-y-1 transition">
                <h4 class="font-semibold text-lg">Madrasah Ulya</h4>
                <p class="text-gray-500 text-sm mt-2">Tingkat lanjutan pendidikan diniyah.</p>
            </div>

        </div>
    </section>

    <!-- SEARCH -->
    <section id="nimw" class="py-16 px-4">

        <div class="max-w-xl mx-auto">

            <div class="bg-white rounded-2xl shadow-lg border p-6">

                <h3 class="text-xl font-bold text-center">Cek NIMW Siswa</h3>
                <p class="text-center text-sm text-gray-500 mt-2">
                    Masukkan Nomor Induk Murid
                </p>

                <form action="/nism-siswa" method="GET" class="mt-6 space-y-4">

                    <input type="text"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Contoh: 20220200109"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">

                    <button class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition">
                        Cari Data
                    </button>

                </form>

            </div>
        </div>

        <!-- RESULT -->
        <div class="max-w-3xl mx-auto mt-8 space-y-4">

            @if(isset($dataNIS) && $dataNIS->isEmpty())
            <div class="text-center text-gray-500">
                Data tidak ditemukan
            </div>
            @endif

            @if(isset($dataNIS))
            @foreach($dataNIS as $detail)

            <div class="bg-white rounded-2xl shadow border p-6 hover:shadow-lg transition">

                <div class="grid grid-cols-2 gap-3 text-sm">

                    <span class="text-gray-500">NIMW</span>
                    <span class="font-medium">{{ $detail->NisTerakhir->nis ?? '-' }}</span>

                    <span class="text-gray-500">Nama</span>
                    <span class="font-medium">{{ $detail->nama_siswa }}</span>

                    <span class="text-gray-500">Kelas</span>
                    <span>{{ $detail->kelasTerakhir->KelasMi->nama_kelas ?? '-' }}</span>

                    <span class="text-gray-500">Asrama</span>
                    <span>{{ $detail->asramaTerkhir->asramaSiswa->asrama->nama_asrama ?? '-' }}</span>

                </div>

            </div>

            @endforeach
            @endif

        </div>

    </section>

    <!-- FOOTER -->
    <footer class="text-center text-xs text-gray-500 py-10 border-t bg-white">
        © {{ date('Y') }} Kedunglo Wahidiyah • Sistem Informasi Pendidikan
    </footer>

</body>

</html>