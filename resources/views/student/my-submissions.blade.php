@extends('layouts.app')

@section('title', 'Pengajuan Saya')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('components.student-sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Pengajuan Saya</h1>
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
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Pengajuan Saya</h2>
                    <p class="text-gray-600">Total pengajuan: {{ $submissions->count() }}</p>
                    @if(config('app.debug'))
                        <p class="text-xs text-gray-500">Debug: Student NIM: {{ $student->nim ?? 'NULL' }}</p>
                    @endif
                </div>
                
                @if($submissions->count() === 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan</h3>
                    <p class="text-gray-500 mb-6">Anda belum mengajukan ujian akhir apapun</p>
                    @if(config('app.debug'))
                        <p class="text-xs text-gray-500 mb-4">Debug: Student ID: {{ $student->id ?? 'NULL' }}, NIM: {{ $student->nim ?? 'NULL' }}</p>
                    @endif
                    <a href="{{ route('student.exam-types') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Ajukan Ujian
                    </a>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($submissions as $submission)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $submission->examType->name ?? 'Unknown' }}</h3>
                                <p class="text-sm text-gray-500">No. Pengajuan: {{ $submission->submission_number }}</p>
                                <p class="text-sm text-gray-500">Tanggal: {{ $submission->submitted_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                @if($submission->status === 'menunggu_verifikasi')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>         
                                @elseif($submission->status === 'berkas_diterima')
                                    <div class="flex flex-col items-end space-y-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Berkas Diterima</span>
                                        <button onclick="downloadFormulir({{ $submission->id }})" class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium py-1 px-3 rounded-lg transition duration-200">
                                            <i class="fas fa-file-pdf mr-1"></i>Download Formulir
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
                                        <h4 class="font-medium text-red-900 mb-1">Alasan Revisi</h4>
                                        <p class="text-sm text-red-800">{{ $submission->revision_reason }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex space-x-2">
                                <button onclick="showSubmissionDetailModal({{ $submission->id }}, '{{ $submission->title }}', '{{ $submission->examType->name }}', '{{ $submission->status }}', '{{ $submission->submitted_at->format('d/m/Y H:i') }}', '{{ $submission->description }}', '{{ $submission->revision_reason }}', {{ $submission->documents->count() }})" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </button>
                                @if($submission->status === 'berkas_ditolak')
                                <button class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                                    <i class="fas fa-edit mr-2"></i>Edit & Submit Ulang
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Submission Detail Modal -->
<div id="submissionDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Pengajuan</h3>
                <button onclick="hideSubmissionDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pengajuan</label>
                        <p id="detailTitle" class="text-sm text-gray-900 bg-gray-50 p-2 rounded"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Ujian</label>
                        <p id="detailExamType" class="text-sm text-gray-900 bg-gray-50 p-2 rounded"></p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <p id="detailStatus" class="text-sm text-gray-900 bg-gray-50 p-2 rounded"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                        <p id="detailSubmittedAt" class="text-sm text-gray-900 bg-gray-50 p-2 rounded"></p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <p id="detailDescription" class="text-sm text-gray-900 bg-gray-50 p-2 rounded min-h-[60px]"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen Persyaratan</label>
                    <div id="detailDocuments" class="space-y-2">
                        <!-- Documents will be populated by JavaScript -->
                    </div>
                </div>
                
                <div id="detailRevisionReason" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Revisi</label>
                    <p id="detailRevisionText" class="text-sm text-red-800 bg-red-50 p-2 rounded border border-red-200"></p>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-6">
                <button onclick="hideSubmissionDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showSubmissionDetailModal(id, title, examType, status, submittedAt, description, revisionReason, documentCount) {
    document.getElementById('detailTitle').textContent = title;
    document.getElementById('detailExamType').textContent = examType;
    document.getElementById('detailSubmittedAt').textContent = submittedAt;
    document.getElementById('detailDescription').textContent = description || '-';
    
    // Load document details via AJAX
    loadSubmissionDocuments(id);
    
    // Status display
    let statusText = '';
    let statusClass = '';
    switch(status) {
        case 'menunggu_verifikasi':
            statusText = 'Menunggu Verifikasi';
            statusClass = 'text-yellow-800 bg-yellow-100';
            break;
        case 'berkas_diterima':
            statusText = 'Berkas Diterima';
            statusClass = 'text-green-800 bg-green-100';
            break;
        case 'berkas_ditolak':
            statusText = 'Berkas Ditolak';
            statusClass = 'text-red-800 bg-red-100';
            break;
        default:
            statusText = status;
            statusClass = 'text-gray-800 bg-gray-100';
    }
    document.getElementById('detailStatus').textContent = statusText;
    document.getElementById('detailStatus').className = 'text-sm p-2 rounded ' + statusClass;
    
    // Show revision reason if exists
    if (revisionReason && revisionReason !== '') {
        document.getElementById('detailRevisionText').textContent = revisionReason;
        document.getElementById('detailRevisionReason').classList.remove('hidden');
    } else {
        document.getElementById('detailRevisionReason').classList.add('hidden');
    }
    
    document.getElementById('submissionDetailModal').classList.remove('hidden');
}

function hideSubmissionDetailModal() {
    document.getElementById('submissionDetailModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('submissionDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideSubmissionDetailModal();
    }
});

function loadSubmissionDocuments(submissionId) {
    // Show loading state
    document.getElementById('detailDocuments').innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-gray-400"></i> <span class="text-gray-500">Memuat dokumen...</span></div>';
    
    // Fetch submission documents
    fetch(`/student/submissions/${submissionId}/documents`)
        .then(response => response.json())
        .then(data => {
            const documentsContainer = document.getElementById('detailDocuments');
            
            if (data.documents && data.documents.length > 0) {
                let html = '';
                data.documents.forEach(doc => {
                    const statusClass = doc.uploaded ? 'text-green-600' : 'text-red-600';
                    const statusIcon = doc.uploaded ? 'fa-check-circle' : 'fa-times-circle';
                    const statusText = doc.uploaded ? 'Terupload' : 'Belum diupload';
                    
                    html += `
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-file text-gray-400"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${doc.requirement_name || 'Dokumen'}</p>
                                    <p class="text-xs text-gray-500">${doc.original_filename || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs ${statusClass}">
                                    <i class="fas ${statusIcon} mr-1"></i>${statusText}
                                </span>
                            </div>
                        </div>
                    `;
                });
                documentsContainer.innerHTML = html;
            } else {
                documentsContainer.innerHTML = '<div class="text-center py-4 text-gray-500">Tidak ada dokumen</div>';
            }
        })
        .catch(error => {
            console.error('Error loading documents:', error);
            document.getElementById('detailDocuments').innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat dokumen</div>';
        });
}

function downloadFormulir(submissionId) {
    // Create a temporary link element
    const link = document.createElement('a');
    link.href = `/student/submissions/${submissionId}/download-formulir`;
    link.download = `Formulir_Pendaftaran_${submissionId}_${new Date().toISOString().split('T')[0]}.pdf`;
    
    // Add to DOM, click, and remove
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endpush
@endsection
