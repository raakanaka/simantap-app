@extends('layouts.app')

@section('title', 'Daftar Pengajuan')

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
                <a href="{{ route('admin.submissions') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
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
                <h1 class="text-2xl font-semibold text-gray-900">Daftar Pengajuan</h1>
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
                    <h2 class="text-2xl font-bold text-gray-900">Daftar Pengajuan Ujian</h2>
                    <div class="text-sm text-gray-500">
                        Total: {{ $submissions->count() }} pengajuan
                    </div>
                </div>
                
                @if($submissions->count() === 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan</h3>
                    <p class="text-gray-500">Tidak ada pengajuan ujian yang perlu diverifikasi.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($submissions as $submission)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $submission->examType->name ?? 'Unknown' }}</h3>
                                <div class="space-y-1 text-sm text-gray-500">
                                    <p>No. Pengajuan: {{ $submission->submission_number }}</p>
                                    <p>Mahasiswa: {{ $submission->student_name }} ({{ $submission->student_nim }})</p>
                                    <p>Program Studi: {{ $submission->student_study_program }}</p>
                                    <p>Tanggal: {{ $submission->submitted_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($submission->status === 'menunggu_verifikasi')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                @elseif($submission->status === 'berkas_diterima')
                                    <div class="flex flex-col items-end space-y-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Berkas Diterima</span>
                                        <button onclick="downloadFormulir({{ $submission->id }})" class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium py-1 px-3 rounded-lg transition duration-200">
                                            <i class="fas fa-file-pdf mr-1"></i>Generate Formulir
                                        </button>
                                    </div>
                                @elseif($submission->status === 'berkas_ditolak')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Berkas Ditolak</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Jumlah Dokumen:</span>
                                <span class="font-medium">{{ $submission->documents->count() }} file</span>
                            </div>
                            
                            @if($submission->revision_reason)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-medium text-red-900 mb-1">Alasan Penolakan</h4>
                                        <p class="text-sm text-red-800">{{ $submission->revision_reason }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($submission->verified_by)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-medium text-blue-900 mb-1">Diverifikasi oleh</h4>
                                        <p class="text-sm text-blue-800">{{ $submission->verified_by }} pada {{ $submission->verified_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex space-x-2">
                                <button 
                                    onclick="openDetailModal({{ $submission->id }})" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm"
                                    data-submission-id="{{ $submission->id }}"
                                    data-student-name="{{ $submission->student_name }}"
                                    data-student-nim="{{ $submission->student_nim }}"
                                    data-student-program="{{ $submission->student_study_program }}"
                                    data-submitted-at="{{ $submission->submitted_at->format('d/m/Y H:i') }}"
                                    data-exam-type="{{ $submission->examType->name ?? 'Unknown' }}"
                                    data-submission-number="{{ $submission->submission_number }}"
                                    data-title="{{ $submission->title ?? 'Tidak ada judul' }}"
                                    data-description="{{ $submission->description ?? 'Tidak ada deskripsi' }}"
                                    data-document-count="{{ $submission->documents->count() }}"
                                >
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
        </main>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pengajuan</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="revision_reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Masukkan alasan penolakan..." required></textarea>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideRejectModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Tolak Pengajuan
                    </button>
            </form>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Pengajuan Ujian</h3>
                <button onclick="hideDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Informasi Dasar</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Jenis Ujian</label>
                            <p id="detailExamType" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">No. Pengajuan</label>
                            <p id="detailSubmissionNumber" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Mahasiswa</label>
                            <p id="detailStudentName" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">NIM</label>
                            <p id="detailStudentNim" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Program Studi</label>
                            <p id="detailStudentProgram" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Pengajuan</label>
                            <p id="detailSubmittedAt" class="text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Submission Details -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Detail Pengajuan</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Judul</label>
                            <p id="detailTitle" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                            <p id="detailDescription" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Jumlah Dokumen</label>
                            <p id="detailDocumentCount" class="text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Uploaded Documents -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Dokumen yang Di-upload</h4>
                    <div id="detailDocumentsList" class="space-y-2">
                        <!-- Documents will be populated by JavaScript -->
                    </div>
                    <div id="noDocumentsMessage" class="text-center py-4 text-gray-500 hidden">
                        <i class="fas fa-file-alt text-2xl mb-2"></i>
                        <p>Tidak ada dokumen yang di-upload</p>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Status & Verifikasi</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <p id="detailStatus" class="text-sm"></p>
                        </div>
                        <div id="detailVerificationInfo" class="hidden">
                            <label class="text-sm font-medium text-gray-500">Diverifikasi oleh</label>
                            <p id="detailVerifiedBy" class="text-sm text-gray-900"></p>
                        </div>
                        <div id="detailRejectionInfo" class="hidden">
                            <label class="text-sm font-medium text-gray-500">Alasan Penolakan</label>
                            <p id="detailRevisionReason" class="text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <div id="detailActionButtons" class="flex space-x-2">
                    <!-- Action buttons will be populated by JavaScript based on status -->
                </div>
                <button onclick="hideDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Tutup
                </button>
            </div>
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
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-3"></i>
                        <span class="font-medium">${message}</span>
                    <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
    `;

    document.body.insertAdjacentHTML('beforeend', alertHTML);
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) alert.remove();
    }, 5000);
}

function showRejectModal(submissionId) {
    document.getElementById('rejectForm').action = '{{ route("admin.reject-submission", ":id") }}'.replace(':id', submissionId);
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Detail Modal Functions
function openDetailModal(submissionId) {
    // Ambil data dari server
    fetch(`/admin/submissions/${submissionId}/data`)
        .then(response => response.json())
        .then(data => {
            showDetailModalWithData(data);
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback: buat modal dengan data dari PHP
            showModalWithPHPData(submissionId);
        });
}

function showModalWithPHPData(submissionId) {
    // Ambil data dari elemen yang sudah ada di halaman
    const submissionData = getSubmissionDataFromPage(submissionId);
    
    const modalHTML = `
        <div id="detailModalNew" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
            <div style="background: white; padding: 20px; border-radius: 8px; max-width: 900px; width: 95%; max-height: 90%; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px;">
                    <h3 style="margin: 0; color: #1f2937;">Detail Pengajuan Ujian</h3>
                    <button onclick="closeDetailModal()" style="background: #ef4444; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">Tutup</button>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <h4 style="color: #374151; margin-bottom: 10px;">Informasi Mahasiswa</h4>
                        <p><strong>Nama:</strong> ${submissionData.studentName || 'Tidak ada data'}</p>
                        <p><strong>NIM:</strong> ${submissionData.studentNim || 'Tidak ada data'}</p>
                        <p><strong>Program Studi:</strong> ${submissionData.studentProgram || 'Tidak ada data'}</p>
                        <p><strong>Tanggal Pengajuan:</strong> ${submissionData.submittedAt || 'Tidak ada data'}</p>
                    </div>
                    <div>
                        <h4 style="color: #374151; margin-bottom: 10px;">Detail Pengajuan</h4>
                        <p><strong>Jenis Ujian:</strong> ${submissionData.examType || 'Tidak ada data'}</p>
                        <p><strong>No. Pengajuan:</strong> ${submissionData.submissionNumber || 'Tidak ada data'}</p>
                        <p><strong>Status:</strong> <span style="padding: 2px 8px; border-radius: 12px; background: #fef3c7; color: #92400e;">Menunggu Verifikasi</span></p>
                        <p><strong>Jumlah Dokumen:</strong> ${submissionData.documentCount || 0} file</p>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <h4 style="color: #374151; margin-bottom: 10px;">Judul & Deskripsi</h4>
                    <p><strong>Judul:</strong> ${submissionData.title || 'Tidak ada judul'}</p>
                    <p><strong>Deskripsi:</strong> ${submissionData.description || 'Tidak ada deskripsi'}</p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <h4 style="color: #374151; margin-bottom: 10px;">Dokumen yang Diupload</h4>
                    <div id="documentsList" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; background: #f9fafb;">
                        <p style="text-align: center; color: #6b7280;">Dokumen akan dimuat...</p>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <h4 style="color: #374151; margin-bottom: 10px;">Alasan Penolakan (jika ditolak)</h4>
                    <textarea id="rejectionReason" placeholder="Masukkan alasan penolakan jika diperlukan..." style="width: 100%; height: 80px; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid #e5e7eb; padding-top: 15px;">
                    <button onclick="acceptSubmission(${submissionId})" style="background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">
                        <i class="fas fa-check" style="margin-right: 5px;"></i>Terima
                    </button>
                    <button onclick="rejectSubmission(${submissionId})" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">
                        <i class="fas fa-times" style="margin-right: 5px;"></i>Tolak
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Load documents
    loadDocumentsForModal(submissionId);
}

function getSubmissionDataFromPage(submissionId) {
    // Cari data submission dari halaman
    const submissionElements = document.querySelectorAll('[data-submission-id]');
    for (let element of submissionElements) {
        if (element.getAttribute('data-submission-id') == submissionId) {
            return {
                studentName: element.getAttribute('data-student-name') || 'Tidak ada data',
                studentNim: element.getAttribute('data-student-nim') || 'Tidak ada data',
                studentProgram: element.getAttribute('data-student-program') || 'Tidak ada data',
                submittedAt: element.getAttribute('data-submitted-at') || 'Tidak ada data',
                examType: element.getAttribute('data-exam-type') || 'Tidak ada data',
                submissionNumber: element.getAttribute('data-submission-number') || 'Tidak ada data',
                title: element.getAttribute('data-title') || 'Tidak ada judul',
                description: element.getAttribute('data-description') || 'Tidak ada deskripsi',
                documentCount: element.getAttribute('data-document-count') || 0
            };
        }
    }
    return {};
}

function loadDocumentsForModal(submissionId) {
    // Ambil data dokumen dari server
    fetch(`/admin/submissions/${submissionId}/documents`)
        .then(response => response.json())
        .then(documents => {
            displayDocumentsInModal(documents);
        })
        .catch(error => {
            console.error('Error loading documents:', error);
            // Fallback: tampilkan pesan error
            const documentsList = document.getElementById('documentsList');
            if (documentsList) {
                documentsList.innerHTML = `
                    <div style="text-align: center; padding: 20px;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 24px; color: #f59e0b; margin-bottom: 10px;"></i>
                        <p style="color: #6b7280;">Gagal memuat dokumen</p>
                        <p style="color: #9ca3af; font-size: 14px;">Silakan refresh halaman dan coba lagi</p>
                    </div>
                `;
            }
        });
}

function displayDocumentsInModal(documents) {
    const documentsList = document.getElementById('documentsList');
    if (!documentsList) return;
    
    if (!documents || documents.length === 0) {
        documentsList.innerHTML = `
            <div style="text-align: center; padding: 20px;">
                <i class="fas fa-file-alt" style="font-size: 24px; color: #6b7280; margin-bottom: 10px;"></i>
                <p style="color: #6b7280;">Tidak ada dokumen yang diupload</p>
            </div>
        `;
        return;
    }
    
    let documentsHTML = '';
    documents.forEach((doc, index) => {
        const fileIcon = getFileIconForModal(doc.mime_type);
        const fileSize = formatFileSizeForModal(doc.file_size);
        
        documentsHTML += `
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 8px; background: white;">
                <div style="display: flex; align-items: center; flex: 1;">
                    <div style="margin-right: 12px;">
                        <i class="${fileIcon}" style="font-size: 20px; color: #6b7280;"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <p style="margin: 0; font-weight: 500; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${doc.original_filename}</p>
                        <p style="margin: 0; font-size: 12px; color: #6b7280;">${fileSize} • ${doc.mime_type}</p>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button onclick="previewDocumentInModal(${doc.id}, '${doc.original_filename}', '${doc.mime_type}')" style="background: #10b981; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fas fa-eye" style="margin-right: 4px;"></i>Preview
                    </button>
                    <button onclick="downloadDocumentInModal(${doc.id}, '${doc.original_filename}')" style="background: #3b82f6; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fas fa-download" style="margin-right: 4px;"></i>Download
                    </button>
                </div>
            </div>
        `;
    });
    
    documentsList.innerHTML = documentsHTML;
}

function getFileIconForModal(mimeType) {
    if (mimeType.includes('pdf')) {
        return 'fas fa-file-pdf text-red-500';
    } else if (mimeType.includes('word') || mimeType.includes('document')) {
        return 'fas fa-file-word text-blue-500';
    } else if (mimeType.includes('image')) {
        return 'fas fa-file-image text-green-500';
    } else if (mimeType.includes('text')) {
        return 'fas fa-file-alt text-gray-500';
    } else {
        return 'fas fa-file text-gray-500';
    }
}

function formatFileSizeForModal(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function previewDocumentInModal(documentId, filename, mimeType) {
    if (mimeType.includes('pdf')) {
        // Untuk PDF, buka di tab baru
        const link = document.createElement('a');
        link.href = `/admin/submissions/${getCurrentSubmissionId()}/documents/${documentId}/download`;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else if (mimeType.includes('image')) {
        // Untuk gambar, tampilkan dalam modal
        showImagePreviewModal(filename, `/admin/submissions/${getCurrentSubmissionId()}/documents/${documentId}/download`);
    } else {
        // Untuk file lain, coba download
        downloadDocumentInModal(documentId, filename);
    }
}

function downloadDocumentInModal(documentId, filename) {
    const link = document.createElement('a');
    link.href = `/admin/submissions/${getCurrentSubmissionId()}/documents/${documentId}/download`;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function showImagePreviewModal(filename, imageUrl) {
    const modalHTML = `
        <div id="imagePreviewModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; display: flex; align-items: center; justify-content: center;">
            <div style="position: relative; max-width: 90%; max-height: 90%;">
                <button onclick="closeImagePreview()" style="position: absolute; top: -40px; right: 0; background: #ef4444; color: white; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <img src="${imageUrl}" alt="${filename}" style="max-width: 100%; max-height: 100%; border-radius: 8px;">
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

function closeImagePreview() {
    const modal = document.getElementById('imagePreviewModal');
    if (modal) {
        modal.remove();
    }
}

function getCurrentSubmissionId() {
    // Ambil submission ID dari modal yang sedang aktif
    const modal = document.getElementById('detailModalNew');
    if (modal) {
        const buttons = modal.querySelectorAll('button[onclick*="acceptSubmission"]');
        if (buttons.length > 0) {
            const onclick = buttons[0].getAttribute('onclick');
            const match = onclick.match(/acceptSubmission\((\d+)\)/);
            if (match) {
                return match[1];
            }
        }
    }
    return null;
}

function closeDetailModal() {
    const modal = document.getElementById('detailModalNew');
    if (modal) {
        modal.remove();
    }
}

function acceptSubmission(submissionId) {
    if (confirm('Apakah Anda yakin ingin menerima pengajuan ini?')) {
        // Submit form terima
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/submissions/${submissionId}/verify`;
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
        document.body.appendChild(form);
        form.submit();
    }
}

function rejectSubmission(submissionId) {
    const reason = document.getElementById('rejectionReason').value;
    if (!reason.trim()) {
        alert('Silakan masukkan alasan penolakan!');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menolak pengajuan ini?')) {
        // Submit form tolak
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/submissions/${submissionId}/reject`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="revision_reason" value="${reason}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function showDetailModal(id, examType, submissionNumber, studentName, studentNim, studentProgram, submittedAt, status, title, description, revisionReason, documentCount, verifiedBy, verifiedAt, documents) {
    // Set current submission ID for document context
    setCurrentDocumentContext(id, null);
    
    // Check if modal exists
    const modal = document.getElementById('detailModal');
    if (!modal) {
        return;
    }
    
    // Fill basic info
    try {
        document.getElementById('detailExamType').textContent = examType || 'Tidak ada data';
        document.getElementById('detailSubmissionNumber').textContent = submissionNumber || 'Tidak ada data';
        document.getElementById('detailStudentName').textContent = studentName || 'Tidak ada data';
        document.getElementById('detailStudentNim').textContent = studentNim || 'Tidak ada data';
        document.getElementById('detailStudentProgram').textContent = studentProgram || 'Tidak ada data';
        document.getElementById('detailSubmittedAt').textContent = submittedAt || 'Tidak ada data';
        
        // Fill submission details
        document.getElementById('detailTitle').textContent = title || 'Tidak ada judul';
        document.getElementById('detailDescription').textContent = description || 'Tidak ada deskripsi';
        document.getElementById('detailDocumentCount').textContent = (documentCount || 0) + ' file';
        
        // Fill documents list
        displayDocuments(documents || []);
    } catch (error) {
        console.error('Error filling basic info:', error);
    }
    
    // Fill status info
    try {
        let statusText = '';
        let statusClass = '';
        switch(status) {
            case 'menunggu_verifikasi':
                statusText = 'Menunggu Verifikasi';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                break;
            case 'berkas_diterima':
                statusText = 'Berkas Diterima';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                break;
            case 'berkas_ditolak':
                statusText = 'Berkas Ditolak';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                break;
            default:
                statusText = status || 'Tidak diketahui';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        }
        
        const statusElement = document.getElementById('detailStatus');
        if (statusElement) {
            statusElement.innerHTML = `<span class="${statusClass}">${statusText}</span>`;
        }
        
        // Show/hide verification info
        const verificationInfo = document.getElementById('detailVerificationInfo');
        const rejectionInfo = document.getElementById('detailRejectionInfo');
        
        if (verifiedBy && verifiedAt) {
            const verifiedByElement = document.getElementById('detailVerifiedBy');
            if (verifiedByElement) {
                verifiedByElement.textContent = verifiedBy + ' pada ' + verifiedAt;
            }
            if (verificationInfo) {
                verificationInfo.classList.remove('hidden');
            }
        } else {
            if (verificationInfo) {
                verificationInfo.classList.add('hidden');
            }
        }
        
        if (revisionReason && status === 'berkas_ditolak') {
            const revisionReasonElement = document.getElementById('detailRevisionReason');
            if (revisionReasonElement) {
                revisionReasonElement.textContent = revisionReason;
            }
            if (rejectionInfo) {
                rejectionInfo.classList.remove('hidden');
            }
        } else {
            if (rejectionInfo) {
                rejectionInfo.classList.add('hidden');
            }
        }
        
        // Show action buttons based on status
        displayActionButtons(id, status);
    } catch (error) {
        console.error('Error filling status info:', error);
    }
    
    // Show modal
    modal.classList.remove('hidden');
    modal.style.display = 'block';
    modal.style.visibility = 'visible';
    modal.style.opacity = '1';
}

function hideDetailModal() {
    const modal = document.getElementById('detailModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Function to display documents
function displayDocuments(documents) {
    const documentsList = document.getElementById('detailDocumentsList');
    const noDocumentsMessage = document.getElementById('noDocumentsMessage');
    
    if (!documentsList || !noDocumentsMessage) {
        return;
    }
    
    // Clear previous content
    documentsList.innerHTML = '';
    
    if (!documents || documents.length === 0) {
        // Show no documents message
        noDocumentsMessage.classList.remove('hidden');
        documentsList.classList.add('hidden');
    } else {
        // Hide no documents message
        noDocumentsMessage.classList.add('hidden');
        documentsList.classList.remove('hidden');
        
        // Display each document
        documents.forEach((doc, index) => {
            const documentItem = createDocumentItem(doc, index);
            documentsList.appendChild(documentItem);
        });
    }
}

// Function to create document item
function createDocumentItem(doc, index) {
    const div = document.createElement('div');
    div.className = 'flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200';
    
    // Get file icon based on mime type
    const fileIcon = getFileIcon(doc.mime_type);
    const fileSize = formatFileSize(doc.file_size);
    
            div.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <i class="${fileIcon} text-2xl text-gray-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">${doc.original_filename}</p>
                    <p class="text-xs text-gray-500">${fileSize} • ${doc.mime_type}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="setCurrentDocumentContext(${getCurrentSubmissionId()}, ${doc.id}); downloadDocument('${doc.file_path}', '${doc.original_filename}')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <i class="fas fa-download mr-1"></i>Download
                </button>
                <button onclick="setCurrentDocumentContext(${getCurrentSubmissionId()}, ${doc.id}); previewDocument('${doc.file_path}', '${doc.original_filename}', '${doc.mime_type}')" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    <i class="fas fa-eye mr-1"></i>Preview
                </button>
            </div>
        `;
    
    return div;
}

// Function to get file icon based on mime type
function getFileIcon(mimeType) {
    if (mimeType.includes('pdf')) {
        return 'fas fa-file-pdf text-red-500';
    } else if (mimeType.includes('word') || mimeType.includes('document')) {
        return 'fas fa-file-word text-blue-500';
    } else if (mimeType.includes('image')) {
        return 'fas fa-file-image text-green-500';
    } else if (mimeType.includes('text')) {
        return 'fas fa-file-alt text-gray-500';
    } else {
        return 'fas fa-file text-gray-500';
    }
}

// Function to format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Function to download document
function downloadDocument(filePath, originalFilename) {
    // Use the admin download route since files are in private storage
    const link = document.createElement('a');
    link.href = `/admin/submissions/${getCurrentSubmissionId()}/documents/${getCurrentDocumentId()}/download`;
    link.download = originalFilename;
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Function to preview document
function previewDocument(filePath, originalFilename, mimeType) {
    if (mimeType.includes('pdf')) {
        // For PDF, use download route to open in new tab
        const link = document.createElement('a');
        link.href = `/admin/submissions/${getCurrentSubmissionId()}/documents/${getCurrentDocumentId()}/download`;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else if (mimeType.includes('image')) {
        // For images, we need to create a blob URL from the download
        previewImageFromDownload(filePath, originalFilename);
    } else {
        // For other file types, try to download
        downloadDocument(filePath, originalFilename);
    }
}

// Helper functions to get current submission and document IDs
let currentSubmissionId = null;
let currentDocumentId = null;

function setCurrentDocumentContext(submissionId, documentId) {
    currentSubmissionId = submissionId;
    currentDocumentId = documentId;
}

function getCurrentSubmissionId() {
    return currentSubmissionId;
}

function getCurrentDocumentId() {
    return currentDocumentId;
}

// Function to preview image from download
function previewImageFromDownload(filePath, originalFilename) {
    // For images, we'll use the download route to get the file and create a blob URL
    fetch(`/admin/submissions/${getCurrentSubmissionId()}/documents/${getCurrentDocumentId()}/download`)
        .then(response => response.blob())
        .then(blob => {
            const imageUrl = URL.createObjectURL(blob);
            showImagePreview(imageUrl, originalFilename);
        })
        .catch(error => {
            console.error('Error loading image:', error);
            alert('Gagal memuat gambar');
        });
}

// Function to show image preview
function showImagePreview(imagePath, filename) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="max-w-4xl max-h-full p-4">
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">${filename}</h3>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4">
                    <img src="${imagePath}" alt="${filename}" class="max-w-full max-h-96 mx-auto">
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Close on click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

@if(session('success'))
showAlert('{{ session('success') }}', 'success');
@endif

@if(session('error'))
showAlert('{{ session('error') }}', 'danger');
@endif

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed')) {
        hideRejectModal();
        hideDetailModal();
    }
});


// Function to display action buttons based on submission status
function displayActionButtons(submissionId, status) {
    const actionButtonsContainer = document.getElementById('detailActionButtons');
    if (!actionButtonsContainer) {
        return;
    }
    
    // Clear previous buttons
    actionButtonsContainer.innerHTML = '';
    
    if (status === 'menunggu_verifikasi') {
        // Show Accept and Reject buttons for pending submissions
        actionButtonsContainer.innerHTML = `
            <form action="{{ route('admin.verify-submission', ':id') }}".replace(':id', submissionId) method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                    <i class="fas fa-check mr-2"></i>Terima
                </button>
            </form>
            <button onclick="showRejectModal(${submissionId})" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                <i class="fas fa-times mr-2"></i>Tolak
            </button>
        `;
    } else if (status === 'berkas_diterima') {
        // Show status for accepted submissions with generate formulir button
        actionButtonsContainer.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-2"></i>Berkas Diterima
                </span>
                <button onclick="downloadFormulir(${submissionId})" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                    <i class="fas fa-file-pdf mr-2"></i>Generate Formulir
                </button>
            </div>
        `;
    } else if (status === 'berkas_ditolak') {
        // Show status for rejected submissions
        actionButtonsContainer.innerHTML = `
            <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-red-100 text-red-800">
                <i class="fas fa-times-circle mr-2"></i>Berkas Ditolak
            </span>
        `;
    }
    }


</script>
@endpush
@endsection
