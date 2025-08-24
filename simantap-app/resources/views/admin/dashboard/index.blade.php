@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
        </h2>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $totalSubmissions }}</h4>
                        <p class="mb-0">Total Pengajuan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $pendingSubmissions }}</h4>
                        <p class="mb-0">Menunggu Verifikasi</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $acceptedSubmissions }}</h4>
                        <p class="mb-0">Diterima</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $rejectedSubmissions }}</h4>
                        <p class="mb-0">Ditolak</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Submissions -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Pengajuan Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recentSubmissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No. Pengajuan</th>
                                    <th>Mahasiswa</th>
                                    <th>Jenis Ujian</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubmissions as $submission)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $submission->submission_number }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $submission->student->name }}</strong><br>
                                        <small class="text-muted">{{ $submission->student->nim }}</small>
                                    </td>
                                    <td>{{ $submission->examType->name }}</td>
                                    <td>
                                        @if($submission->status === 'menunggu_verifikasi')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($submission->status === 'berkas_diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $submission->submitted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.submissions.show', $submission->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada pengajuan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Statistik Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Mahasiswa</span>
                        <strong>{{ $totalStudents }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Jenis Ujian</span>
                        <strong>{{ $totalExamTypes }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Menunggu Verifikasi</span>
                        <strong>{{ $pendingSubmissions }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: {{ $totalSubmissions > 0 ? ($pendingSubmissions / $totalSubmissions) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Diterima</span>
                        <strong>{{ $acceptedSubmissions }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: {{ $totalSubmissions > 0 ? ($acceptedSubmissions / $totalSubmissions) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Ditolak</span>
                        <strong>{{ $rejectedSubmissions }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: {{ $totalSubmissions > 0 ? ($rejectedSubmissions / $totalSubmissions) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-list me-2"></i>Lihat Semua Pengajuan
                </a>
                <a href="{{ route('admin.submissions.export') }}" class="btn btn-outline-success w-100 mb-2">
                    <i class="fas fa-download me-2"></i>Export Laporan
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-info w-100">
                    <i class="fas fa-users me-2"></i>Mode Mahasiswa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
