@extends('layouts.app')

@section('title', 'Reset Password - SIPERUM')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
        <div class="col-md-5">
            <!-- Card Reset Password -->
            <div class="card shadow border-0 rounded-4" data-aos="fade-up">
                <div class="card-body p-5">
                    <!-- Icon -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle p-3 mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-lock fa-3x text-success"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Reset Password</h4>
                        <p class="text-muted small mb-0">Buat password baru untuk akun Anda</p>
                    </div>

                    <!-- Alert Status -->
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                            <small><i class="fas fa-check-circle me-1"></i> {{ session('status') }}</small>
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Alert Error -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                            <small><i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}</small>
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Reset Password -->
                    <form method="POST" action="{{ url('/reset-password/proses') }}" id="formResetPassword">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <!-- Email (Readonly - hanya info) -->
                        <div class="mb-4">
                            <label for="email" class="form-label small fw-semibold">Email</label>
                            <input type="email" 
                                   class="form-control bg-light" 
                                   value="{{ $email }}" 
                                   readonly 
                                   disabled>
                            <input type="hidden" name="email" value="{{ $email }}">
                            <small class="text-muted">Password akan direset untuk email ini</small>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold">Password Baru</label>
                            <div class="input-group">
                                <input type="password" 
                                    class="form-control" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Minimal 6 karakter"
                                    autocomplete="new-password"
                                    autocomplete="off"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password baru"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Tombol Reset -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-green py-2 fw-semibold" id="btnSubmit">
                                <i class="fas fa-save me-2"></i>Reset Password
                            </button>
                        </div>

                        <!-- Link Kembali -->
                        <div class="text-center">
                            <a href="{{ url('/login') }}" class="text-decoration-none small text-success">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group .btn {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
    
    .form-control:focus {
        border-color: #2ecc71 !important;
        box-shadow: 0 0 0 0.1rem rgba(46, 204, 113, 0.25) !important;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password Baru
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                }
            });
        }

        // Toggle Konfirmasi Password
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#password_confirmation');

        if (toggleConfirmPassword && confirmPassword) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                }
            });
        }

        // Loading effect saat submit
        const form = document.getElementById('formResetPassword');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('btnSubmit');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                }
            });
        }
    });
</script>
@endpush