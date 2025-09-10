@extends('layouts.app')

@section('title', 'Persyaratan Berkas')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('components.student-sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Persyaratan Berkas</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">Selamat datang, {{ session('user_name') }}</p>
                        <p class="text-xs text-gray-500">NIM: {{ session('student_nim') }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-sm"></i>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Persyaratan Ujian</h2>
                        <p class="text-gray-600">Daftar persyaratan dokumen untuk semua jenis ujian</p>
                    </div>
                    <a href="{{ route('student.exam-types') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Jenis Ujian
                    </a>
                </div>
                
                <!-- Exam Type Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $examType->name }}</h3>
                            <p class="text-gray-600">{{ $examType->description }}</p>
                            <p class="text-sm text-gray-500 mt-1">Kode: {{ $examType->code }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($requirements as $requirement)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $requirement->document_name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $requirement->description }}</p>
                                <p class="text-xs text-gray-500 mt-2">Format: {{ $requirement->file_types }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Wajib
                            </span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Keterangan:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• File harus dalam format: {{ $requirement->file_types }}</li>
                                <li>• Ukuran maksimal: 10MB per file</li>
                                <li>• Pastikan file dapat dibuka dan tidak rusak</li>
                            </ul>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Persyaratan</h3>
                        <p class="text-gray-600">Tidak ada persyaratan ujian yang tersedia saat ini.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4 mt-8">
                    <a href="{{ route('student.exam-types') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Jenis Ujian
                    </a>
                    <a href="{{ route('student.create-submission', $examType->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-upload mr-2"></i>Ajukan Ujian Ini
                    </a>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-blue-900 mb-1">Panduan Upload</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Pastikan semua file yang wajib sudah diupload</li>
                                <li>• Format file harus sesuai dengan persyaratan</li>
                                <li>• Ukuran file maksimal 10MB per file</li>
                                <li>• File akan diverifikasi oleh dosen atau admin</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
