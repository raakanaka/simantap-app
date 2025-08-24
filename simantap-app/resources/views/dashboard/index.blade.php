@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard Mahasiswa
            </h2>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Pengajuan</h6>
                        <h3 class="mb-0">{{ $submissions->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Menunggu Verifikasi</h6>
                        <h3 class="mb-0">{{ $submissions->where('status', 'menunggu_verifikasi')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Diterima</h6>
                        <h3 class="mb-0">{{ $submissions->where('status', 'berkas_diterima')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informasi Mahasiswa
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>NIM:</strong></td>
                        <td>{{ $student->nim }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Program Studi:</strong></td>
                        <td>{{ $student->study_program }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fakultas:</strong></td>
                        <td>{{ $student->faculty }}</td>
                    </tr>
                    <tr>
                        <td><strong>Semester:</strong></td>
                        <td>{{ $student->semester }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $student->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Jenis Ujian Tersedia
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($examTypes as $examType)
                        <a href="{{ route('requirements', $examType->id) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $examType->name }}</h6>
                                <small class="text-muted">{{ $examType->description }}</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if($submissions->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Pengajuan Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pengajuan</th>
                                <th>Jenis Ujian</th>
                                <th>Status</th>
                                <th>Tanggal Submit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions->take(5) as $submission)
                                <tr>
                                    <td>{{ $submission->submission_number }}</td>
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
                                    <td>
                                        <a href="{{ route('submissions.show', $submission->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($submission->status == 'berkas_ditolak')
                                            <a href="{{ route('submissions.edit', $submission->id) }}" 
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($submissions->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('submissions.index') }}" class="btn btn-outline-primary">
                            Lihat Semua Pengajuan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection
