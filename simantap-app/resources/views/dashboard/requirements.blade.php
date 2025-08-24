@extends('layouts.app')

@section('title', 'Persyaratan Berkas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>
                    <i class="fas fa-file-alt me-2"></i>
                    Persyaratan Berkas
                </h2>
                <p class="text-muted mb-0">{{ $examType->name }}</p>
            </div>
            <a href="{{ route('exam-types') }}" class="btn btn-outline-secondary">
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
                    <i class="fas fa-list me-2"></i>
                    Daftar Persyaratan Berkas
                </h5>
            </div>
            <div class="card-body">
                @if($examType->requirements->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="30%">Nama Dokumen</th>
                                    <th width="40%">Deskripsi</th>
                                    <th width="15%">Tipe File</th>
                                    <th width="10%">Ukuran Max</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($examType->requirements->sortBy('order') as $index => $requirement)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $requirement->document_name }}</strong>
                                            @if($requirement->is_required)
                                                <span class="badge bg-danger ms-1">Wajib</span>
                                            @else
                                                <span class="badge bg-secondary ms-1">Opsional</span>
                                            @endif
                                        </td>
                                        <td>{{ $requirement->description }}</td>
                                        <td>
                                            @if($requirement->file_types)
                                                <span class="badge bg-info">{{ strtoupper($requirement->file_types) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($requirement->max_size)
                                                {{ number_format($requirement->max_size / 1024, 1) }} MB
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada persyaratan berkas</h5>
                        <p class="text-muted">Persyaratan berkas untuk jenis ujian ini belum ditentukan.</p>
                    </div>
                @endif
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
                
                <h6>Kode Ujian</h6>
                <p class="text-muted">{{ $examType->code }}</p>
                
                <hr>
                
                <h6>Total Persyaratan</h6>
                <p class="text-muted">{{ $examType->requirements->count() }} dokumen</p>
                
                <hr>
                
                <div class="d-grid">
                    <a href="{{ route('submissions.create', $examType->id) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>
                        Ajukan Ujian Ini
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips Upload
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Pastikan file dalam format yang sesuai
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Ukuran file tidak melebihi batas maksimal
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        File tidak rusak dan dapat dibuka
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Nama file tidak mengandung karakter khusus
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-1"></i>
                        Upload semua dokumen wajib sebelum submit
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
