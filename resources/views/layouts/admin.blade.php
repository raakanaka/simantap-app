<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sistem Informasi Manajemen Terintegrasi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-50">
        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    <img src="{{ asset('images/logo-simantap-small.svg') }}" alt="SIMANTAP" class="h-8 w-8">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SIMANTAP</h1>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.submissions') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.submissions') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Daftar Pengajuan</span>
                    </a>
                    <a href="{{ route('admin.study-programs') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.study-programs') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Program Studi</span>
                    </a>
                    <a href="{{ route('admin.lecturers') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.lecturers') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Pengolahan Akun</span>
                    </a>
                    <a href="{{ route('admin.students') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.students') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Data Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.reports') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('admin.settings') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-900">@yield('title', 'Admin Dashboard')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            Selamat datang, Admin
                        </div>
                        <a href="{{ route('auth.logout') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
