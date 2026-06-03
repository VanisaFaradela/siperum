@extends('layouts.app')

@section('title', 'Edit Kontak - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit me-2 text-success"></i>
                Edit Kontak
            </h4>
            <p class="text-muted small mb-0">
                Edit data kontak {{ $kontak->nama }}
            </p>
        </div>
        <a href="{{ route('kontak.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('kontak.update', $kontak->id) }}">
                @csrf
                @method('PUT')

                <!-- Informasi Dasar -->
                <div class="mb-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-info-circle me-2 text-success"></i>Informasi Dasar
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $kontak->nama) }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $kontak->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Telepon</label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                                   value="{{ old('telepon', $kontak->telepon) }}">
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Perusahaan</label>
                            <input type="text" name="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror" 
                                   value="{{ old('perusahaan', $kontak->perusahaan) }}">
                            @error('perusahaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $kontak->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $kontak->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="mb-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-share-alt me-2 text-success"></i>Media Sosial
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fab fa-facebook text-primary me-1"></i> Facebook
                            </label>
                            <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $kontak->facebook) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fab fa-instagram text-danger me-1"></i> Instagram
                            </label>
                            <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $kontak->instagram) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fab fa-twitter text-info me-1"></i> Twitter
                            </label>
                            <input type="url" name="twitter" class="form-control" value="{{ old('twitter', $kontak->twitter) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fab fa-youtube text-danger me-1"></i> YouTube
                            </label>
                            <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $kontak->youtube) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fab fa-linkedin text-primary me-1"></i> LinkedIn
                            </label>
                            <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $kontak->linkedin) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fab fa-tiktok text-dark me-1"></i> TikTok
                            </label>
                            <input type="url" name="tiktok" class="form-control" value="{{ old('tiktok', $kontak->tiktok) }}">
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="text-end mt-4 pt-3 border-top">
                    <button type="reset" class="btn btn-light me-2">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update Kontak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection