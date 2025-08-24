@extends('admin.layouts.app')

@section('title', 'Laporan Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-chart-bar me-2"></i>Laporan Pengajuan
        </h2>
    </div>
</div>

<!-- Report Cards -->
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

<!-- Report Types -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Laporan Berdasarkan Status
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('admin.reports.accepted') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Laporan Pengajuan Diterima
                        </div>
                        <span class="badge bg-success rounded-pill">{{ $acceptedSubmissions }}</span>
                    </a>
                    <a href="{{ route('admin.reports.rejected') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            Laporan Pengajuan Ditolak
                        </div>
                        <span class="badge bg-danger rounded-pill">{{ $rejectedSubmissions }}</span>
                    </a>
                    <a href="{{ route('admin.reports.pending') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-clock text-warning me-2"></i>
                            Laporan Pengajuan Menunggu
                        </div>
                        <span class="badge bg-warning rounded-pill">{{ $pendingSubmissions }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-download me-2"></i>Export Laporan
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('admin.reports.exportAccepted') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-csv text-success me-2"></i>
                        Export Laporan Diterima (CSV)
                    </a>
                    <a href="{{ route('admin.reports.exportRejected') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-csv text-danger me-2"></i>
                        Export Laporan Ditolak (CSV)
                    </a>
                    <a href="{{ route('admin.reports.exportPending') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-csv text-warning me-2"></i>
                        Export Laporan Menunggu (CSV)
                    </a>
                    <a href="{{ route('admin.reports.exportAll') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-csv text-primary me-2"></i>
                        Export Semua Laporan (CSV)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
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

<!-- Recent Submissions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Pengajuan Terbaru
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
</div>
@endsection
