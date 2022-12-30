<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'SMEDI') }}</title> -->
    <title>SMEDI @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
        <div class="min-h-screen text-gray-900 bg-gray-100  dark:bg-dark-bg dark:text-gray-200">
            <!-- Sidebar -->
            <x-sidebar.sidebar />
            <!-- Page Wrapper -->
            <div class="flex fixed-top flex-col min-h-screen" :class="{ 
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }" style="transition-property: margin; transition-duration: 150ms;">
                <!-- Navbar -->
                <x-navbar />

                <!-- Page Heading -->
                <header>
                    <div class=" dark:bg-dark-bg dark:text-purple-600 bg-white mt-2 mb-2 p-2 sm:p-2">
                        Dashboard{{ $header }}
                    </div>
                </header>

                <!-- Page Content -->
                <main class="  flex-1">
                    {{ $slot }}
                </main>
                <!-- Page Footer -->
                <x-footer />
            </div>
        </div>
    </div>

</body>

</html>