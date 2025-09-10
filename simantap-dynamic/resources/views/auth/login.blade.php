@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('images/logo-simantap.png') }}" alt="SIMANTAP Logo" class="w-16 h-16 object-contain">
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">SIMANTAP</h2>
                <p class="text-blue-100 text-sm">Sistem Informasi Manajemen Terintegrasi</p>
            </div>
            <div class="px-6 py-8">
                <div class="text-center mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pilih Jenis Login</h3>
                    <p class="text-gray-600 text-sm">Silakan pilih role Anda untuk melanjutkan</p>
                </div>
                
                <div class="space-y-4">
                    <a href="{{ route('student.login') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
                        <i class="fas fa-user-graduate"></i>
                        <span>Mahasiswa</span>
                    </a>
                    <button onclick="showLoginForm('lecturer')" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Dosen</span>
                    </button>
                    <button onclick="showLoginForm('admin')" class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin</span>
                    </button>
                </div>

                <div id="loginFormContainer" class="mt-8">
                    <!-- Login forms will be loaded here -->
                </div>
            </div>
        </div>


@push('scripts')
<script>
    function showLoginForm(type) {
        const container = document.getElementById('loginFormContainer');
        if (!container) return;

        let formHTML = '';
        
        if (type === 'admin') {
            formHTML = `
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="admin">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </button>
                </form>
            `;
        } else if (type === 'lecturer') {
            formHTML = `
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="lecturer">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIP atau Email</label>
                        <input type="text" name="username" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan NIP atau Email">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </button>
                </form>
            `;
        }

        container.innerHTML = formHTML;
    }

    @if(session('error'))
        showAlert('{{ session('error') }}', 'danger');
    @endif

    @if(session('success'))
        showAlert('{{ session('success') }}', 'success');
    @endif

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
                        <div class="flex items-center">
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
            if (alert) alert.remove();
        }, 5000);
    }
</script>
@endpush
@endsection
