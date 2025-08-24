@extends('lecturer.layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Dosen
        </h2>
        <p class="text-muted">
            Selamat datang, {{ $lecturer->name }}! Program Studi: {{ $lecturer->study_program }}
        </p>
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
                                        <a href="{{ route('lecturer.submissions.show', $submission->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Lihat
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
                    <i class="fas fa-chart-pie me-2"></i>Statistik Program Studi
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
                <a href="{{ route('lecturer.submissions.index') }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-list me-2"></i>Lihat Semua Pengajuan
                </a>
                <a href="{{ route('lecturer.tasks') }}" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-tasks me-2"></i>Tugas yang Menunggu
                </a>
                <a href="{{ route('lecturer.status') }}" class="btn btn-info w-100">
                    <i class="fas fa-chart-bar me-2"></i>Status Pengajuan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics by Exam Type -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Pengajuan Berdasarkan Jenis Ujian
                </h5>
            </div>
            <div class="card-body">
                @if($submissionsByType->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jenis Ujian</th>
                                    <th>Jumlah</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissionsByType as $type)
                                <tr>
                                    <td>{{ $type->examType->name }}</td>
                                    <td>{{ $type->total }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: {{ $totalSubmissions > 0 ? ($type->total / $totalSubmissions) * 100 : 0 }}%">
                                                {{ number_format($totalSubmissions > 0 ? ($type->total / $totalSubmissions) * 100 : 0, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Pengajuan Berdasarkan Status
                </h5>
            </div>
            <div class="card-body">
                @if($submissionsByStatus->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissionsByStatus as $status)
                                <tr>
                                    <td>
                                        @if($status->status === 'menunggu_verifikasi')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($status->status === 'berkas_diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $status->total }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($status->status === 'menunggu_verifikasi') bg-warning
                                                @elseif($status->status === 'berkas_diterima') bg-success
                                                @else bg-danger
                                                @endif" 
                                                style="width: {{ $totalSubmissions > 0 ? ($status->total / $totalSubmissions) * 100 : 0 }}%">
                                                {{ number_format($totalSubmissions > 0 ? ($status->total / $totalSubmissions) * 100 : 0, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
