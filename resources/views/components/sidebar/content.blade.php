<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">
    @role('super admin')
    <x-sidebar.link title="Dashboard" href="#" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
    @role('siswa')
    <x-sidebar.link title="Dashboard" href="userdashboard" :isActive="request()->routeIs('userdashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
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
    <x-sidebar.link title=" Manajemen User" href="/admin" :isActive="request()->routeIs('admin')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Data Siswa" href="/siswa" :isActive="request()->routeIs('siswa')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title=" Data Guru" href="/guru" :isActive="request()->routeIs('guru')">
        <x-slot name="icon">
            <x-icons.usercircle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title=" Data Kelas" href="/kelas_mi" :isActive="request()->routeIs('kelas_mi')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Data Asrama" href="/asramasiswa" :isActive="request()->routeIs('asramasiswa')">
        <x-slot name="icon">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Data Nilai" href="/nilaimapel" :isActive="request()->routeIs('nilaimapel')">
        <x-slot name="icon">
            <x-icons.books class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link title="Pengaturan" href="/pengaturan" :isActive="request()->routeIs('pengaturan')">
        <x-slot name="icon">
            <x-icons.setting class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endrole
    @role('siswa')
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
    @endrole
</x-perfect-scrollbar>