@extends('layouts.app')

@section('title', 'Edit Anggota Tim - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-user-edit me-2 text-success"></i>
                Edit Anggota Tim
            </h4>
            <p class="text-muted small mb-0">
                Edit data {{ $team->nama }}
            </p>
        </div>
        <a href="{{ route('team.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('team.update', $team->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $team->nama) }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" 
                                   value="{{ old('jabatan', $team->jabatan) }}" required>
                            @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="4">{{ old('deskripsi', $team->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $team->email) }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Telepon</label>
                                <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                                       value="{{ old('telepon', $team->telepon) }}">
                                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $team->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $team->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Saat Ini</label>
                            @if($team->foto && file_exists(public_path($team->foto)))
                                <div class="text-center mb-3">
                                    <img src="{{ asset($team->foto) }}" class="rounded-circle shadow" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="hapus_foto" class="form-check-input" value="1">
                                        <label class="form-check-label text-danger">Hapus foto</label>
                                    </div>
                                </div>
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Foto Baru</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(this, 'preview-foto')">
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            <div class="mt-3 text-center" id="preview-foto-container" style="display: none;">
                                <img id="preview-foto" src="#" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const container = document.getElementById(previewId + '-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection