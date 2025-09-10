@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="flex h-screen bg-gray-50">
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo-simantap-small.png') }}" alt="SIMANTAP Logo" class="w-6 h-6 object-contain">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SIMANTAP</h2>
                    <p class="text-sm text-gray-600">Admin</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-list w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.students') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                    <span>Verifikasi Mahasiswa</span>
                </a>
                <a href="{{ route('admin.lecturers') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengolahan Akun</span>
                </a>
                <a href="{{ route('admin.study-programs') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Program Studi</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span>Pengaturan Akun</span>
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
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Pengaturan Akun</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">Selamat datang, {{ session('user_name') }}</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h2>
                </div>
                
                <!-- Profile Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Profil</h3>
                    <form action="{{ route('admin.settings.profile') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" value="{{ $admin->username }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500" readonly>
                                <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <input type="text" value="{{ ucfirst(str_replace('_', ' ', $admin->role)) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500" readonly>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ $admin->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" value="{{ $admin->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ $admin->phone }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <input type="text" value="{{ ucfirst($admin->status) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500" readonly>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $admin->address }}</textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Password</h3>
                    <form action="{{ route('admin.settings.password') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama *</label>
                                <input type="password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru *</label>
                                <input type="password" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru *</label>
                            <input type="password" name="new_password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div id="passwordStrength" class="hidden">
                            <div class="text-sm text-gray-600 mb-2">Kekuatan Password:</div>
                            <div class="flex space-x-1">
                                <div class="h-2 w-1/4 bg-gray-200 rounded" id="strength1"></div>
                                <div class="h-2 w-1/4 bg-gray-200 rounded" id="strength2"></div>
                                <div class="h-2 w-1/4 bg-gray-200 rounded" id="strength3"></div>
                                <div class="h-2 w-1/4 bg-gray-200 rounded" id="strength4"></div>
                            </div>
                            <div id="strengthText" class="text-sm mt-1"></div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                                <i class="fas fa-key mr-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dibuat</label>
                            <input type="text" value="{{ $admin->created_at->format('d/m/Y H:i') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500" readonly>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Terakhir Diperbarui</label>
                            <input type="text" value="{{ $admin->updated_at->format('d/m/Y H:i') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500" readonly>
        </main>

@push('scripts')
<script>
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
                    <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
    `;

    document.body.insertAdjacentHTML('beforeend', alertHTML);
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) alert.remove();
    }, 5000);
}

@if(session('success'))
showAlert('{{ session('success') }}', 'success');
@endif

@if(session('error'))
showAlert('{{ session('error') }}', 'danger');
@endif

// Password validation
document.addEventListener('DOMContentLoaded', function() {
    const passwordForm = document.querySelector('form[action="{{ route('admin.settings.password') }}"]');
    const newPassword = document.querySelector('input[name="new_password"]');
    const confirmPassword = document.querySelector('input[name="new_password_confirmation"]');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            if (newPassword.value !== confirmPassword.value) {
                e.preventDefault();
                showAlert('Konfirmasi password tidak sesuai dengan password baru!', 'danger');
                confirmPassword.focus();
                return false;
            }
            
            if (newPassword.value.length < 8) {
                e.preventDefault();
                showAlert('Password baru harus minimal 8 karakter!', 'danger');
                newPassword.focus();
                return false;
            }
        });
        
        // Real-time password confirmation validation
        confirmPassword.addEventListener('input', function() {
            if (this.value && newPassword.value && this.value !== newPassword.value) {
                this.setCustomValidity('Konfirmasi password tidak sesuai');
                this.classList.add('border-red-500');
            } else {
                this.setCustomValidity('');
                this.classList.remove('border-red-500');
            }
        });
        
        newPassword.addEventListener('input', function() {
            if (confirmPassword.value && this.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Konfirmasi password tidak sesuai');
                confirmPassword.classList.add('border-red-500');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('border-red-500');
            }
        });
    }
});
</script>
@endpush
@endsection
