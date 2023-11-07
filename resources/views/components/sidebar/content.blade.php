<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-0 px-2">
    @role('super admin')
    <x-sidebar.link title="Dashboard" href="/dashboard" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
    @role('pengurus')
    <x-sidebar.link title="Dashboard" href="/dashboard" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
    @role('siswa')
    <x-sidebar.link title="Dashboard" href="/userdashboard" :isActive="request()->routeIs('userdashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
    @role('guru')
    <x-sidebar.link title="Dashboard" href="/gurudashboard" :isActive="request()->routeIs('gurudashboard')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
    <!-- <x-sidebar.dropdown title="Buttons" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Text button" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" />
        <x-sidebar.sublink title="Icon button" href="{{ route('buttons.icon') }}" :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}" :active="request()->routeIs('buttons.text-icon')" />
    </x-sidebar.dropdown> -->

    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">Menu Utama</div>

    <!-- @php
    $links = array_fill(0, 2, '');
    @endphp

    @foreach ($links as $index => $link)
    <x-sidebar.link title="Dummy link {{ $index + 1 }}" href="#" />
    @endforeach -->
    @role('super admin')
    <x-sidebar.link title=" Manajemen User" class=" uppercase" href="/manajemen-user" :isActive="request()->routeIs('admin')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Data Perangkat" class=" uppercase" href="/data-perangkat" :isActive="request()->routeIs('data-perangkat')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.dropdown title="KESISWAAN" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-icons.user-academi class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" Data Siswa" href="{{ route('siswa') }}" :active="request()->routeIs('siswa')" />
        <x-sidebar.sublink title="Data Asrama" href="{{ route('asramasiswa') }}" :active="request()->routeIs('asramasiswa')" />
        <x-sidebar.sublink title=" Data Kelas" href="{{ route('kelas_mi') }}" :active="request()->routeIs('kelas_mi')" />

    </x-sidebar.dropdown>

    <x-sidebar.dropdown class=" sm:uppercase capitalize" title="KURIKULUM" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-icons.academi class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" Mata Pelajaran" href="{{ route('mapel') }}" :active="request()->routeIs('mapel')" />
        <x-sidebar.sublink title=" Data Guru" href="{{ route('guru') }}" :active="request()->routeIs('guru')" />
        <x-sidebar.sublink title=" Jadwal" href="{{ route('Daftar-Jadwal') }}" :active="request()->routeIs('Daftar-Jadwal')" />
        <x-sidebar.sublink title="Data Nilai" href="{{ route('nilaimapel') }}" :active="request()->routeIs('nilaimapel')" />
        <x-sidebar.sublink title="Daftar Seleksi" href="{{ route('daftar-seleksi') }}" :active="request()->routeIs('daftar-seleksi')" />
        <x-sidebar.sublink title=" Lulusan" href="{{ route('lulusan') }}" :active="request()->routeIs('lulusan')" />
        <x-sidebar.sublink title="Rapor" href="{{ route('raportkelas') }}" :active="request()->routeIs('raportkelas')" />
    </x-sidebar.dropdown>
    <x-sidebar.dropdown title="PRESENSI" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-icons.list-academi class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" Perangkat" href="{{ route('sesi-perangkat') }}" :active="request()->routeIs('sesi-perangkat')" />
        <x-sidebar.sublink title=" Guru" href="{{ route('sesi-presensi-guru') }}" :active="request()->routeIs('sesi-presensi-guru')" />
        <x-sidebar.sublink title=" Siswa" href="{{ route('sesikelas') }}" :active="request()->routeIs('sesikelas')" />
        <x-sidebar.sublink title=" Asrama" href="{{ route('sesiasrama') }}" :active="request()->routeIs('sesiasrama')" />
        <x-sidebar.sublink title=" QrCode" href="{{ route('Qr-Scan') }}" :active="request()->routeIs('Qr-Scan')" />
    </x-sidebar.dropdown>
    <x-sidebar.link class=" uppercase" title="Pengaturan" href="/pengaturan" :isActive="request()->routeIs('pengaturan')">
        <x-slot name="icon">
            <x-icons.setting class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">Menu Pendukung</div>
    <x-sidebar.dropdown title="BLANGKO" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" SAP" href="{{ route('sap') }}" :active="request()->routeIs('sap')" />
        <x-sidebar.sublink title=" LAP " href="{{ route('blankoHarian') }}" :active="request()->routeIs('blankoHarian')" />
        <x-sidebar.sublink title="Presensi" href="{{ route('absensikelas/blanko') }}" :active="request()->routeIs('absensikelas/blanko')" />
        <x-sidebar.sublink title="Pernyataan" href="{{ route('blanko-pernyataan') }}" :active="request()->routeIs('blanko-pernyataan')" />
    </x-sidebar.dropdown>
    <x-sidebar.dropdown title="LAPORAN" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" Laporan Harian" href="{{ route('absensikelas/rekap-per-hari') }}" :active="request()->routeIs('absensikelas/rekap-per-hari')" />
        <x-sidebar.sublink title="Laporan Bulanan" href="{{ route('absensikelas/rekap-per-bulan') }}" :active="request()->routeIs('absensikelas/rekap-per-bulan')" />
        <x-sidebar.sublink title="Laporan Semester" href="{{ route('absensikelas/rekap-semester') }}" :active="request()->routeIs('absensikelas/rekap-semester')" />
        <x-sidebar.sublink title="Laporan Kehadiran" href="{{ route('Laporan-Kehadiran') }}" :active="request()->routeIs('Laporan-Kehadiran')" />
    </x-sidebar.dropdown>





    @endrole
    @role('pengurus')
    <x-sidebar.link title="Data Santri" href="/siswa" :isActive="request()->routeIs('siswa')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Data Asrama" href="/asrama" :isActive="request()->routeIs('asrama')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Data Asrama Santri" href="/asramasiswa" :isActive="request()->routeIs('asramasiswa')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Presensi Harian" href="/sesiasrama" :isActive="request()->routeIs('sesiasrama')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Kegiatan" href="/kegiatan" :isActive="request()->routeIs('kegiatan')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">Menu Pendukung</div>
    <x-sidebar.link title="Rekap Absen Harian" href="/absensikelas/rekap-per-hari" :isActive="request()->routeIs('rekap-per-hari')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Rekap Absen Bulanan" href="/absensikelas/rekap-per-bulan" :isActive="request()->routeIs('rekap-per-bulan')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Rekap Harian Jama'ah" href="/rekap-harian" :isActive="request()->routeIs('rekap-harian')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    @endrole

    @role('guru')
    <x-sidebar.link title="Nilai Akhir" href="/nilaiperguru" :isActive="request()->routeIs('guru')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole

    @if(auth()->check())
    @if(auth()->user()->hasRole('siswa'))
    <x-sidebar.link title="Profil" href="/user" :isActive="request()->routeIs('user')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="KHS" href="/nilai" :isActive="request()->routeIs('nilai')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Riwayat Kelas" href="/riwayatkelas" :isActive="request()->routeIs('riwayatkelas')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Riwayat Kehadiran" href="/riwayatkehadiran" :isActive="request()->routeIs('riwayatkehadiran')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    @elseif(auth()->user()->hasRole('ketua asrama'))
    {{-- Konten untuk ketua asrama --}}
    <p>Selamat datang, Ketua Asrama!</p>
    @endif
    @endif

</x-perfect-scrollbar>