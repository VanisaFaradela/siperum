@extends('layouts.app')

@section('title', 'Login SIPERUM')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-5">
            <!-- Card Login -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <!-- Logo & Title -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle p-3 mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-leaf fa-3x text-success"></i>
                        </div>
                        <h4 class="fw-bold mb-1">SIPERUM</h4>
                        <p class="text-muted small mb-0">Sistem Informasi Perumahan</p>
                    </div>

                    <!-- Alert Error -->
                    @if(session('error') || $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                            <small>
                                <i class="fas fa-exclamation-circle me-1"></i>
                                @if(session('error'))
                                    {{ session('error') }}
                                @else
                                    {{ $errors->first() }}
                                @endif
                            </small>
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Login -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="admin@example.com"
                                   required>
                        </div>

                        <!-- Password dengan Icon Mata -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="••••••••"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember & Forgot (diberi jarak bawah) -->
                        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label small" for="remember">Ingat saya</label>
                            </div>
                            <a href="{{ url('/lupa-password') }}" class="text-success text-decoration-none small">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Tombol Masuk (diberi jarak dan lebar penuh) -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-success py-2 fw-semibold">
                                Masuk
                            </button>
                        </div>

                        <!-- Demo Account -->
                        <div class="text-center">
                            <small class="text-muted d-block mb-2">Demo Akun:</small>
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge bg-light text-secondary px-3 py-2">
                                    <i class="fas fa-envelope me-1 text-success"></i>admin@siperum.com
                                </span>
                                <span class="badge bg-light text-secondary px-3 py-2">
                                    <i class="fas fa-lock me-1 text-success"></i>password
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .input-group-text, .btn {
        border-radius: 8px !important;
    }
    
    .form-control:focus {
        border-color: #2ecc71 !important;
        box-shadow: 0 0 0 0.1rem rgba(46, 204, 113, 0.25) !important;
    }
    
    .btn-success {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }
    
    .btn-success:hover {
        background-color: #27ae60;
        border-color: #27ae60;
    }
    
    .input-group .btn {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                // Toggle type input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle icon
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                }
            });
        }
    });
</script>
@endpush
@endsection