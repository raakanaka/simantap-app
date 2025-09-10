@extends('layouts.app')

@section('title', 'Login & Registrasi Mahasiswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <!-- Logo -->
            <div class="flex justify-center mb-4">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <img src="{{ asset('images/logo-simantap.png') }}" alt="SIMANTAP Logo" class="w-16 h-16 object-contain">
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">SIMANTAP</h2>
            <p class="text-gray-600 text-sm">Sistem Informasi Manajemen Terintegrasi</p>
            <h3 class="text-xl font-semibold text-gray-800 mt-4">Mahasiswa</h3>
            <p class="text-gray-500 text-sm">Login atau daftar akun untuk mengakses sistem ujian</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Tab Navigation -->
            <div class="flex space-x-1 mb-6 bg-gray-100 p-1 rounded-lg">
                <button id="registerTab" onclick="switchTab('register')" class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition duration-200 bg-white text-blue-600 shadow-sm">
                    Daftar Akun
                </button>
                <button id="loginTab" onclick="switchTab('login')" class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition duration-200 text-gray-500 hover:text-gray-700">
                    Login
                </button>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-1"></i>
                        <div>
                            <h4 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h4>
                            <ul class="text-sm text-red-700 mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                        <div>
                            <h4 class="text-sm font-medium text-green-800">Berhasil</h4>
                            <p class="text-sm text-green-700 mt-1">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Register Form -->
            <div id="registerForm" class="space-y-6">
                <form action="{{ route('student.register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Informasi Pribadi</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIM *</label>
                                <input type="text" name="nim" value="{{ old('nim') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi *</label>
                            <select name="study_program_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach($studyPrograms as $program)
                                    <option value="{{ $program->id }}" {{ old('study_program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }} ({{ $program->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Informasi Akun</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                            <div class="relative">
                                <input type="password" name="password" id="regPassword" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <button type="button" onclick="togglePassword('regPassword')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="regPasswordToggle"></i>
                                </button>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Minimal 8 karakter</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password *</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="regPasswordConfirmation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <button type="button" onclick="togglePassword('regPasswordConfirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="regPasswordConfirmationToggle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KTM Upload -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Upload KTM</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kartu Tanda Mahasiswa (KTM) *</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition duration-200" id="ktmUploadArea">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="ktm_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file KTM</span>
                                            <input id="ktm_file" name="ktm_file" type="file" accept="image/*,.pdf" class="sr-only" required>
                                        </label>
                                        <p class="pl-1">atau drag & drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF maksimal 2MB</p>
                                </div>
                            </div>
                            <div id="ktmPreview" class="mt-2 hidden">
                                <div class="flex items-center space-x-2 p-2 bg-green-50 border border-green-200 rounded-lg">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    <span class="text-sm text-green-700" id="ktmFileName"></span>
                                    <button type="button" onclick="removeKTMFile()" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-600">
                                Saya menyetujui <a href="#" class="text-blue-600 hover:text-blue-500">Syarat dan Ketentuan</a> serta <a href="#" class="text-blue-600 hover:text-blue-500">Kebijakan Privasi</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Akun
                        </button>
                    </div>
                </form>
            </div>

            <!-- Login Form -->
            <div id="loginForm" class="space-y-6 hidden">
                <form action="{{ route('student.login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="login_field" class="block text-sm font-medium text-gray-700 mb-2">NIM atau Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="login_field" name="login_field" value="{{ old('login_field') }}" 
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Masukkan NIM atau Email Anda" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" 
                                   class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Masukkan password Anda" required>
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="passwordToggle"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
                <div>
                    <h4 class="text-sm font-medium text-blue-800">Informasi Penting</h4>
                    <ul class="text-sm text-blue-700 mt-1 list-disc list-inside space-y-1">
                        <li>Login menggunakan NIM atau Email yang terdaftar</li>
                        <li>Akun akan diverifikasi oleh admin setelah upload KTM</li>
                        <li>Pastikan KTM yang diupload jelas dan terbaca</li>
                        <li>Proses verifikasi membutuhkan waktu 1-2 hari kerja</li>
                        <li>Anda akan mendapat notifikasi email setelah verifikasi</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
// Tab switching
function switchTab(tab) {
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    if (tab === 'register') {
        registerTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
        registerTab.classList.remove('text-gray-500', 'hover:text-gray-700');
        loginTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
        loginTab.classList.add('text-gray-500', 'hover:text-gray-700');
        registerForm.classList.remove('hidden');
        loginForm.classList.add('hidden');
    } else {
        loginTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
        loginTab.classList.remove('text-gray-500', 'hover:text-gray-700');
        registerTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
        registerTab.classList.add('text-gray-500', 'hover:text-gray-700');
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
    }
}

function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(fieldId + 'Toggle');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// KTM File Upload
document.getElementById('ktm_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('File terlalu besar. Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
            this.value = '';
            return;
        }
        
        // Show preview
        document.getElementById('ktmFileName').textContent = file.name;
        document.getElementById('ktmPreview').classList.remove('hidden');
        document.getElementById('ktmUploadArea').classList.add('border-green-400', 'bg-green-50');
    }
});

function removeKTMFile() {
    document.getElementById('ktm_file').value = '';
    document.getElementById('ktmPreview').classList.add('hidden');
    document.getElementById('ktmUploadArea').classList.remove('border-green-400', 'bg-green-50');
}

// Password validation
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('regPassword');
    const confirmPassword = document.getElementById('regPasswordConfirmation');
    
    function validatePasswords() {
        if (password.value && confirmPassword.value) {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Konfirmasi password tidak sesuai');
                confirmPassword.classList.add('border-red-500');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('border-red-500');
            }
        }
    }
    
    if (password && confirmPassword) {
        password.addEventListener('input', validatePasswords);
        confirmPassword.addEventListener('input', validatePasswords);
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.bg-red-50, .bg-green-50');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});
</script>
@endpush
@endsection
