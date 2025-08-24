<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Dosen') - SIMANTAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .stat-card.warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        }
        .stat-card.danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="p-3 text-center">
                        <h5><i class="fas fa-chalkboard-teacher me-2"></i>Dosen Panel</h5>
                        <small>SIMANTAP</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('lecturer.dashboard') ? 'active' : '' }}" href="{{ route('lecturer.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('lecturer.submissions.*') ? 'active' : '' }}" href="{{ route('lecturer.submissions.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Pengajuan
                        </a>
                        <a class="nav-link {{ request()->routeIs('lecturer.tasks') ? 'active' : '' }}" href="{{ route('lecturer.tasks') }}">
                            <i class="fas fa-tasks me-2"></i>Tugas Dosen
                        </a>
                        <a class="nav-link {{ request()->routeIs('lecturer.status') ? 'active' : '' }}" href="{{ route('lecturer.status') }}">
                            <i class="fas fa-chart-bar me-2"></i>Status Pengajuan
                        </a>
                        <hr class="my-3">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-users me-2"></i>Mode Mahasiswa
                        </a>
                        <a class="nav-link" href="{{ route('admin.login') }}">
                            <i class="fas fa-user-shield me-2"></i>Mode Admin
                        </a>
                        <form method="POST" action="{{ route('lecturer.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <div class="main-content">
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <span class="navbar-brand">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                {{ Auth::guard('lecturer')->user()->name }}
                                <small class="text-muted">({{ Auth::guard('lecturer')->user()->position }})</small>
                            </span>
                            <div class="navbar-nav ms-auto">
                                <span class="navbar-text">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ now()->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </nav>

                    <!-- Page Content -->
                    <div class="p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
