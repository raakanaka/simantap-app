@extends('layouts.app')

@section('title', 'Pengolahan Akun Dosen')

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
                    <p class="text-sm text-gray-600">Admin Panel</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-list w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.students') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                    <span>Verifikasi Mahasiswa</span>
                </a>
                <a href="{{ route('admin.lecturers') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengolahan Akun</span>
                </a>
                <a href="{{ route('admin.study-programs') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Program Studi</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span>Pengaturan Akun</span>
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="sidebar-item w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pengolahan Akun Dosen</h1>
                    <p class="text-gray-600 mt-1">Kelola data dan akun dosen</p>
                </div>
                <button onclick="showAddLecturerModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Dosen</span>
                </button>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-6">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($lecturers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($lecturers as $lecturer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $lecturer->nip }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $lecturer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lecturer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lecturer->studyProgram->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lecturer->position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $lecturer->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($lecturer->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="showEditLecturerModal({{ $lecturer->id }}, '{{ $lecturer->nip }}', '{{ $lecturer->name }}', '{{ $lecturer->email }}', {{ $lecturer->study_program_id }}, '{{ $lecturer->position }}', '{{ $lecturer->status }}', '{{ $lecturer->expertise }}')" class="text-blue-600 hover:text-blue-900 text-sm px-3 py-1 rounded-md hover:bg-blue-50 transition duration-200">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    <button onclick="showDeleteLecturerModal({{ $lecturer->id }}, '{{ $lecturer->name }}')" class="text-red-600 hover:text-red-900 text-sm px-3 py-1 rounded-md hover:bg-red-50 transition duration-200">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada dosen</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan dosen pertama</p>
                <button onclick="showAddLecturerModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 mx-auto transition duration-200">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Dosen</span>
                </button>
            </div>
        @endif
            </div>
        </main>
    </div>
</div>

<!-- Add Lecturer Modal -->
<div id="addLecturerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Data Dosen</h3>
            <form action="{{ route('admin.lecturers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                    <input type="text" name="expertise" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <select name="study_program_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Program Studi</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <input type="text" name="position" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="hideAddLecturerModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Lecturer Modal -->
<div id="editLecturerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Data Dosen</h3>
            <form id="editLecturerForm" method="POST" class="space-y-4" onsubmit="return handleEditFormSubmit(event)">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" id="edit_nip" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                    <input type="text" name="expertise" id="edit_expertise" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <select name="study_program_id" id="edit_study_program_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Program Studi</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <input type="text" name="position" id="edit_position" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="edit_status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="hideEditLecturerModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition duration-200">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Lecturer Modal -->
<div id="deleteLecturerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Hapus Dosen</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus dosen <span id="deleteLecturerName" class="font-medium text-gray-900"></span>?</p>
                </div>
            </div>
            <div class="mt-5">
                <form id="deleteLecturerForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideDeleteLecturerModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-200">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition duration-200">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Add Lecturer Modal Functions
function showAddLecturerModal() {
    console.log('showAddLecturerModal called');
    document.getElementById('addLecturerModal').classList.remove('hidden');
}

function hideAddLecturerModal() {
    console.log('hideAddLecturerModal called');
    document.getElementById('addLecturerModal').classList.add('hidden');
}

// Edit Lecturer Modal Functions
function showEditLecturerModal(id, nip, name, email, studyProgramId, position, status, expertise) {
    console.log('showEditLecturerModal called with:', {id, nip, name, email, studyProgramId, position, status, expertise});
    
    // Set form action URL
    const actionUrl = '{{ route("admin.lecturers.update", ":id") }}'.replace(':id', id);
    console.log('Setting form action to:', actionUrl);
    document.getElementById('editLecturerForm').action = actionUrl;
    
    // Fill form fields
    document.getElementById('edit_nip').value = nip || '';
    document.getElementById('edit_name').value = name || '';
    document.getElementById('edit_email').value = email || '';
    document.getElementById('edit_study_program_id').value = studyProgramId || '';
    document.getElementById('edit_position').value = position || '';
    document.getElementById('edit_status').value = status || 'active';
    document.getElementById('edit_expertise').value = expertise || '';
    
    // Show modal
    document.getElementById('editLecturerModal').classList.remove('hidden');
    console.log('Modal should be visible now');
}

function hideEditLecturerModal() {
    console.log('hideEditLecturerModal called');
    document.getElementById('editLecturerModal').classList.add('hidden');
}

// Handle form submission
function handleEditFormSubmit(event) {
    console.log('Form submission started');
    console.log('Form action:', event.target.action);
    console.log('Form method:', event.target.method);
    
    // Collect form data
    const formData = new FormData(event.target);
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Let the form submit normally
    return true;
}

// Delete Lecturer Modal Functions
function showDeleteLecturerModal(id, name) {
    console.log('showDeleteLecturerModal called with:', {id, name});
    document.getElementById('deleteLecturerForm').action = '{{ route("admin.lecturers.destroy", ":id") }}'.replace(':id', id);
    document.getElementById('deleteLecturerName').textContent = name;
    document.getElementById('deleteLecturerModal').classList.remove('hidden');
}

function hideDeleteLecturerModal() {
    console.log('hideDeleteLecturerModal called');
    document.getElementById('deleteLecturerModal').classList.add('hidden');
}

// Alert function
function showAlert(message, type = 'info') {
    const alertColors = {
        success: 'bg-green-50 border-green-200 text-green-800',
        danger: 'bg-red-50 border-red-200 text-red-800',
        warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    const alertHTML = `
        <div class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="border rounded-lg p-4 ${alertColors[type]} shadow-lg" id="alert">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-3"></i>
                        <span class="font-medium">${message}</span>
                    </div>
                    <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', alertHTML);
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed')) {
        hideAddLecturerModal();
        hideEditLecturerModal();
        hideDeleteLecturerModal();
    }
});
</script>
@endsection