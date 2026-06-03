@extends('layouts.app')

@section('title', 'Pengaturan - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-cog me-2 text-success"></i>
                Pengaturan
            </h4>
        </div>
    </div>

    <div class="row">
        <!-- Edit Profil -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user me-2 text-success"></i>
                        Edit Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pengaturan.update-profile') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-green">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Ganti Password -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-key me-2 text-success"></i>
                        Ganti Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pengaturan.update-password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-green">
                            <i class="fas fa-key me-2"></i>Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informasi Sistem -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-info-circle me-2 text-success"></i>
                        Informasi Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                 <tr>
                                    <td width="40%"><strong>Aplikasi</strong></td>
                                    <td>SIPERUM (Sistem Informasi Perumahan)</td>
                                </tr>
                                <tr>
                                    <td><strong>Versi</strong></td>
                                    <td>1.0.0</td>
                                </tr>
                                <tr>
                                    <td><strong>Framework</strong></td>
                                    <td>Laravel {{ Illuminate\Foundation\Application::VERSION }}</td>
                                </tr>
                                <tr>
                                    <td><strong>PHP Version</strong></td>
                                    <td>{{ PHP_VERSION }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Database</strong></td>
                                    <td>MySQL</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Perumahan</strong></td>
                                    <td>{{ \App\Models\Perumahan::count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Berita</strong></td>
                                    <td>{{ \App\Models\Berita::count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Galeri</strong></td>
                                    <td>{{ \App\Models\Galeri::count() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-green {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    
    .btn-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        color: white;
    }
    
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .table-borderless td {
        padding: 8px 0;
    }
</style>
@endsection