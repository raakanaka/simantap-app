@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo-simantap-small.png') }}" alt="SIMANTAP Logo" class="w-6 h-6 object-contain">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SIMANTAP</h2>
                    <p class="text-sm text-gray-600">Admin Panel</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-list w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.students') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                    <span>Verifikasi Mahasiswa</span>
                </a>
                <a href="{{ route('admin.lecturers') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengolahan Akun</span>
                </a>
                <a href="{{ route('admin.study-programs') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Program Studi</span>
                </a>
                <a href="{{ route('admin.exam-types') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-clipboard-list w-5 h-5 mr-3"></i>
                    <span>Jenis Ujian</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span>Pengaturan Akun</span>
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
                <p class="text-gray-600">Selamat datang di sistem SIMANTAP</p>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            <!-- Tab Navigation -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex flex-wrap space-x-2 sm:space-x-8">
                        <button onclick="showTab('overview')" id="overview-tab" class="tab-button active py-2 px-3 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap">
                            <i class="fas fa-chart-pie mr-2"></i>Overview
                        </button>
                        <button onclick="showTab('students')" id="students-tab" class="tab-button py-2 px-3 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-users mr-2"></i>Mahasiswa
                        </button>
                        <button onclick="showTab('lecturers')" id="lecturers-tab" class="tab-button py-2 px-3 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>Dosen
                        </button>
                        <button onclick="showTab('submissions')" id="submissions-tab" class="tab-button py-2 px-3 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-file-alt mr-2"></i>Pengajuan
                        </button>
                        <button onclick="showTab('analytics')" id="analytics-tab" class="tab-button py-2 px-3 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-chart-line mr-2"></i>Analytics
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Overview Tab -->
            <div id="overview-content" class="tab-content">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                    <!-- Total Students -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg" onclick="showTab('students')">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-users text-2xl text-blue-600 pulse-animation"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Mahasiswa</dt>
                                        <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-5 py-3">
                            <div class="text-sm">
                                <span class="text-green-600 font-medium">{{ $stats['verified_students'] }} terverifikasi</span>
                                <span class="text-gray-500"> / </span>
                                <span class="text-red-600 font-medium">{{ $stats['unverified_students'] }} belum</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Lecturers -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg" onclick="showTab('lecturers')">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chalkboard-teacher text-2xl text-green-600 pulse-animation"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Dosen</dt>
                                        <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_lecturers'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-green-50 to-green-100 px-5 py-3">
                            <div class="text-sm">
                                <span class="text-green-600 font-medium">{{ $stats['active_lecturers'] }} aktif</span>
                                <span class="text-gray-500"> / </span>
                                <span class="text-red-600 font-medium">{{ $stats['inactive_lecturers'] }} tidak aktif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Submissions -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg" onclick="showTab('submissions')">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt text-2xl text-purple-600 pulse-animation"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pengajuan</dt>
                                        <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_submissions'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-5 py-3">
                            <div class="text-sm">
                                <span class="text-yellow-600 font-medium">{{ $stats['pending_submissions'] }} menunggu</span>
                                <span class="text-gray-500"> / </span>
                                <span class="text-green-600 font-medium">{{ $stats['approved_submissions'] }} diterima</span>
                            </div>
                        </div>
                    </div>

                    <!-- Study Programs -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg" onclick="window.location.href='{{ route('admin.study-programs') }}'">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-2xl text-indigo-600 pulse-animation"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Program Studi</dt>
                                        <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_study_programs'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-5 py-3">
                            <div class="text-sm">
                                <span class="text-green-600 font-medium">{{ $stats['active_study_programs'] }} aktif</span>
                                <span class="text-gray-500"> / </span>
                                <span class="text-red-600 font-medium">{{ $stats['inactive_study_programs'] }} tidak aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <a href="{{ route('admin.submissions') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-blue-900">Kelola Pengajuan</div>
                                    <div class="text-sm text-blue-700">Verifikasi pengajuan ujian</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.students') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                                <i class="fas fa-user-check text-green-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-green-900">Verifikasi Mahasiswa</div>
                                    <div class="text-sm text-green-700">Aktifkan akun mahasiswa</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.lecturers') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                                <i class="fas fa-users text-purple-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-purple-900">Kelola Dosen</div>
                                    <div class="text-sm text-purple-700">Edit data dosen</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.study-programs') }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-200">
                                <i class="fas fa-graduation-cap text-indigo-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-indigo-900">Program Studi</div>
                                    <div class="text-sm text-indigo-700">Kelola program studi</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Tab -->
            <div id="students-content" class="tab-content hidden">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Data Mahasiswa Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentStudents as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->nim }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->study_program }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->is_verified)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Terverifikasi</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data mahasiswa</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Lecturers Tab -->
            <div id="lecturers-content" class="tab-content hidden">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Data Dosen Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentLecturers as $lecturer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $lecturer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lecturer->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($lecturer->studyProgram)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $lecturer->studyProgram->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($lecturer->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lecturer->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data dosen</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Submissions Tab -->
            <div id="submissions-content" class="tab-content hidden">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pengajuan Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Ujian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentSubmissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $submission->student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->examType->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($submission->status === 'menunggu_verifikasi')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                        @elseif($submission->status === 'berkas_diterima')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Diterima</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pengajuan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div id="analytics-content" class="tab-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Monthly Submissions Chart -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Pengajuan Bulanan</h3>
                        </div>
                        <div class="p-6">
                            <canvas id="monthlyChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Status Distribution -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Distribusi Status Pengajuan</h3>
                        </div>
                        <div class="p-6">
                            <canvas id="statusChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@push('styles')
<style>
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    
    .tab-button {
        transition: all 0.2s ease;
        border-radius: 6px;
    }
    
    .tab-button:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .tab-button.active {
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .stat-card {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .sidebar-item {
        transition: all 0.2s ease;
    }
    
    .sidebar-item:hover {
        transform: translateX(2px);
    }
    
    /* Responsive improvements */
    @media (max-width: 640px) {
        .tab-button {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .stat-card {
            padding: 1rem;
        }
        
        .stat-card .p-5 {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tab functionality
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        const targetContent = document.getElementById(tabName + '-content');
        if (targetContent) {
            targetContent.classList.add('active');
        }
        
        // Add active class to selected tab
        const activeTab = document.getElementById(tabName + '-tab');
        if (activeTab) {
            activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }
    }

    // Initialize charts when analytics tab is shown
    let monthlyChart = null;
    let statusChart = null;

    function initCharts() {
        if (monthlyChart || statusChart) return; // Already initialized

        // Monthly Submissions Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlySubmissions, 'month')) !!},
                datasets: [{
                    label: 'Pengajuan',
                    data: {!! json_encode(array_column($monthlySubmissions, 'count')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu Verifikasi', 'Diterima', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $stats['pending_submissions'] }},
                        {{ $stats['approved_submissions'] }},
                        {{ $stats['rejected_submissions'] }}
                    ],
                    backgroundColor: [
                        'rgb(251, 191, 36)',
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Initialize charts when analytics tab is clicked
    document.getElementById('analytics-tab').addEventListener('click', function() {
        setTimeout(initCharts, 100);
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize overview tab as active
        showTab('overview');
        
        // Add keyboard navigation for tabs
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                switch(e.key) {
                    case '1':
                        e.preventDefault();
                        showTab('overview');
                        break;
                    case '2':
                        e.preventDefault();
                        showTab('students');
                        break;
                    case '3':
                        e.preventDefault();
                        showTab('lecturers');
                        break;
                    case '4':
                        e.preventDefault();
                        showTab('submissions');
                        break;
                    case '5':
                        e.preventDefault();
                        showTab('analytics');
                        break;
                }
            }
        });
    });
</script>
@endpush
@endsection