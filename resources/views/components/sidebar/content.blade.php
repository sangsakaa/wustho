<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 px-3 py-3 space-y-2 overflow-y-auto">

    {{-- ================= DASHBOARD ================= --}}
    @role('super admin|pengurus')
    <x-sidebar.link title="Dashboard" href="/dashboard" :isActive="request()->is('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="w-5 h-5 text-emerald-600" />
        </x-slot>
    </x-sidebar.link>
    @endrole

    @role('siswa')
    <x-sidebar.link title="Dashboard" href="/userdashboard" :isActive="request()->is('userdashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="w-5 h-5 text-emerald-600" />
        </x-slot>
    </x-sidebar.link>
    @endrole

    @role('guru')
    <x-sidebar.link title="Dashboard" href="/gurudashboard" :isActive="request()->is('gurudashboard')">
        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5 text-emerald-600" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Nilai Per Guru" href="/nilaiperguru" :isActive="request()->is('nilaiperguru')">
        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5 text-emerald-600" />
        </x-slot>
    </x-sidebar.link>
    @endrole


    {{-- ================= SUPER ADMIN ================= --}}
    @role('super admin')

    <div class="pt-4 pb-1 text-[11px] font-bold tracking-widest text-emerald-600 uppercase">
        Menu Utama
    </div>

    {{-- ================= MANAJEMEN ================= --}}
    @php
    $manajemenOpen =
    request()->routeIs('lembaga.*')
    || request()->is('manajemen-user*')
    || request()->is('data-perangkat*');
    @endphp

    <x-sidebar.dropdown
        title="Manajemen"
        :active="$manajemenOpen">

        <x-slot name="icon">
            <x-icons.usercircle class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Lembaga" href="{{ route('lembaga.index') }}" />
            <x-sidebar.sublink title="User" href="/manajemen-user" />
            <x-sidebar.sublink title="Perangkat" href="/data-perangkat" />
        </div>
    </x-sidebar.dropdown>


    {{-- ================= KESISWAAN ================= --}}
    <x-sidebar.dropdown
        title="Kesiswaan"
        :active="request()->is('siswa*') || request()->is('asramasiswa*') || request()->is('kelas_mi*')">

        <x-slot name="icon">
            <x-icons.user-academi class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Calon Siswa" href="{{ route('calon-siswa') }}" />
            <x-sidebar.sublink title="Data Siswa" href="{{ route('siswa.index') }}" />
            <x-sidebar.sublink title="Data Asrama" href="{{ route('asramasiswa') }}" />
            <x-sidebar.sublink title="Data Kelas" href="{{ route('kelas_mi') }}" />
        </div>
    </x-sidebar.dropdown>


    {{-- ================= KURIKULUM ================= --}}
    <x-sidebar.dropdown
        title="Kurikulum"
        :active="request()->is('mapel*') || request()->is('guru*') || request()->is('Daftar-Jadwal*') || request()->is('nilaimapel*') || request()->is('daftar-seleksi*') || request()->is('lulusan*') || request()->is('raportkelas*') || request()->is('peringkat*')">

        <x-slot name="icon">
            <x-icons.academi class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Mata Pelajaran" href="{{ route('mapel.index') }}" />
            <x-sidebar.sublink title="Data Guru" href="{{ route('guru') }}" />
            <x-sidebar.sublink title="Jadwal" href="{{ route('Daftar-Jadwal') }}" />
            <x-sidebar.sublink title="Data Nilai" href="{{ route('nilaimapel') }}" />
            <x-sidebar.sublink title="Nomor Ujian" href="{{ route('daftar-seleksi') }}" />
            <x-sidebar.sublink title="Nomor Ijazah" href="{{ route('lulusan') }}" />
            <x-sidebar.sublink title="Rapor" href="{{ route('raportkelas') }}" />
            <x-sidebar.sublink title="Peringkat" href="{{ route('peringkat') }}" />
            <x-sidebar.sublink title="Validasi Kelulusan" href="{{ route('validasi.kelulusan') }}" />
        </div>
    </x-sidebar.dropdown>


    {{-- ================= PRESENSI ================= --}}
    <x-sidebar.dropdown
        title="Presensi"
        :active="request()->is('sesi*') || request()->is('Qr-Scan*')">

        <x-slot name="icon">
            <x-icons.list-academi class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Perangkat" href="{{ route('sesi-perangkat') }}" />
            <x-sidebar.sublink title="Guru" href="{{ route('sesi-presensi-guru') }}" />
            <x-sidebar.sublink title="Siswa" href="{{ route('sesikelas') }}" />
            <x-sidebar.sublink title="Asrama" href="{{ route('sesiasrama') }}" />
            <x-sidebar.sublink title="QrCode" href="{{ route('qr.index') }}" />
        </div>
    </x-sidebar.dropdown>


    {{-- ================= QR CODE ================= --}}
    <x-sidebar.dropdown
        title="QR Code"
        :active="request()->is('qr*') || request()->is('Qr-Scan*')">

        <x-slot name="icon">
            <x-icons.list-academi class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Scan QR" href="{{ route('qr.scan') }}" />
        </div>
    </x-sidebar.dropdown>


    {{-- ================= PENGATURAN ================= --}}
    @php
    $pengaturanOpen =
    request()->routeIs('periode')
    || request()->routeIs('kalender-pendidikan.*')
    || request()->is('pengaturan*');
    @endphp

    <x-sidebar.dropdown
        title="Pengaturan"
        :active="$pengaturanOpen">

        <x-slot name="icon">
            <x-icons.setting class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Periode" href="{{ route('periode') }}" />
            <x-sidebar.sublink title="Kalender Pendidikan" href="{{ route('kalender-pendidikan.index') }}" />
            <x-sidebar.sublink title="Pengaturan" href="/pengaturan" />
        </div>
    </x-sidebar.dropdown>


    {{-- ================= PENDUKUNG ================= --}}
    <div class="pt-4 pb-1 text-[11px] font-bold tracking-widest text-emerald-600 uppercase">
        Menu Pendukung
    </div>

    <x-sidebar.dropdown
        title="Blanko"
        :active="request()->is('sap*') || request()->is('blankoHarian*') || request()->is('absensikelas/blanko*') || request()->is('blanko-pernyataan*')">

        <x-slot name="icon">
            <x-icons.books class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="SAP" href="{{ route('sap') }}" />
            <x-sidebar.sublink title="LAP" href="{{ route('blankoHarian') }}" />
            <x-sidebar.sublink title="Presensi" href="{{ route('absensikelas/blanko') }}" />
            <x-sidebar.sublink title="Pernyataan" href="{{ route('blanko-pernyataan') }}" />
        </div>
    </x-sidebar.dropdown>


    <x-sidebar.dropdown
        title="Laporan"
        :active="request()->is('absensikelas/rekap-per-hari*') || request()->is('absensikelas/rekap-per-bulan*') || request()->is('absensikelas/rekap-semester*') || request()->is('Laporan-Kehadiran*')">

        <x-slot name="icon">
            <x-icons.books class="w-5 h-5 text-emerald-600" />
        </x-slot>

        <div class="space-y-1">
            <x-sidebar.sublink title="Laporan Harian" href="{{ route('absensikelas/rekap-per-hari') }}" />
            <x-sidebar.sublink title="Laporan Bulanan" href="{{ route('absensikelas/rekap-per-bulan') }}" />
            <x-sidebar.sublink title="Laporan Semester" href="{{ route('absensikelas/rekap-semester') }}" />
            <x-sidebar.sublink title="Laporan Kehadiran" href="{{ route('Laporan-Kehadiran') }}" />
        </div>
    </x-sidebar.dropdown>

    @endrole

</x-perfect-scrollbar>