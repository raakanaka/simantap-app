@extends('layouts.app')

@section('title', 'Verifikasi Mahasiswa')

@section('content')
<div class="flex h-screen bg-gray-50">
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
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-list w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.students') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
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
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Verifikasi Mahasiswa</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">Selamat datang, {{ session('user_name') }}</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Data Mahasiswa</h2>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            Total: {{ $students->count() }} mahasiswa
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="showAddStudentModal()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Tambah Mahasiswa
                            </button>
                            <button onclick="filterStudents('all')" id="filterAll" class="px-3 py-1 text-sm rounded-lg bg-blue-100 text-blue-800 border border-blue-200">
                                Semua
                            </button>
                            <button onclick="filterStudents('unverified')" id="filterUnverified" class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-800 border border-gray-200 hover:bg-yellow-100 hover:text-yellow-800 hover:border-yellow-200">
                                Belum Diverifikasi
                            </button>
                            <button onclick="filterStudents('verified')" id="filterVerified" class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-800 border border-gray-200 hover:bg-green-100 hover:text-green-800 hover:border-green-200">
                                Sudah Diverifikasi
                            </button>
                        </div>
                    </div>
                </div>
                
                @if($students->count() === 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-graduate text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada mahasiswa</h3>
                    <p class="text-gray-500">Tidak ada data mahasiswa yang terdaftar.</p>
                </div>
                @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verifikasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $student)
                                <tr class="hover:bg-gray-50 student-row" data-verified="{{ $student->is_verified ? 'true' : 'false' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->nim }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->study_program }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->faculty }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->semester }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->is_verified)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Diverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Belum Diverifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if(!$student->is_verified)
                                            <form action="{{ route('admin.verify-student', $student->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                                    <i class="fas fa-check mr-1"></i>Verifikasi
                                                </button>
                                            </form>
                                            @endif
                                            <button onclick="showStudentDetailModal({{ $student->id }}, '{{ $student->nim }}', '{{ $student->name }}', '{{ $student->email }}', '{{ $student->study_program }}', '{{ $student->faculty }}', '{{ $student->semester }}', '{{ $student->phone }}', '{{ $student->address }}', '{{ $student->status }}', '{{ $student->is_verified ? 'true' : 'false' }}', '{{ $student->verified_by }}', '{{ $student->verified_at ? $student->verified_at->format('d/m/Y H:i') : '' }}', '{{ $student->registration_date ? $student->registration_date->format('d/m/Y H:i') : '' }}')" class="text-blue-600 hover:text-blue-900 text-sm">
                                                <i class="fas fa-eye mr-1"></i>Detail
                                            </button>
                                            <button onclick="showEditStudentModal({{ $student->id }}, '{{ $student->nim }}', '{{ $student->name }}', '{{ $student->email }}', '{{ $student->study_program }}', '{{ $student->faculty }}', '{{ $student->semester }}', '{{ $student->phone }}', '{{ $student->address }}', '{{ $student->status }}', '{{ $student->is_verified ? 'true' : 'false' }}')" class="text-yellow-600 hover:text-yellow-900 text-sm">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <button onclick="showDeleteStudentModal({{ $student->id }}, '{{ $student->name }}', '{{ $student->nim }}')" class="text-red-600 hover:text-red-900 text-sm">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Student Detail Modal -->
<div id="studentDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Mahasiswa</h3>
                <button onclick="hideStudentDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                        <p id="detailNim" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <p id="detailName" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p id="detailEmail" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <p id="detailStudyProgram" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <p id="detailFaculty" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <p id="detailSemester" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <p id="detailPhone" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <p id="detailStatus" class="text-sm text-gray-900"></p>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <p id="detailAddress" class="text-sm text-gray-900"></p>
                </div>
                <div class="border-t pt-4">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Informasi Verifikasi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                            <p id="detailVerificationStatus" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Diverifikasi Oleh</label>
                            <p id="detailVerifiedBy" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Verifikasi</label>
                            <p id="detailVerifiedAt" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Registrasi</label>
                            <p id="detailRegistrationDate" class="text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button onclick="hideStudentDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editStudentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Data Mahasiswa</h3>
                <button onclick="hideEditStudentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editStudentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                            <input type="text" id="editStudentNim" name="nim" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="editStudentName" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="editStudentEmail" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                            <select id="editStudentStudyProgram" name="study_program" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Program Studi</option>
                                @foreach($studyPrograms as $program)
                                    <option value="{{ $program->name }}" data-faculty="{{ $program->faculty }}">{{ $program->name }} ({{ $program->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                            <input type="text" id="editStudentFaculty" name="faculty" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                            <input type="text" id="editStudentSemester" name="semester" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" id="editStudentPhone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea id="editStudentAddress" name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="editStudentStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" id="editStudentIsVerified" name="is_verified" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Mahasiswa Terverifikasi</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="showChangePasswordModal()" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-key mr-2"></i>Ganti Password
                    </button>
                    <div class="flex space-x-2">
                        <button type="button" onclick="hideEditStudentModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Ganti Password Mahasiswa</h3>
                <button onclick="hideChangePasswordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="changePasswordForm" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" id="newPassword" name="new_password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan password baru">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" id="newPasswordConfirmation" name="new_password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Konfirmasi password baru">
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-800">Peringatan</h4>
                                <p class="text-sm text-yellow-700 mt-1">Password harus minimal 6 karakter. Pastikan password baru aman dan mudah diingat oleh mahasiswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="hideChangePasswordModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-key mr-2"></i>Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Student Modal -->
<div id="deleteStudentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus Akun Mahasiswa</h3>
            <p class="text-sm text-gray-500 mb-4">
                Apakah Anda yakin ingin menghapus akun mahasiswa 
                <span id="deleteStudentName" class="font-medium text-gray-900"></span> 
                (<span id="deleteStudentNim" class="font-medium text-gray-900"></span>)? 
                <br><br>
                <span class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan dan akan menghapus:</span>
                <ul class="text-xs text-gray-600 mt-2 ml-4 list-disc">
                    <li>Data profil mahasiswa</li>
                    <li>Semua pengajuan ujian yang terkait</li>
                    <li>Dokumen yang telah diupload</li>
                </ul>
            </p>
            <form id="deleteStudentForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideDeleteStudentModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tambah Mahasiswa Baru</h3>
                <button onclick="hideAddStudentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIM <span class="text-red-500">*</span></label>
                            <input type="text" name="nim" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan NIM">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama lengkap">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan email">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan password">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Konfirmasi password">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi <span class="text-red-500">*</span></label>
                            <select name="study_program" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Program Studi</option>
                                @foreach($studyPrograms as $program)
                                    <option value="{{ $program->name }}" data-faculty="{{ $program->faculty }}">{{ $program->name }} ({{ $program->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas <span class="text-red-500">*</span></label>
                            <input type="text" name="faculty" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Semester <span class="text-red-500">*</span></label>
                            <select name="semester" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Semester</option>
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nomor telepon">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan alamat"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_verified" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Verifikasi langsung</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="hideAddStudentModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Tambah Mahasiswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showAlert(message, type = 'info') {
    const alertColors = {
        success: 'bg-green-50 border-green-200 text-green-800',
        danger: 'bg-red-50 border-red-200 text-red-800',
        warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    const alertHTML = `
        <div class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="border rounded-lg p-4 ${alertColors[type]} shadow-lg" id="alert">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-3"></i>
                        <span class="font-medium">${message}</span>
                    </div>
                    <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', alertHTML);
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) alert.remove();
    }, 5000);
}

@if(session('success'))
showAlert('{{ session('success') }}', 'success');
@endif

@if(session('error'))
showAlert('{{ session('error') }}', 'danger');
@endif

// Student Detail Modal Functions
function showStudentDetailModal(id, nim, name, email, studyProgram, faculty, semester, phone, address, status, isVerified, verifiedBy, verifiedAt, registrationDate) {
    document.getElementById('detailNim').textContent = nim;
    document.getElementById('detailName').textContent = name;
    document.getElementById('detailEmail').textContent = email;
    document.getElementById('detailStudyProgram').textContent = studyProgram;
    document.getElementById('detailFaculty').textContent = faculty;
    document.getElementById('detailSemester').textContent = semester;
    document.getElementById('detailPhone').textContent = phone || '-';
    document.getElementById('detailAddress').textContent = address || '-';
    document.getElementById('detailStatus').textContent = status === 'active' ? 'Aktif' : 'Tidak Aktif';
    
    // Verification info
    document.getElementById('detailVerificationStatus').textContent = isVerified === 'true' ? 'Diverifikasi' : 'Belum Diverifikasi';
    document.getElementById('detailVerifiedBy').textContent = verifiedBy || '-';
    document.getElementById('detailVerifiedAt').textContent = verifiedAt || '-';
    document.getElementById('detailRegistrationDate').textContent = registrationDate || '-';
    
    document.getElementById('studentDetailModal').classList.remove('hidden');
}

function hideStudentDetailModal() {
    document.getElementById('studentDetailModal').classList.add('hidden');
}

// Student Edit Modal Functions
function showEditStudentModal(id, nim, name, email, studyProgram, faculty, semester, phone, address, status, isVerified) {
    document.getElementById('editStudentForm').action = '{{ route("admin.students.update", ":id") }}'.replace(':id', id);
    document.getElementById('editStudentNim').value = nim;
    document.getElementById('editStudentName').value = name;
    document.getElementById('editStudentEmail').value = email;
    document.getElementById('editStudentStudyProgram').value = studyProgram;
    document.getElementById('editStudentFaculty').value = faculty;
    document.getElementById('editStudentSemester').value = semester;
    document.getElementById('editStudentPhone').value = phone || '';
    document.getElementById('editStudentAddress').value = address || '';
    document.getElementById('editStudentStatus').value = status;
    document.getElementById('editStudentIsVerified').checked = isVerified === 'true';
    document.getElementById('editStudentModal').classList.remove('hidden');
}

function hideEditStudentModal() {
    document.getElementById('editStudentModal').classList.add('hidden');
}

// Change Password Modal Functions
function showChangePasswordModal() {
    const editForm = document.getElementById('editStudentForm');
    const studentId = editForm.action.split('/').pop();
    document.getElementById('changePasswordForm').action = '{{ route("admin.students.password", ":id") }}'.replace(':id', studentId);
    document.getElementById('changePasswordModal').classList.remove('hidden');
}

function hideChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
    // Clear form
    document.getElementById('newPassword').value = '';
    document.getElementById('newPasswordConfirmation').value = '';
}

// Delete Student Modal Functions
function showDeleteStudentModal(id, name, nim) {
    document.getElementById('deleteStudentForm').action = '{{ route("admin.students.destroy", ":id") }}'.replace(':id', id);
    document.getElementById('deleteStudentName').textContent = name;
    document.getElementById('deleteStudentNim').textContent = nim;
    document.getElementById('deleteStudentModal').classList.remove('hidden');
}

function hideDeleteStudentModal() {
    document.getElementById('deleteStudentModal').classList.add('hidden');
}

// Filter Functions
function filterStudents(type) {
    const rows = document.querySelectorAll('.student-row');
    const filterAll = document.getElementById('filterAll');
    const filterUnverified = document.getElementById('filterUnverified');
    const filterVerified = document.getElementById('filterVerified');
    
    // Reset button styles
    filterAll.className = 'px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-800 border border-gray-200 hover:bg-blue-100 hover:text-blue-800 hover:border-blue-200';
    filterUnverified.className = 'px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-800 border border-gray-200 hover:bg-yellow-100 hover:text-yellow-800 hover:border-yellow-200';
    filterVerified.className = 'px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-800 border border-gray-200 hover:bg-green-100 hover:text-green-800 hover:border-green-200';
    
    rows.forEach(row => {
        const isVerified = row.getAttribute('data-verified');
        
        if (type === 'all') {
            row.style.display = '';
            filterAll.className = 'px-3 py-1 text-sm rounded-lg bg-blue-100 text-blue-800 border border-blue-200';
        } else if (type === 'unverified') {
            if (isVerified === 'false') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            filterUnverified.className = 'px-3 py-1 text-sm rounded-lg bg-yellow-100 text-yellow-800 border border-yellow-200';
        } else if (type === 'verified') {
            if (isVerified === 'true') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            filterVerified.className = 'px-3 py-1 text-sm rounded-lg bg-green-100 text-green-800 border border-green-200';
        }
    });
}

// Modal event listeners
document.getElementById('studentDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideStudentDetailModal();
    }
});

document.getElementById('editStudentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideEditStudentModal();
    }
});

document.getElementById('deleteStudentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteStudentModal();
    }
});

document.getElementById('changePasswordModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideChangePasswordModal();
    }
});

document.getElementById('addStudentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideAddStudentModal();
    }
});

// Add Student Modal Functions
function showAddStudentModal() {
    document.getElementById('addStudentModal').classList.remove('hidden');
}

function hideAddStudentModal() {
    document.getElementById('addStudentModal').classList.add('hidden');
    // Clear form
    document.querySelector('#addStudentModal form').reset();
    document.querySelector('input[name="faculty"]').value = '';
}

// Handle study program dropdown change for add modal
document.addEventListener('DOMContentLoaded', function() {
    const addStudyProgramSelect = document.querySelector('#addStudentModal select[name="study_program"]');
    if (addStudyProgramSelect) {
        addStudyProgramSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const faculty = selectedOption.getAttribute('data-faculty');
            document.querySelector('input[name="faculty"]').value = faculty || '';
        });
    }
});

// Handle study program dropdown change for edit modal
document.getElementById('editStudentStudyProgram').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const faculty = selectedOption.getAttribute('data-faculty');
    document.getElementById('editStudentFaculty').value = faculty || '';
});
</script>
@endpush
@endsection
