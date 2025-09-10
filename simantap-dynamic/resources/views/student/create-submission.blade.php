@extends('layouts.app')

@section('title', 'Buat Pengajuan')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('components.student-sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Buat Pengajuan Ujian</h1>
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
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <h4 class="font-medium">Terjadi kesalahan:</h4>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="max-w-4xl mx-auto">
                <form action="{{ route('student.submit-application') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="console.log('Form onsubmit triggered'); debugFormData(); return true;">
                    @csrf
                    <input type="hidden" name="debug_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="debug_form" value="test">
                    
                    <!-- Exam Type Selection -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Jenis Ujian</h2>
                        
                        @if($selectedExamType)
                            <!-- Selected Exam Type -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-blue-900">{{ $selectedExamType->name }}</h3>
                                        <p class="text-sm text-blue-700">{{ $selectedExamType->description }}</p>
                                        <p class="text-xs text-blue-600 mt-1">Kode: {{ $selectedExamType->code }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Dipilih
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="exam_type_id" value="{{ $selectedExamType->id }}">
                        @else
                            <!-- Exam Type Selection -->
                            <div class="space-y-4">
                                @foreach($examTypes as $examType)
                                <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="exam_type_id" value="{{ $examType->id }}" class="mt-1" required>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-medium text-gray-900">{{ $examType->name }}</h3>
                                            <span class="text-xs text-gray-500">{{ $examType->code }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $examType->description }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Submission Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pengajuan</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengajuan</label>
                                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan judul pengajuan">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                                <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan deskripsi pengajuan"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Upload Dokumen Persyaratan</h2>
                        <p class="text-sm text-gray-600 mb-6">Upload dokumen satu per satu sesuai dengan persyaratan yang ditentukan untuk menghindari kesalahan.</p>
                        
                        @if($selectedExamType)
                            @php
                                $requirements = \App\Models\ExamRequirement::where('exam_type_id', $selectedExamType->id)
                                    ->where('is_required', true)
                                    ->orderBy('order')
                                    ->get();
                            @endphp
                            
                            <!-- Requirements List -->
                            <div class="space-y-4 mb-6">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h3 class="font-medium text-blue-900 mb-2">Daftar Persyaratan Dokumen untuk {{ $selectedExamType->name }}:</h3>
                                    <ul class="text-sm text-blue-800 space-y-1">
                                        @foreach($requirements as $requirement)
                                            <li>• {{ $requirement->document_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Individual File Upload -->
                        <div class="space-y-4">
                            @if($selectedExamType)
                                @foreach($requirements as $index => $requirement)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $requirement->document_name }}</h4>
                                            <p class="text-sm text-gray-500">Format: {{ $requirement->file_types }} | Maksimal: {{ number_format($requirement->max_size / 1024, 0) }}MB</p>
                                            @if($requirement->description)
                                                <p class="text-xs text-gray-600 mt-1">{{ $requirement->description }}</p>
                                            @endif
                                        </div>
                                        <span class="text-xs text-red-600 font-medium">Wajib</span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <input type="file" 
                                               name="documents[]" 
                                               accept=".pdf,.doc,.docx" 
                                               class="hidden" 
                                               id="file-{{ $requirement->id }}" 
                                               onchange="handleFileSelect(this, 'preview-{{ $requirement->id }}', 'status-{{ $requirement->id }}')"
                                               data-requirement-id="{{ $requirement->id }}"
                                               required>
                                        <input type="hidden" name="requirement_ids[]" value="{{ $requirement->id }}">
                                        <label for="file-{{ $requirement->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition duration-200">
                                            <i class="fas fa-upload mr-2"></i>Unggah
                                        </label>
                                        <div id="preview-{{ $requirement->id }}" class="hidden flex-1">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-file text-blue-500"></i>
                                                <span class="text-sm text-gray-700" id="file-name-{{ $requirement->id }}"></span>
                                                <span class="text-xs text-gray-500" id="file-size-{{ $requirement->id }}"></span>
                                            </div>
                                        </div>
                                        <div id="status-{{ $requirement->id }}" class="hidden">
                                            <span class="text-green-600 text-sm font-medium">
                                                <i class="fas fa-check-circle mr-1"></i>Terupload
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Pilih jenis ujian terlebih dahulu untuk melihat persyaratan dokumen.</p>
                                </div>
                            @endif


                        </div>

                        <!-- Upload Progress -->
                        @if($selectedExamType && isset($requirements))
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress Upload</span>
                                <span class="text-sm text-gray-500" id="upload-count">0/{{ $requirements->count() }} dokumen</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" id="upload-progress" style="width: 0%"></div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Information -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-blue-900 mb-1">Panduan Pengajuan</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Pastikan semua dokumen yang diperlukan sudah diupload</li>
                                    <li>• Format file harus sesuai dengan persyaratan (PDF, DOC, DOCX)</li>
                                    <li>• Ukuran file maksimal 10MB per file</li>
                                    <li>• Pengajuan akan diverifikasi oleh dosen atau admin</li>
                                    <li>• Status pengajuan dapat dilihat di menu "Pengajuan Saya"</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('student.my-submissions') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                            Batal
                        </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200" onclick="console.log('Submit button clicked'); return true;">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Pengajuan
                    </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
let uploadedFiles = 0;
const totalFiles = {{ $selectedExamType && isset($requirements) ? $requirements->count() : 0 }};

function handleFileSelect(input, previewId, statusId) {
    const file = input.files[0];
    
    console.log('File selected:', {
        name: file ? file.name : 'none',
        type: file ? file.type : 'none',
        size: file ? file.size : 'none'
    });
    
    if (file) {
        // Validate file
        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const validExtensions = ['pdf', 'doc', 'docx'];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!validTypes.includes(file.type) && !validExtensions.includes(fileExtension)) {
            console.log('File validation failed:', {
                mimeType: file.type,
                extension: fileExtension,
                validTypes: validTypes,
                validExtensions: validExtensions
            });
            alert('Format file tidak valid. Harap pilih file PDF, DOC, atau DOCX.');
            input.value = '';
            return;
        }
        
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 10MB.');
            input.value = '';
            return;
        }
        
        // Show preview
        const preview = document.getElementById(previewId);
        const status = document.getElementById(statusId);
        const fileName = document.getElementById('file-name-' + previewId.split('-')[1]);
        const fileSize = document.getElementById('file-size-' + previewId.split('-')[1]);
        
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        
        preview.classList.remove('hidden');
        status.classList.remove('hidden');
        
        // Update progress
        uploadedFiles++;
        updateProgress();
        
        // Disable the upload button for this file
        const label = input.nextElementSibling;
        label.classList.add('opacity-50', 'cursor-not-allowed');
        label.style.pointerEvents = 'none';
        
        // Add change file option
        const changeButton = document.createElement('button');
        changeButton.type = 'button';
        changeButton.className = 'text-blue-600 hover:text-blue-800 text-sm font-medium ml-2';
        changeButton.innerHTML = '<i class="fas fa-edit mr-1"></i>Ganti';
        changeButton.onclick = function() {
            input.click();
        };
        
        status.appendChild(changeButton);
    }
}

function updateProgress() {
    const progressBar = document.getElementById('upload-progress');
    const uploadCount = document.getElementById('upload-count');
    const percentage = (uploadedFiles / totalFiles) * 100;
    
    progressBar.style.width = percentage + '%';
    uploadCount.textContent = uploadedFiles + '/' + totalFiles + ' dokumen';
    
    // Change color based on progress
    if (percentage === 100) {
        progressBar.classList.remove('bg-blue-600');
        progressBar.classList.add('bg-green-600');
    } else if (percentage >= 50) {
        progressBar.classList.remove('bg-blue-600');
        progressBar.classList.add('bg-yellow-500');
    }
}

// Form validation before submit - DISABLED FOR DEBUGGING
// All validation disabled to allow form submission

// Debug form data before submission
function debugFormData() {
    const form = document.querySelector('form');
    const formData = new FormData(form);
    
    console.log('Form data being submitted:');
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            console.log(`${key}:`, {
                name: value.name,
                type: value.type,
                size: value.size
            });
        } else {
            console.log(`${key}:`, value);
        }
    }
}

// Add visual feedback for required fields
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = document.querySelectorAll('input[required]');
    requiredFields.forEach(field => {
        field.addEventListener('invalid', function() {
            this.classList.add('border-red-500');
        });
        
        field.addEventListener('input', function() {
            this.classList.remove('border-red-500');
        });
    });
});
</script>
@endpush
@endsection
