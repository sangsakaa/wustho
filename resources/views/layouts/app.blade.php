<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SMEDI @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('asset/images/logo.png') }}" type="image/x-icon">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased overflow-hidden">
    <div x-data="mainState"
        :class="{ dark: isDarkMode }"
        @resize.window="handleWindowResize"
        class="h-screen flex"
        x-cloak>

        <!-- Sidebar -->
        <x-sidebar.sidebar />

        <!-- Page Wrapper -->
        <div class="flex flex-col flex-1 transition-all duration-150"
            :class="{ 
                'lg:ml-64': isSidebarOpen,
                'md:ml-16': !isSidebarOpen
             }">

            <!-- Navbar -->
            <x-navbar />

            <!-- Header -->

            <header class=" p-16 dark:bg-dark-bg px-4 py-2 shadow-sm">
                <h1 class="text-sm font-semibold text-gray-700 dark:text-purple-400">
                    Dashboard {{ $header }}
                </h1>
            </header>


            <!-- Content (SCROLL AREA) -->
            <main class="flex-1  overflow-y-auto bg-gray-100 dark:bg-dark-bg ">
                <div class=" dark:bg-gray-800 rounded shadow-sm ">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <x-footer />
        </div>
    </div>

    @livewireScripts
</body>

</html>