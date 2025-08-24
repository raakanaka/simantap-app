@extends('layouts.app')

@section('title', 'Edit Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>
                    <i class="fas fa-edit me-2"></i>
                    Edit & Submit Ulang
                </h2>
                <p class="text-muted mb-0">{{ $submission->submission_number }} - {{ $submission->examType->name }}</p>
            </div>
            <a href="{{ route('submissions.show', $submission->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Alasan Revisi
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6><i class="fas fa-info-circle me-1"></i>Pengajuan Anda ditolak dengan alasan:</h6>
                    <p class="mb-0">{{ $submission->revision_reason }}</p>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-upload me-2"></i>
                    Upload Ulang Dokumen
                </h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    @foreach($submission->examType->requirements->sortBy('order') as $requirement)
                        @php
                            $existingDocument = $submission->documents->where('exam_requirement_id', $requirement->id)->first();
                        @endphp
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">
                                        {{ $requirement->document_name }}
                                        @if($requirement->is_required)
                                            <span class="badge bg-danger ms-1">Wajib</span>
                                        @else
                                            <span class="badge bg-secondary ms-1">Opsional</span>
                                        @endif
                                    </h6>
                                    <p class="text-muted mb-1">{{ $requirement->description }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-file me-1"></i>
                                        Format: {{ $requirement->file_types ? strtoupper($requirement->file_types) : 'Semua format' }}
                                        @if($requirement->max_size)
                                            | Maksimal: {{ number_format($requirement->max_size / 1024, 1) }} MB
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            @if($existingDocument)
                                <div class="alert alert-info mb-2">
                                    <small>
                                        <i class="fas fa-file me-1"></i>
                                        <strong>File saat ini:</strong> {{ $existingDocument->file_name }}
                                        ({{ $existingDocument->file_size_human }})
                                        <a href="{{ $existingDocument->file_url }}" target="_blank" class="ms-2">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </small>
                                </div>
                            @endif
                            
                            <div class="input-group">
                                <input type="file" 
                                       class="form-control @error('documents.' . $requirement->id) is-invalid @enderror" 
                                       name="documents[{{ $requirement->id }}]" 
                                       id="document_{{ $requirement->id }}"
                                       accept="{{ $requirement->file_types ? '.' . str_replace(',', ',.', $requirement->file_types) : '*' }}">
                                <button class="btn btn-outline-secondary" type="button" 
                                        onclick="document.getElementById('document_{{ $requirement->id }}').click()">
                                    <i class="fas fa-folder-open"></i>
                                </button>
                            </div>
                            
                            @error('documents.' . $requirement->id)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                @if($existingDocument)
                                    Upload file baru untuk mengganti file yang ada, atau biarkan kosong untuk mempertahankan file saat ini.
                                @else
                                    Pilih file yang sesuai dengan persyaratan di atas.
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('submissions.show', $submission->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-paper-plane me-1"></i>
                            Submit Ulang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Pengajuan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>No. Pengajuan:</strong></td>
                        <td>{{ $submission->submission_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Ujian:</strong></td>
                        <td>{{ $submission->examType->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge bg-danger status-badge">
                                <i class="fas fa-times me-1"></i>
                                Berkas Ditolak
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Submit:</strong></td>
                        <td>{{ $submission->submitted_at ? $submission->submitted_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips Revisi
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Perbaiki dokumen sesuai alasan revisi
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Pastikan format file sesuai persyaratan
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Ukuran file tidak melebihi batas maksimal
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        File tidak rusak dan dapat dibuka
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-1"></i>
                        Setelah submit ulang, status akan kembali "Menunggu Verifikasi"
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview file name when selected
    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Pilih file...';
            const nextElement = this.nextElementSibling;
            if (nextElement && nextElement.tagName === 'BUTTON') {
                nextElement.textContent = fileName.length > 20 ? fileName.substring(0, 20) + '...' : fileName;
            }
        });
    });
</script>
@endpush
