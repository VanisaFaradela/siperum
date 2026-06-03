@extends('layouts.layout')

@section('title', 'Tambah Galeri - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-plus-circle me-2 text-success"></i>
        Tambah Galeri
    </h4>
    <a href="{{ route('galeri.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <form method="POST" action="{{ route('galeri.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                <input type="text" name="judul_galeri" class="form-control @error('judul_galeri') is-invalid @enderror" 
                       value="{{ old('judul_galeri') }}" placeholder="Masukkan judul foto" required>
                @error('judul_galeri')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                <select name="kategori_foto" class="form-select @error('kategori_foto') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    <option value="fasilitas umum" {{ old('kategori_foto') == 'fasilitas umum' ? 'selected' : '' }}>Fasilitas Umum</option>
                    <option value="event" {{ old('kategori_foto') == 'event' ? 'selected' : '' }}>Event</option>
                </select>
                @error('kategori_foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Upload Foto <span class="text-danger">*</span></label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" 
                       accept="image/*" onchange="previewImage(this, 'preview-foto')" required>
                <small class="text-muted">Format: JPG, PNG, GIF. Maks: 5MB</small>
                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="mt-2 text-center" id="preview-foto-container" style="display: none;">
                    <img id="preview-foto" src="#" alt="Preview Foto" class="img-fluid rounded border p-2" style="max-height: 150px;">
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Urutan</label>
                <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', 0) }}" min="0">
                @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="text-end mt-4 pt-3 border-top">
            <button type="reset" class="btn btn-light me-2">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
            <button type="submit" class="btn btn-green">
                <i class="fas fa-save me-2"></i>Simpan Galeri
            </button>
        </div>
    </form>
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
        } else {
            preview.src = '#';
            container.style.display = 'none';
        }
    }
</script>
@endpush
@endsection