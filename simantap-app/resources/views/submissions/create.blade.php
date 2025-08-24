@extends('layouts.app')

@section('title', 'Upload Berkas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>
                    <i class="fas fa-upload me-2"></i>
                    Upload Berkas Pengajuan
                </h2>
                <p class="text-muted mb-0">{{ $examType->name }}</p>
            </div>
            <a href="{{ route('requirements', $examType->id) }}" class="btn btn-outline-secondary">
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
                    <i class="fas fa-file-upload me-2"></i>
                    Upload Dokumen Persyaratan
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

                <form action="{{ route('submissions.store', $examType->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @foreach($examType->requirements->sortBy('order') as $requirement)
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
                            
                            <div class="input-group">
                                <input type="file" 
                                       class="form-control @error('documents.' . $requirement->id) is-invalid @enderror" 
                                       name="documents[{{ $requirement->id }}]" 
                                       id="document_{{ $requirement->id }}"
                                       accept="{{ $requirement->file_types ? '.' . str_replace(',', ',.', $requirement->file_types) : '*' }}"
                                       @if($requirement->is_required) required @endif>
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
                                Pilih file yang sesuai dengan persyaratan di atas
                            </div>
                        </div>
                    @endforeach
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('requirements', $examType->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>
                            Submit Pengajuan
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
                    Informasi Ujian
                </h5>
            </div>
            <div class="card-body">
                <h6>{{ $examType->name }}</h6>
                <p class="text-muted">{{ $examType->description }}</p>
                
                <hr>
                
                <h6>Total Persyaratan</h6>
                <p class="text-muted">{{ $examType->requirements->count() }} dokumen</p>
                
                <h6>Dokumen Wajib</h6>
                <p class="text-muted">{{ $examType->requirements->where('is_required', true)->count() }} dokumen</p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Penting!
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Pastikan semua dokumen wajib diupload
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        File dalam format yang sesuai
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Ukuran file tidak melebihi batas
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        File tidak rusak dan dapat dibuka
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-1"></i>
                        Setelah submit, pengajuan akan diverifikasi
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
