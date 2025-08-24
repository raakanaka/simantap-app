@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>
                    <i class="fas fa-file-alt me-2"></i>
                    Detail Pengajuan
                </h2>
                <p class="text-muted mb-0">{{ $submission->submission_number }}</p>
            </div>
            <a href="{{ route('submissions.index') }}" class="btn btn-outline-secondary">
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
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Pengajuan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>No. Pengajuan:</strong></td>
                                <td>{{ $submission->submission_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Ujian:</strong></td>
                                <td>{{ $submission->examType->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($submission->status == 'menunggu_verifikasi')
                                        <span class="badge bg-warning status-badge">
                                            <i class="fas fa-clock me-1"></i>
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($submission->status == 'berkas_diterima')
                                        <span class="badge bg-success status-badge">
                                            <i class="fas fa-check me-1"></i>
                                            Berkas Diterima
                                        </span>
                                    @elseif($submission->status == 'berkas_ditolak')
                                        <span class="badge bg-danger status-badge">
                                            <i class="fas fa-times me-1"></i>
                                            Berkas Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Submit:</strong></td>
                                <td>{{ $submission->submitted_at ? $submission->submitted_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Diverifikasi Oleh:</strong></td>
                                <td>{{ $submission->verifier ? $submission->verifier->name : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Verifikasi:</strong></td>
                                <td>{{ $submission->verified_at ? $submission->verified_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Dokumen:</strong></td>
                                <td>{{ $submission->documents->count() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($submission->revision_reason)
                    <hr>
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-1"></i>Alasan Revisi:</h6>
                        <p class="mb-0">{{ $submission->revision_reason }}</p>
                    </div>
                @endif

                @if($submission->notes)
                    <hr>
                    <div class="alert alert-info">
                        <h6><i class="fas fa-sticky-note me-1"></i>Catatan:</h6>
                        <p class="mb-0">{{ $submission->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file me-2"></i>
                    Dokumen yang Diupload
                </h5>
            </div>
            <div class="card-body">
                @if($submission->documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Dokumen</th>
                                    <th>File</th>
                                    <th>Ukuran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submission->documents as $index => $document)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $document->document_name }}</td>
                                        <td>{{ $document->file_name }}</td>
                                        <td>{{ $document->file_size_human }}</td>
                                        <td>
                                            @if($document->status == 'uploaded')
                                                <span class="badge bg-secondary">Uploaded</span>
                                            @elseif($document->status == 'verified')
                                                <span class="badge bg-success">Verified</span>
                                            @elseif($document->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ $document->file_url }}" 
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @if($document->rejection_reason)
                                        <tr>
                                            <td colspan="6">
                                                <div class="alert alert-danger mb-0">
                                                    <small>
                                                        <strong>Alasan Penolakan:</strong> {{ $document->rejection_reason }}
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada dokumen</h5>
                        <p class="text-muted">Dokumen untuk pengajuan ini belum diupload.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Aksi
                </h5>
            </div>
            <div class="card-body">
                @if($submission->status == 'berkas_ditolak')
                    <div class="d-grid mb-3">
                        <a href="{{ route('submissions.edit', $submission->id) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>
                            Edit & Submit Ulang
                        </a>
                    </div>
                @endif
                
                <div class="d-grid">
                    <a href="{{ route('submissions.index') }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-list me-1"></i>
                        Lihat Semua Pengajuan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Status Pengajuan
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Menunggu Verifikasi</h6>
                    <p class="text-muted small">Pengajuan sedang dalam proses pemeriksaan oleh dosen atau admin.</p>
                </div>
                
                <div class="mb-3">
                    <h6>Berkas Diterima</h6>
                    <p class="text-muted small">Pengajuan diterima dan siap untuk dilanjutkan ke proses selanjutnya.</p>
                </div>
                
                <div class="mb-3">
                    <h6>Berkas Ditolak</h6>
                    <p class="text-muted small">Pengajuan ditolak karena ada kekurangan atau kesalahan pada berkas.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
