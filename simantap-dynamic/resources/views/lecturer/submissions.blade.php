@extends('layouts.app')

@section('title', 'Pengajuan Mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo-simantap-small.png') }}" alt="SIMANTAP Logo" class="w-6 h-6 object-contain">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SIMANTAP</h2>
                    <p class="text-sm text-gray-600">Dosen Panel</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('lecturer.dashboard') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('lecturer.submissions') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('lecturer.status') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-eye w-5 h-5 mr-3"></i>
                    <span>Status</span>
                </a>
                <a href="{{ route('lecturer.tasks') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tasks w-5 h-5 mr-3"></i>
                    <span>Tugas Dosen</span>
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-900">Pengajuan Mahasiswa</h1>
                <p class="text-gray-600">Kelola pengajuan ujian mahasiswa</p>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Filter & Pencarian</h2>
                </div>
                <div class="px-6 py-4">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Nama, NIM, atau judul..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="berkas_diterima" {{ request('status') == 'berkas_diterima' ? 'selected' : '' }}>Berkas Diterima</option>
                                <option value="berkas_ditolak" {{ request('status') == 'berkas_ditolak' ? 'selected' : '' }}>Berkas Ditolak</option>
                            </select>
                        </div>
                        
                        <!-- Exam Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Ujian</label>
                            <select name="exam_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Jenis</option>
                                @foreach($examTypes as $examType)
                                    <option value="{{ $examType->id }}" {{ request('exam_type') == $examType->id ? 'selected' : '' }}>
                                        {{ $examType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Date To -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Filter Buttons -->
                        <div class="lg:col-span-5 flex justify-end space-x-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('lecturer.submissions') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-times mr-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Pengajuan</h2>
                    <p class="text-sm text-gray-600">Total: {{ $submissions->count() }} pengajuan</p>
                </div>

                <!-- Bulk Actions -->
                <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Pilih Semua</span>
                            </label>
                            <span id="selectedCount" class="text-sm text-gray-500">0 dipilih</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="bulkApproveBtn" disabled class="bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                                <i class="fas fa-check mr-1"></i>Setujui Terpilih
                            </button>
                            <button id="bulkRejectBtn" disabled class="bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                                <i class="fas fa-times mr-1"></i>Tolak Terpilih
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAllHeader" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Ujian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($submissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_submissions[]" value="{{ $submission->id }}" 
                                               class="submission-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                               {{ $submission->status !== 'menunggu_verifikasi' ? 'disabled' : '' }}>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $submission->student->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $submission->student->nim }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $submission->examType->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($submission->status === 'menunggu_verifikasi')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @elseif($submission->status === 'berkas_diterima')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($submission->status === 'berkas_ditolak')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $submission->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $submission->documents->count() }} file
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                    <button onclick="showSubmissionDetailModal({{ $submission->id }}, '{{ $submission->student->name }}', '{{ $submission->student->nim }}', '{{ $submission->examType->name }}', '{{ $submission->status }}', '{{ $submission->created_at->format('d/m/Y H:i') }}', '{{ $submission->verified_by }}', '{{ $submission->verified_at ? $submission->verified_at->format('d/m/Y H:i') : '' }}', '{{ $submission->revision_reason }}', '{{ $submission->title ?? 'Tidak ada judul' }}', '{{ $submission->description ?? 'Tidak ada deskripsi' }}', {{ $submission->documents->count() }}, {{ json_encode($submission->documents->map(function($doc) { return ['id' => $doc->id, 'original_filename' => $doc->original_filename, 'file_path' => $doc->file_path, 'file_size' => $doc->file_size, 'mime_type' => $doc->mime_type]; })) }})" class="text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </button>
                                            @if($submission->status === 'menunggu_verifikasi')
                                                <form action="{{ route('lecturer.verify-submission', $submission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">
                                                        <i class="fas fa-check mr-1"></i>Setujui
                                                    </button>
                                                </form>
                                                <button onclick="showRejectModal({{ $submission->id }})" class="text-red-600 hover:text-red-900 text-sm">
                                                    <i class="fas fa-times mr-1"></i>Tolak
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada pengajuan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Submission Detail Modal -->
<div id="submissionDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Pengajuan</h3>
                <button onclick="hideSubmissionDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Informasi Dasar</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
                            <p id="detailStudentName" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIM</label>
                            <p id="detailStudentNim" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Ujian</label>
                            <p id="detailExamType" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <p id="detailStatus" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                            <p id="detailCreatedAt" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Diverifikasi Oleh</label>
                            <p id="detailVerifiedBy" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Verifikasi</label>
                            <p id="detailVerifiedAt" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                            <p id="detailRevisionReason" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Submission Details -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Detail Pengajuan</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Judul</label>
                            <p id="detailTitle" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                            <p id="detailDescription" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Jumlah Dokumen</label>
                            <p id="detailDocumentCount" class="text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Uploaded Documents -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Dokumen yang Di-upload</h4>
                    <div id="detailDocumentsList" class="space-y-2">
                        <!-- Documents will be populated by JavaScript -->
                    </div>
                    <div id="noDocumentsMessage" class="text-center py-4 text-gray-500 hidden">
                        <i class="fas fa-file-alt text-2xl mb-2"></i>
                        <p>Tidak ada dokumen yang di-upload</p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="hideSubmissionDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tolak Pengajuan</h3>
                <button onclick="hideRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="revision_reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Masukkan alasan penolakan..." required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideRejectModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Bulk Actions JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const selectAllHeaderCheckbox = document.getElementById('selectAllHeader');
        const submissionCheckboxes = document.querySelectorAll('.submission-checkbox');
        const selectedCountSpan = document.getElementById('selectedCount');
        const bulkApproveBtn = document.getElementById('bulkApproveBtn');
        const bulkRejectBtn = document.getElementById('bulkRejectBtn');

        // Select All functionality
        function updateSelectAll() {
            const checkedBoxes = document.querySelectorAll('.submission-checkbox:checked');
            const totalCheckboxes = document.querySelectorAll('.submission-checkbox:not([disabled])');
            
            selectedCountSpan.textContent = `${checkedBoxes.length} dipilih`;
            
            // Update bulk action buttons
            const hasSelection = checkedBoxes.length > 0;
            bulkApproveBtn.disabled = !hasSelection;
            bulkRejectBtn.disabled = !hasSelection;
            
            // Update select all checkboxes
            if (checkedBoxes.length === 0) {
                selectAllCheckbox.checked = false;
                selectAllHeaderCheckbox.checked = false;
            } else if (checkedBoxes.length === totalCheckboxes.length) {
                selectAllCheckbox.checked = true;
                selectAllHeaderCheckbox.checked = true;
            } else {
                selectAllCheckbox.checked = false;
                selectAllHeaderCheckbox.checked = false;
            }
        }

        // Select all checkboxes
        selectAllCheckbox.addEventListener('change', function() {
            submissionCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = this.checked;
                }
            });
            updateSelectAll();
        });

        selectAllHeaderCheckbox.addEventListener('change', function() {
            submissionCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = this.checked;
                }
            });
            updateSelectAll();
        });

        // Individual checkbox change
        submissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAll);
        });

        // Bulk approve
        bulkApproveBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.submission-checkbox:checked'))
                .map(checkbox => checkbox.value);
            
            if (selectedIds.length === 0) {
                alert('Pilih minimal satu pengajuan');
                return;
            }

            if (confirm(`Apakah Anda yakin ingin menyetujui ${selectedIds.length} pengajuan?`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("lecturer.bulk-approve") }}';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add selected IDs
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'submission_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Bulk reject
        bulkRejectBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.submission-checkbox:checked'))
                .map(checkbox => checkbox.value);
            
            if (selectedIds.length === 0) {
                alert('Pilih minimal satu pengajuan');
                return;
            }

            const reason = prompt(`Masukkan alasan penolakan untuk ${selectedIds.length} pengajuan:`);
            if (reason && reason.trim() !== '') {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("lecturer.bulk-reject") }}';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add reason
                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'revision_reason';
                reasonInput.value = reason;
                form.appendChild(reasonInput);
                
                // Add selected IDs
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'submission_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Initialize
        updateSelectAll();
    });

    function showSubmissionDetailModal(id, studentName, studentNim, examType, status, createdAt, verifiedBy, verifiedAt, revisionReason, title, description, documentCount, documents) {
        console.log('showSubmissionDetailModal called with:', {id, studentName, studentNim, examType, status, createdAt, verifiedBy, verifiedAt, revisionReason, title, description, documentCount, documents});
        
        // Set current submission ID for document context
        setCurrentDocumentContext(id, null);
        
        // Fill basic info
        document.getElementById('detailStudentName').textContent = studentName || 'Tidak ada data';
        document.getElementById('detailStudentNim').textContent = studentNim || 'Tidak ada data';
        document.getElementById('detailExamType').textContent = examType || 'Tidak ada data';
        document.getElementById('detailCreatedAt').textContent = createdAt || 'Tidak ada data';
        document.getElementById('detailVerifiedBy').textContent = verifiedBy || '-';
        document.getElementById('detailVerifiedAt').textContent = verifiedAt || '-';
        document.getElementById('detailRevisionReason').textContent = revisionReason || '-';
        
        // Fill submission details
        document.getElementById('detailTitle').textContent = title || 'Tidak ada judul';
        document.getElementById('detailDescription').textContent = description || 'Tidak ada deskripsi';
        document.getElementById('detailDocumentCount').textContent = (documentCount || 0) + ' file';
        
        // Fill status with proper styling
        let statusText = '';
        let statusClass = '';
        switch(status) {
            case 'menunggu_verifikasi':
                statusText = 'Menunggu Verifikasi';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                break;
            case 'berkas_diterima':
                statusText = 'Berkas Diterima';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                break;
            case 'berkas_ditolak':
                statusText = 'Berkas Ditolak';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                break;
            default:
                statusText = status || 'Tidak diketahui';
                statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        }
        
        const statusElement = document.getElementById('detailStatus');
        if (statusElement) {
            statusElement.innerHTML = `<span class="${statusClass}">${statusText}</span>`;
        }
        
        // Display documents
        displayDocuments(documents || []);
        
        document.getElementById('submissionDetailModal').classList.remove('hidden');
    }

    function hideSubmissionDetailModal() {
        document.getElementById('submissionDetailModal').classList.add('hidden');
    }

    function showRejectModal(submissionId) {
        document.getElementById('rejectForm').action = '{{ route("lecturer.reject-submission", ":id") }}'.replace(':id', submissionId);
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    // Function to display documents
    function displayDocuments(documents) {
        console.log('Displaying documents:', documents);
        
        const documentsList = document.getElementById('detailDocumentsList');
        const noDocumentsMessage = document.getElementById('noDocumentsMessage');
        
        if (!documentsList || !noDocumentsMessage) {
            console.error('Document elements not found');
            return;
        }
        
        // Clear previous content
        documentsList.innerHTML = '';
        
        if (!documents || documents.length === 0) {
            // Show no documents message
            noDocumentsMessage.classList.remove('hidden');
            documentsList.classList.add('hidden');
        } else {
            // Hide no documents message
            noDocumentsMessage.classList.add('hidden');
            documentsList.classList.remove('hidden');
            
            // Display each document
            documents.forEach((doc, index) => {
                const documentItem = createDocumentItem(doc, index);
                documentsList.appendChild(documentItem);
            });
        }
    }

    // Function to create document item
    function createDocumentItem(doc, index) {
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200';
        
        // Get file icon based on mime type
        const fileIcon = getFileIcon(doc.mime_type);
        const fileSize = formatFileSize(doc.file_size);
        
        div.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <i class="${fileIcon} text-2xl text-gray-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">${doc.original_filename}</p>
                    <p class="text-xs text-gray-500">${fileSize} • ${doc.mime_type}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="setCurrentDocumentContext(${getCurrentSubmissionId()}, ${doc.id}); downloadDocument('${doc.file_path}', '${doc.original_filename}')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <i class="fas fa-download mr-1"></i>Download
                </button>
                <button onclick="setCurrentDocumentContext(${getCurrentSubmissionId()}, ${doc.id}); previewDocument('${doc.file_path}', '${doc.original_filename}', '${doc.mime_type}')" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    <i class="fas fa-eye mr-1"></i>Preview
                </button>
            </div>
        `;
        
        return div;
    }

    // Function to get file icon based on mime type
    function getFileIcon(mimeType) {
        if (mimeType.includes('pdf')) {
            return 'fas fa-file-pdf text-red-500';
        } else if (mimeType.includes('word') || mimeType.includes('document')) {
            return 'fas fa-file-word text-blue-500';
        } else if (mimeType.includes('image')) {
            return 'fas fa-file-image text-green-500';
        } else if (mimeType.includes('text')) {
            return 'fas fa-file-alt text-gray-500';
        } else {
            return 'fas fa-file text-gray-500';
        }
    }

    // Function to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Function to download document
    function downloadDocument(filePath, originalFilename) {
        console.log('Downloading document:', filePath, originalFilename);
        // Use the lecturer download route
        const link = document.createElement('a');
        link.href = `/lecturer/submissions/${getCurrentSubmissionId()}/documents/${getCurrentDocumentId()}/download`;
        link.download = originalFilename;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Function to preview document
    function previewDocument(filePath, originalFilename, mimeType) {
        console.log('Previewing document:', filePath, originalFilename, mimeType);
        
        if (mimeType.includes('pdf')) {
            // For PDF, use lecturer download route to open in new tab
            const link = document.createElement('a');
            link.href = `/lecturer/submissions/${getCurrentSubmissionId()}/documents/${getCurrentDocumentId()}/download`;
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else if (mimeType.includes('image')) {
            // For images, we need to create a blob URL from the download
            previewImageFromDownload(filePath, originalFilename);
        } else {
            // For other file types, try to download
            downloadDocument(filePath, originalFilename);
        }
    }

    // Helper functions to get current submission and document IDs
    let currentSubmissionId = null;
    let currentDocumentId = null;

    function setCurrentDocumentContext(submissionId, documentId) {
        currentSubmissionId = submissionId;
        currentDocumentId = documentId;
    }

    function getCurrentSubmissionId() {
        return currentSubmissionId;
    }

    function getCurrentDocumentId() {
        return currentDocumentId;
    }

    // Function to preview image from download
    function previewImageFromDownload(filePath, originalFilename) {
        // For images, we'll use the lecturer download route to get the file and create a blob URL
        fetch(`/lecturer/submissions/${getCurrentSubmissionId()}/documents/${getCurrentDocumentId()}/download`)
            .then(response => response.blob())
            .then(blob => {
                const imageUrl = URL.createObjectURL(blob);
                showImagePreview(imageUrl, originalFilename);
            })
            .catch(error => {
                console.error('Error loading image:', error);
                alert('Gagal memuat gambar');
            });
    }

    // Function to show image preview
    function showImagePreview(imagePath, filename) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="max-w-4xl max-h-full p-4">
                <div class="bg-white rounded-lg overflow-hidden">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">${filename}</h3>
                        <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <img src="${imagePath}" alt="${filename}" class="max-w-full max-h-96 mx-auto">
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Close on click outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }

    // Close modals when clicking outside
    document.getElementById('submissionDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideSubmissionDetailModal();
        }
    });

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideRejectModal();
        }
    });
</script>
@endpush
@endsection
