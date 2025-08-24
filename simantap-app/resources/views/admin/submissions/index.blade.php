@extends('admin.layouts.app')

@section('title', 'Daftar Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-list me-2"></i>Daftar Pengajuan Ujian Akhir
            </h2>
            <a href="{{ route('admin.submissions.export') }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i>Export Laporan
            </a>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>Filter Pengajuan
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.submissions.index') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="berkas_diterima" {{ request('status') === 'berkas_diterima' ? 'selected' : '' }}>Berkas Diterima</option>
                        <option value="berkas_ditolak" {{ request('status') === 'berkas_ditolak' ? 'selected' : '' }}>Berkas Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="exam_type_id" class="form-label">Jenis Ujian</label>
                    <select name="exam_type_id" id="exam_type_id" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach($examTypes as $examType)
                            <option value="{{ $examType->id }}" {{ request('exam_type_id') == $examType->id ? 'selected' : '' }}>
                                {{ $examType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="date_from" class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="date_to" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Submissions Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-table me-2"></i>Data Pengajuan
            <span class="badge bg-primary ms-2">{{ $submissions->total() }} Total</span>
        </h5>
    </div>
    <div class="card-body">
        @if($submissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Pengajuan</th>
                            <th>Mahasiswa</th>
                            <th>Jenis Ujian</th>
                            <th>Status</th>
                            <th>Tanggal Submit</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr>
                            <td>
                                <span class="badge bg-primary">{{ $submission->submission_number }}</span>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $submission->student->name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-id-card me-1"></i>{{ $submission->student->nim }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-graduation-cap me-1"></i>{{ $submission->student->study_program }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $submission->examType->name }}</span>
                            </td>
                            <td>
                                @if($submission->status === 'menunggu_verifikasi')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($submission->status === 'berkas_diterima')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Diterima
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $submission->submitted_at->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $submission->submitted_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                @if($submission->verifier)
                                    <div>
                                        <strong>{{ $submission->verifier->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $submission->verified_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.submissions.show', $submission->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($submission->status === 'menunggu_verifikasi')
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-success" 
                                                title="Verifikasi"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#verifyModal{{ $submission->id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $submissions->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada pengajuan ditemukan</h5>
                <p class="text-muted">Coba ubah filter pencarian Anda</p>
            </div>
        @endif
    </div>
</div>

<!-- Verification Modals -->
@foreach($submissions as $submission)
    @if($submission->status === 'menunggu_verifikasi')
        <div class="modal fade" id="verifyModal{{ $submission->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle me-2"></i>Verifikasi Pengajuan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.submissions.verify', $submission->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>No. Pengajuan:</strong> {{ $submission->submission_number }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Mahasiswa:</strong> {{ $submission->student->name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Jenis Ujian:</strong> {{ $submission->examType->name }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Tanggal Submit:</strong> {{ $submission->submitted_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Verifikasi</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="">Pilih Status</option>
                                    <option value="berkas_diterima">Berkas Diterima</option>
                                    <option value="berkas_ditolak">Berkas Ditolak</option>
                                </select>
                            </div>
                            
                            <div class="mb-3" id="revisionReasonDiv" style="display: none;">
                                <label for="revision_reason" class="form-label">Alasan Revisi</label>
                                <textarea name="revision_reason" id="revision_reason" class="form-control" rows="3" 
                                          placeholder="Berikan alasan mengapa berkas ditolak..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="2" 
                                          placeholder="Catatan tambahan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide revision reason based on status selection
    const statusSelects = document.querySelectorAll('select[name="status"]');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const modal = this.closest('.modal');
            const revisionDiv = modal.querySelector('#revisionReasonDiv');
            const revisionTextarea = modal.querySelector('#revision_reason');
            
            if (this.value === 'berkas_ditolak') {
                revisionDiv.style.display = 'block';
                revisionTextarea.required = true;
            } else {
                revisionDiv.style.display = 'none';
                revisionTextarea.required = false;
            }
        });
    });
});
</script>
@endpush
