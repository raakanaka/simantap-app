@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-eye me-2"></i>Detail Pengajuan
            </h2>
            <div>
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                @if($submission->status === 'menunggu_verifikasi')
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verifyModal">
                        <i class="fas fa-check me-2"></i>Verifikasi
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Submission Information -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pengajuan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>No. Pengajuan:</strong></td>
                        <td><span class="badge bg-primary">{{ $submission->submission_number }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Ujian:</strong></td>
                        <td>{{ $submission->examType->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($submission->status === 'menunggu_verifikasi')
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                </span>
                            @elseif($submission->status === 'berkas_diterima')
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Berkas Diterima
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times me-1"></i>Berkas Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Submit:</strong></td>
                        <td>{{ $submission->submitted_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($submission->verified_at)
                    <tr>
                        <td><strong>Tanggal Verifikasi:</strong></td>
                        <td>{{ $submission->verified_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Verifikator:</strong></td>
                        <td>{{ $submission->verifier->name ?? '-' }}</td>
                    </tr>
                    @endif
                    @if($submission->notes)
                    <tr>
                        <td><strong>Catatan:</strong></td>
                        <td>{{ $submission->notes }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Student Information -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Mahasiswa
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Nama:</strong></td>
                        <td>{{ $submission->student->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>NIM:</strong></td>
                        <td>{{ $submission->student->nim }}</td>
                    </tr>
                    <tr>
                        <td><strong>Program Studi:</strong></td>
                        <td>{{ $submission->student->study_program }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fakultas:</strong></td>
                        <td>{{ $submission->student->faculty }}</td>
                    </tr>
                    <tr>
                        <td><strong>Semester:</strong></td>
                        <td>{{ $submission->student->semester }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $submission->student->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $submission->student->phone }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Documents Review -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Dokumen Pengajuan
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
                                    <td>
                                        <strong>{{ $document->document_name }}</strong>
                                        @if($document->examRequirement->description)
                                            <br>
                                            <small class="text-muted">{{ $document->examRequirement->description }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ strtoupper($document->file_type) }}</span>
                                        <br>
                                        <small class="text-muted">{{ $document->file_name }}</small>
                                    </td>
                                    <td>{{ $document->file_size_human }}</td>
                                    <td>
                                        @if($document->status === 'uploaded')
                                            <span class="badge bg-warning">Uploaded</span>
                                        @elseif($document->status === 'verified')
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ $document->file_url }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada dokumen yang diupload</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Revision Reason (if rejected) -->
@if($submission->status === 'berkas_ditolak' && $submission->revision_reason)
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $submission->revision_reason }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Verification Modal -->
@if($submission->status === 'menunggu_verifikasi')
<div class="modal fade" id="verifyModal" tabindex="-1">
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide revision reason based on status selection
    const statusSelect = document.getElementById('status');
    const revisionDiv = document.getElementById('revisionReasonDiv');
    const revisionTextarea = document.getElementById('revision_reason');
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            if (this.value === 'berkas_ditolak') {
                revisionDiv.style.display = 'block';
                revisionTextarea.required = true;
            } else {
                revisionDiv.style.display = 'none';
                revisionTextarea.required = false;
            }
        });
    }
});
</script>
@endpush
