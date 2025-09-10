@extends('layouts.app')

@section('title', 'Tugas Dosen')

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
                    <p class="text-sm text-gray-600">Dosen Panel</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('lecturer.dashboard') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('lecturer.submissions') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('lecturer.status') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-eye w-5 h-5 mr-3"></i>
                    <span>Status</span>
                </a>
                <a href="{{ route('lecturer.tasks') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-tasks w-5 h-5 mr-3"></i>
                    <span>Tugas Dosen</span>
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
                <h1 class="text-2xl font-bold text-gray-900">Tugas Dosen</h1>
                <p class="text-gray-600">Kelola tugas dan pengajuan yang perlu diselesaikan</p>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            <div class="space-y-6">
                <!-- Task Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Verifikasi Pengajuan</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $pendingSubmissions->count() }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Pengajuan yang menunggu verifikasi dosen</p>
                        <a href="{{ route('lecturer.submissions') }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>Verifikasi Sekarang
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Revisi Pengajuan</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $rejectedSubmissions->count() }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Pengajuan yang ditolak dan perlu revisi</p>
                        <a href="{{ route('lecturer.submissions') }}?status=berkas_ditolak" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>Lihat Revisi
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Pengajuan Disetujui</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $approvedSubmissions->count() }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Pengajuan yang telah disetujui</p>
                        <a href="{{ route('lecturer.submissions') }}?status=berkas_diterima" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>

                <!-- Pending Tasks -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Tugas yang Perlu Diselesaikan</h2>
                        <p class="text-sm text-gray-600">Daftar pengajuan yang memerlukan tindakan dosen</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Ujian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendingSubmissions->take(10) as $submission)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $submission->student->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $submission->student->nim }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $submission->examType->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu Verifikasi
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $daysSinceSubmission = $submission->created_at->diffInDays(now());
                                            @endphp
                                            @if($daysSinceSubmission >= 3)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Tinggi
                                                </span>
                                            @elseif($daysSinceSubmission >= 1)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Sedang
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Rendah
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('lecturer.submissions') }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>Lihat
                                                </a>
                                                <form action="{{ route('lecturer.verify-submission', $submission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">
                                                        <i class="fas fa-check mr-1"></i>Setujui
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada tugas yang perlu diselesaikan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
@endsection
