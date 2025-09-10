<!-- Student Sidebar Component -->
<div class="w-64 bg-white shadow-lg">
    <div class="p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <img src="{{ asset('images/logo-simantap-small.png') }}" alt="SIMANTAP Logo" class="w-6 h-6 object-contain">
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">SIMANTAP</h2>
                <p class="text-sm text-gray-600">Mahasiswa</p>
            </div>
        </div>
    </div>
    
    <nav class="mt-6">
        <div class="px-4 space-y-2">
            <a href="{{ route('student.dashboard') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('student.exam-types') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('student.exam-types') ? 'bg-blue-50 text-blue-700' : '' }}">
                <i class="fas fa-list w-5 h-5 mr-3"></i>
                <span>Jenis Ujian</span>
            </a>
            <a href="{{ route('student.my-submissions') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 {{ request()->routeIs('student.my-submissions') ? 'bg-blue-50 text-blue-700' : '' }}">
                <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                <span>Pengajuan Saya</span>
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
