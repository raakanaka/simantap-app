@extends('layouts.app')

@section('title', 'Registrasi Mahasiswa')

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
                    <p class="text-sm text-gray-600">Admin</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-list w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.registrations') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-user-plus w-5 h-5 mr-3"></i>
                    <span>Registrasi Mahasiswa</span>
                </a>
                <a href="{{ route('admin.students') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                    <span>Verifikasi Mahasiswa</span>
                </a>
                <a href="{{ route('admin.lecturers') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengolahan Akun</span>
                </a>
                <a href="{{ route('admin.study-programs') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Program Studi</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
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
                <h1 class="text-2xl font-bold text-gray-900">Registrasi Mahasiswa</h1>
                <p class="text-gray-600">Kelola registrasi mahasiswa baru</p>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
            @endif

            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Registrasi Mahasiswa</h2>
                    <p class="text-sm text-gray-600">Total: {{ $students->count() }} mahasiswa</p>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fakultas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Registrasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($students as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $student->nim }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->study_program }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->faculty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->semester }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->is_verified)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Belum Diverifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->created_at ? $student->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button onclick="showStudentDetailModal({{ $student->id }}, '{{ $student->nim }}', '{{ $student->name }}', '{{ $student->email }}', '{{ $student->study_program }}', '{{ $student->faculty }}', '{{ $student->semester }}', '{{ $student->phone }}', '{{ $student->address }}', '{{ $student->status }}', '{{ $student->is_verified ? 'true' : 'false' }}', '{{ $student->verified_by }}', '{{ $student->verified_at ? $student->verified_at->format('d/m/Y H:i') : '' }}', '{{ $student->created_at ? $student->created_at->format('d/m/Y H:i') : '' }}')" class="text-blue-600 hover:text-blue-900 text-sm">
                                                <i class="fas fa-eye mr-1"></i>Detail
                                            </button>
                                            @if(!$student->is_verified)
                                                <form action="{{ route('admin.verify-student', $student->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                                        <i class="fas fa-check mr-1"></i>Verifikasi
                                                    </button>
                                                </form>
                                            @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data mahasiswa
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
        </main>

<!-- Student Detail Modal -->
<div id="studentDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Mahasiswa</h3>
                <button onclick="hideStudentDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="block text-sm font-medium text-gray-700">NIM</label>
                    <p id="detailNim" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <p id="detailName" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p id="detailEmail" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <p id="detailStudyProgram" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <p id="detailFaculty" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Semester</label>
                    <p id="detailSemester" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <p id="detailPhone" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <p id="detailAddress" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Status Verifikasi</label>
                    <p id="detailVerificationStatus" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Diverifikasi Oleh</label>
                    <p id="detailVerifiedBy" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Verifikasi</label>
                    <p id="detailVerifiedAt" class="mt-1 text-sm text-gray-900"></p>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Registrasi</label>
                    <p id="detailRegistrationDate" class="mt-1 text-sm text-gray-900"></p>
            <div class="mt-6 flex justify-end">
                <button onclick="hideStudentDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Tutup
                </button>

@push('scripts')
<script>
    function showStudentDetailModal(id, nim, name, email, studyProgram, faculty, semester, phone, address, status, isVerified, verifiedBy, verifiedAt, registrationDate) {
        document.getElementById('detailNim').textContent = nim;
        document.getElementById('detailName').textContent = name;
        document.getElementById('detailEmail').textContent = email;
        document.getElementById('detailStudyProgram').textContent = studyProgram;
        document.getElementById('detailFaculty').textContent = faculty;
        document.getElementById('detailSemester').textContent = semester;
        document.getElementById('detailPhone').textContent = phone || '-';
        document.getElementById('detailAddress').textContent = address || '-';
        document.getElementById('detailVerificationStatus').textContent = isVerified === 'true' ? 'Terverifikasi' : 'Belum Diverifikasi';
        document.getElementById('detailVerifiedBy').textContent = verifiedBy || '-';
        document.getElementById('detailVerifiedAt').textContent = verifiedAt || '-';
        document.getElementById('detailRegistrationDate').textContent = registrationDate || '-';
        document.getElementById('studentDetailModal').classList.remove('hidden');
    }

    function hideStudentDetailModal() {
        document.getElementById('studentDetailModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('studentDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideStudentDetailModal();
        }
    });
</script>
@endpush
@endsection
