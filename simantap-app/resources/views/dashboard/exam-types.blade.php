@extends('layouts.app')

@section('title', 'Jenis Ujian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-list me-2"></i>
                Jenis Ujian Tersedia
            </h2>
        </div>
    </div>
</div>

<div class="row">
    @foreach($examTypes as $examType)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        {{ $examType->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $examType->description }}</p>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-tag me-1"></i>
                            Kode: <strong>{{ $examType->code }}</strong>
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-file-alt me-1"></i>
                            Total Persyaratan: <strong>{{ $examType->requirements->count() }} dokumen</strong>
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Dokumen Wajib: <strong>{{ $examType->requirements->where('is_required', true)->count() }} dokumen</strong>
                        </small>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-grid">
                        <a href="{{ route('requirements', $examType->id) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Persyaratan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($examTypes->count() == 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-graduation-cap fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada jenis ujian</h4>
                    <p class="text-muted">Jenis ujian belum ditentukan oleh admin.</p>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Jenis Ujian
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>1. Ujian Komprehensif</h6>
                        <p class="text-muted small">Ujian komprehensif untuk menguji pemahaman mahasiswa terhadap mata kuliah yang telah dipelajari.</p>
                        
                        <h6>2. Seminar Proposal Draf Artikel Jurnal Ilmiah</h6>
                        <p class="text-muted small">Seminar proposal untuk draf artikel jurnal ilmiah.</p>
                        
                        <h6>3. Seminar Proposal Skripsi</h6>
                        <p class="text-muted small">Seminar proposal skripsi.</p>
                    </div>
                    <div class="col-md-6">
                        <h6>4. Sidang Kolokium Jurnal</h6>
                        <p class="text-muted small">Sidang kolokium untuk jurnal.</p>
                        
                        <h6>5. Sidang Munaqasyah Skripsi</h6>
                        <p class="text-muted small">Sidang munaqasyah untuk skripsi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
