<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 px-3 py-2 space-y-1">

    {{-- DASHBOARD --}}
    @role('super admin')

    <x-sidebar.link title="Dashboard" href="/dashboard" :isActive="request()->is('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>
    @endrole

    @role('pengurus')
    <x-sidebar.link title="Dashboard" href="/dashboard" :isActive="request()->is('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>
    @endrole

    @role('siswa')
    <x-sidebar.link title="Dashboard" href="/userdashboard" :isActive="request()->is('userdashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>
    @endrole

    @role('guru')
    <x-sidebar.link title="Dashboard" href="/gurudashboard" :isActive="request()->is('gurudashboard')">
        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>
    @endrole


    {{-- SUPER ADMIN --}}
    @role('super admin')

    <div class="pt-4 pb-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
        Menu Utama
    </div>


    <x-sidebar.link
        title="Manajemen Lembaga"
        href="{{ route('lembaga.index') }}"
        :isActive="request()->routeIs('lembaga.*')">
        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Manajemen User"
        href="/manajemen-user"
        :isActive="request()->is('manajemen-user')">
        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Data Perangkat"
        href="/data-perangkat"
        :isActive="request()->is('data-perangkat')">
        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>


    {{-- KESISWAAN --}}
    <x-sidebar.dropdown
        title="KESISWAAN"
        :active="request()->is('siswa*') || request()->is('asramasiswa*') || request()->is('kelas_mi*')">

        <x-slot name="icon">
            <x-icons.user-academi class="w-5 h-5" />
        </x-slot>

        <x-sidebar.sublink title="Data Siswa"
            href="{{ route('siswa.index') }}"
            :active="request()->routeIs('siswa.index')" />

        <x-sidebar.sublink title="Data Asrama"
            href="{{ route('asramasiswa') }}"
            :active="request()->routeIs('asramasiswa')" />

        <x-sidebar.sublink title="Data Kelas"
            href="{{ route('kelas_mi') }}"
            :active="request()->routeIs('kelas_mi')" />
    </x-sidebar.dropdown>


    {{-- KURIKULUM --}}
    <x-sidebar.dropdown
        title="KURIKULUM"
        :active="
            request()->is('mapel*') ||
            request()->is('guru*') ||
            request()->is('Daftar-Jadwal*') ||
            request()->is('nilaimapel*') ||
            request()->is('daftar-seleksi*') ||
            request()->is('lulusan*') ||
            request()->is('raportkelas*') ||
            request()->is('peringkat*')
        ">

        <x-slot name="icon">
            <x-icons.academi class="w-5 h-5" />
        </x-slot>

        <x-sidebar.sublink title="Mata Pelajaran" href="{{ route('mapel.index') }}" :active="request()->routeIs('mapel.index')" />
        <x-sidebar.sublink title="Data Guru" href="{{ route('guru') }}" :active="request()->routeIs('guru')" />
        <x-sidebar.sublink title="Jadwal" href="{{ route('Daftar-Jadwal') }}" :active="request()->routeIs('Daftar-Jadwal')" />
        <x-sidebar.sublink title="Data Nilai" href="{{ route('nilaimapel') }}" :active="request()->routeIs('nilaimapel')" />
        <x-sidebar.sublink title="Nomor Ujian" href="{{ route('daftar-seleksi') }}" :active="request()->routeIs('daftar-seleksi')" />
        <x-sidebar.sublink title="Nomor Ijazah" href="{{ route('lulusan') }}" :active="request()->routeIs('lulusan')" />
        <x-sidebar.sublink title="Rapor" href="{{ route('raportkelas') }}" :active="request()->routeIs('raportkelas')" />
        <x-sidebar.sublink title="Peringkat" href="{{ route('peringkat') }}" :active="request()->routeIs('peringkat')" />
        <x-sidebar.sublink title="Validasi Kelulusan" href="{{ route('validasi.kelulusan') }}" :active="request()->routeIs('validasi.kelulusan')" />
    </x-sidebar.dropdown>


    {{-- PRESENSI --}}
    <x-sidebar.dropdown
        title="PRESENSI"
        :active="request()->is('sesi*') || request()->is('Qr-Scan*')">

        <x-slot name="icon">
            <x-icons.list-academi class="w-5 h-5" />
        </x-slot>

        <x-sidebar.sublink title="Perangkat" href="{{ route('sesi-perangkat') }}" :active="request()->routeIs('sesi-perangkat')" />
        <x-sidebar.sublink title="Guru" href="{{ route('sesi-presensi-guru') }}" :active="request()->routeIs('sesi-presensi-guru')" />
        <x-sidebar.sublink title="Siswa" href="{{ route('sesikelas') }}" :active="request()->routeIs('sesikelas')" />
        <x-sidebar.sublink title="Asrama" href="{{ route('sesiasrama') }}" :active="request()->routeIs('sesiasrama')" />
        <x-sidebar.sublink title="QrCode" href="{{ route('qr.index') }}" :active="request()->routeIs('qr.index')" />
    </x-sidebar.dropdown>
    <x-sidebar.dropdown
        title="QRcode"
        :active="request()->is('qr*') || request()->is('Qr-Scan*')">

        <x-slot name="icon">
            <x-icons.list-academi class="w-5 h-5" />
        </x-slot>


        <x-sidebar.sublink title="QrCode" href="{{ route('qr.scan') }}" :active="request()->routeIs('Qr-Scan')" />
    </x-sidebar.dropdown>


    <x-sidebar.link title="Pengaturan"
        href="/pengaturan"
        :isActive="request()->is('pengaturan')">
        <x-slot name="icon">
            <x-icons.setting class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>


    <div class="pt-4 pb-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
        Menu Pendukung
    </div>


    {{-- BLANGKO --}}
    <x-sidebar.dropdown
        title="BLANGKO"
        :active="
            request()->is('sap*') ||
            request()->is('blankoHarian*') ||
            request()->is('absensikelas/blanko*') ||
            request()->is('blanko-pernyataan*')
        ">

        <x-slot name="icon">
            <x-icons.books class="w-5 h-5" />
        </x-slot>

        <x-sidebar.sublink title="SAP" href="{{ route('sap') }}" :active="request()->routeIs('sap')" />
        <x-sidebar.sublink title="LAP" href="{{ route('blankoHarian') }}" :active="request()->routeIs('blankoHarian')" />
        <x-sidebar.sublink title="Presensi" href="{{ route('absensikelas/blanko') }}" :active="request()->routeIs('absensikelas/blanko')" />
        <x-sidebar.sublink title="Pernyataan" href="{{ route('blanko-pernyataan') }}" :active="request()->routeIs('blanko-pernyataan')" />
    </x-sidebar.dropdown>


    {{-- LAPORAN --}}
    <x-sidebar.dropdown
        title="LAPORAN"
        :active="
            request()->is('absensikelas/rekap-per-hari*') ||
            request()->is('absensikelas/rekap-per-bulan*') ||
            request()->is('absensikelas/rekap-semester*') ||
            request()->is('Laporan-Kehadiran*')
        ">

        <x-slot name="icon">
            <x-icons.books class="w-5 h-5" />
        </x-slot>

        <x-sidebar.sublink title="Laporan Harian"
            href="{{ route('absensikelas/rekap-per-hari') }}"
            :active="request()->routeIs('absensikelas/rekap-per-hari')" />

        <x-sidebar.sublink title="Laporan Bulanan"
            href="{{ route('absensikelas/rekap-per-bulan') }}"
            :active="request()->routeIs('absensikelas/rekap-per-bulan')" />

        <x-sidebar.sublink title="Laporan Semester"
            href="{{ route('absensikelas/rekap-semester') }}"
            :active="request()->routeIs('absensikelas/rekap-semester')" />

        <x-sidebar.sublink title="Laporan Kehadiran"
            href="{{ route('Laporan-Kehadiran') }}"
            :active="request()->routeIs('Laporan-Kehadiran')" />
    </x-sidebar.dropdown>

    @endrole

</x-perfect-scrollbar>