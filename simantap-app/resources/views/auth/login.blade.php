@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>
                    SIMANTAP
                </h4>
                <small>Sistem Informasi Manajemen Terintegrasi Administrasi Penyelesaian Studi</small>
            </div>
            <div class="card-body p-4">
                <h5 class="text-center mb-4">Login Mahasiswa</h5>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nim" class="form-label">
                            <i class="fas fa-id-card me-1"></i>
                            NIM
                        </label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                               id="nim" name="nim" value="{{ old('nim') }}" 
                               placeholder="Masukkan NIM Anda" required autofocus>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>
                            Password
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="Masukkan password Anda" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Login
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Gunakan NIM sebagai username dan password yang telah diberikan
                    </small>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('admin.login') }}" class="text-decoration-none">
                        <i class="fas fa-user-shield me-1"></i>Login sebagai Admin
                    </a>
                    <br>
                    <a href="{{ route('lecturer.login') }}" class="text-decoration-none">
                        <i class="fas fa-chalkboard-teacher me-1"></i>Login sebagai Dosen
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">
                &copy; {{ date('Y') }} SIMANTAP. All rights reserved.
            </small>
        </div>
    </div>
</div>
@endsection
