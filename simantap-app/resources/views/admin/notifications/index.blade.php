@extends('admin.layouts.app')

@section('title', 'Manajemen Notifikasi')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-bell me-2"></i>Manajemen Notifikasi
        </h2>
    </div>
</div>

<!-- Send Notification -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Notifikasi
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.notifications.bulk') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_ids" class="form-label">Pilih Mahasiswa</label>
                            <select name="student_ids[]" id="student_ids" class="form-select" multiple required>
                                @foreach(\App\Models\Student::all() as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->nim }} - {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Gunakan Ctrl/Cmd untuk memilih multiple mahasiswa</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipe Notifikasi</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">Pilih Tipe</option>
                                <option value="info">Informasi</option>
                                <option value="warning">Peringatan</option>
                                <option value="success">Sukses</option>
                                <option value="danger">Penting</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan Notifikasi</label>
                        <textarea name="message" id="message" class="form-control" rows="4" 
                                  placeholder="Tulis pesan notifikasi..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Notifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Notifikasi
                </h5>
                <form method="POST" action="{{ route('admin.notifications.readAll') }}" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-check-double me-1"></i>Tandai Semua Dibaca
                    </button>
                </form>
            </div>
            <div class="card-body">
                @if($notifications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Pesan</th>
                                    <th>Tipe</th>
                                    <th>Admin</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr class="{{ $notification->read_at ? '' : 'table-warning' }}">
                                    <td>
                                        @php
                                            $student = \App\Models\Student::find($notification->notifiable_id);
                                        @endphp
                                        @if($student)
                                            <strong>{{ $student->name }}</strong><br>
                                            <small class="text-muted">{{ $student->nim }}</small>
                                        @else
                                            <span class="text-muted">Mahasiswa tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;" title="{{ $notification->data['message'] }}">
                                            {{ $notification->data['message'] }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $type = $notification->data['type'] ?? 'info';
                                            $typeLabels = [
                                                'info' => ['label' => 'Info', 'class' => 'bg-info'],
                                                'warning' => ['label' => 'Peringatan', 'class' => 'bg-warning'],
                                                'success' => ['label' => 'Sukses', 'class' => 'bg-success'],
                                                'danger' => ['label' => 'Penting', 'class' => 'bg-danger'],
                                            ];
                                        @endphp
                                        <span class="badge {{ $typeLabels[$type]['class'] }}">
                                            {{ $typeLabels[$type]['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $notification->data['admin_name'] ?? 'Admin' }}</small>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $notification->created_at->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $notification->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($notification->read_at)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Dibaca
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Belum Dibaca
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$notification->read_at)
                                            <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Tandai Dibaca">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada notifikasi</h5>
                        <p class="text-muted">Belum ada notifikasi yang dikirim</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Send Notification to Specific Student -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Kirim Notifikasi ke Mahasiswa Tertentu
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(\App\Models\Student::take(6)->get() as $student)
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $student->name }}</h6>
                                <p class="card-text text-muted">{{ $student->nim }}</p>
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#sendNotificationModal{{ $student->id }}">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim Notifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Send Notification Modals -->
@foreach(\App\Models\Student::take(6)->get() as $student)
<div class="modal fade" id="sendNotificationModal{{ $student->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Notifikasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.notifications.send', 1) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mahasiswa</label>
                        <input type="text" class="form-control" value="{{ $student->name }} ({{ $student->nim }})" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="type{{ $student->id }}" class="form-label">Tipe Notifikasi</label>
                        <select name="type" id="type{{ $student->id }}" class="form-select" required>
                            <option value="">Pilih Tipe</option>
                            <option value="info">Informasi</option>
                            <option value="warning">Peringatan</option>
                            <option value="success">Sukses</option>
                            <option value="danger">Penting</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message{{ $student->id }}" class="form-label">Pesan</label>
                        <textarea name="message" id="message{{ $student->id }}" class="form-control" rows="4" 
                                  placeholder="Tulis pesan notifikasi..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize select2 for multiple student selection
    const studentSelect = document.getElementById('student_ids');
    if (studentSelect) {
        // You can add select2 library here if needed
        // $(studentSelect).select2();
    }
});
</script>
@endpush
