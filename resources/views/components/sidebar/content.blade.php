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
    <x-sidebar.link title=" Manajemen User" href="/manajemen-user" :isActive="request()->routeIs('admin')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Data Siswa" href="/siswa" :isActive="request()->routeIs('siswa')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Data Asrama" href="/asramasiswa" :isActive="request()->routeIs('asramasiswa')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Data Kelas" href="/kelas_mi" :isActive="request()->routeIs('kelas_mi')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Data Guru" href="/guru" :isActive="request()->routeIs('guru')">
        <x-slot name="icon">
            <x-icons.academi class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Presensi" href="/sesikelas" :isActive="request()->routeIs('sesikelas')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>


    <x-sidebar.link title="Data Nilai" href="/nilaimapel" :isActive="request()->routeIs('nilaimapel')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Daftar-Seleksi" href="/daftar-seleksi" :isActive="request()->routeIs('daftar-seleksi')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Data Lulusan" href="/lulusan" :isActive="request()->routeIs('lulusan')">
        <x-slot name="icon">
            <x-icons.academi class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Pengaturan" href="/pengaturan" :isActive="request()->routeIs('pengaturan')">
        <x-slot name="icon">
            <x-icons.setting class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">Menu Pendukung</div>
    <x-sidebar.dropdown title="BLANGKO" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" BLANGKO SAP" href="{{ route('sap') }}" :active="request()->routeIs('sap')" />
        <x-sidebar.sublink title="BLANGKO PRESENSI" href="{{ route('absensikelas/blanko') }}" :active="request()->routeIs('absensikelas/blanko')" />

    </x-sidebar.dropdown>
    <x-sidebar.dropdown title="LAPORAN" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink title=" Laporan Harian" href="{{ route('absensikelas/rekap-per-hari') }}" :active="request()->routeIs('absensikelas/rekap-per-hari')" />
        <x-sidebar.sublink title="Laporan Bulanan" href="{{ route('absensikelas/rekap-per-bulan') }}" :active="request()->routeIs('absensikelas/rekap-per-bulan')" />
        <x-sidebar.sublink title="Laporan Semester" href="{{ route('absensikelas/rekap-semester') }}" :active="request()->routeIs('absensikelas/rekap-semester')" />
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
    @role('siswa')
    <x-sidebar.link title="Profil" href="/user" :isActive="request()->routeIs('user')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="KHS" href="#" :isActive="request()->routeIs('nilai')">
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
    @endrole
    @role('guru')
    <x-sidebar.link title="Nilai Akhir" href="/nilaiperguru" :isActive="request()->routeIs('guru')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
</x-perfect-scrollbar>