@extends('layouts.app')

@section('title', 'Pengajuan Saya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-file-alt me-2"></i>
                Pengajuan Saya
            </h2>
            <a href="{{ route('exam-types') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Buat Pengajuan Baru
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Daftar Pengajuan
                </h5>
            </div>
            <div class="card-body">
                @if($submissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No. Pengajuan</th>
                                    <th>Jenis Ujian</th>
                                    <th>Status</th>
                                    <th>Tanggal Submit</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                    <tr>
                                        <td>
                                            <strong>{{ $submission->submission_number }}</strong>
                                        </td>
                                        <td>{{ $submission->examType->name }}</td>
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
                                        <td>{{ $submission->submitted_at ? $submission->submitted_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>{{ $submission->verified_at ? $submission->verified_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('submissions.show', $submission->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($submission->status == 'berkas_ditolak')
                                                    <a href="{{ route('submissions.edit', $submission->id) }}" 
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Edit & Submit Ulang">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @if($submission->revision_reason)
                                        <tr>
                                            <td colspan="6">
                                                <div class="alert alert-warning mb-0">
                                                    <small>
                                                        <strong><i class="fas fa-exclamation-triangle me-1"></i>Alasan Revisi:</strong> 
                                                        {{ $submission->revision_reason }}
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $submissions->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Belum ada pengajuan</h4>
                        <p class="text-muted mb-4">Anda belum membuat pengajuan ujian akhir.</p>
                        <a href="{{ route('exam-types') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Buat Pengajuan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h5>Menunggu Verifikasi</h5>
                <h3>{{ $submissions->where('status', 'menunggu_verifikasi')->count() }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h5>Diterima</h5>
                <h3>{{ $submissions->where('status', 'berkas_diterima')->count() }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x mb-2"></i>
                <h5>Ditolak</h5>
                <h3>{{ $submissions->where('status', 'berkas_ditolak')->count() }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
