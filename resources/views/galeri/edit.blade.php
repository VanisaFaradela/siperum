@extends('layouts.app')

@section('title', 'Edit Foto Galeri - SIPERUM')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit me-2 text-success"></i>
                Edit Foto Galeri
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-image me-1 text-success"></i>
                Mengedit foto: {{ $galeri->judul_galeri }}
            </p>
        </div>
        <a href="{{ route('galeri.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('galeri.update', $galeri->id_galeri) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <!-- Judul -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                            <input type="text" name="judul_galeri" class="form-control @error('judul_galeri') is-invalid @enderror" 
                                   value="{{ old('judul_galeri', $galeri->judul_galeri) }}" required>
                            @error('judul_galeri')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_foto" class="form-select @error('kategori_foto') is-invalid @enderror" required>
                                @php
                                    $kategoriList = ['fasilitas umum', 'event'];
                                @endphp
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori_foto', $galeri->kategori_foto) == $kat ? 'selected' : '' }}>
                                        {{ ucfirst($kat) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>


                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $galeri->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $galeri->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Urutan</label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $galeri->urutan ?? 0) }}" min="0">
                            @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Gambar - Full Width -->
                    <div class="col-12">
                        <div class="row">
                            <!-- Gambar Saat Ini -->
                            @if($galeri->foto)
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Foto Saat Ini</label>
                                <div class="border rounded-3 p-3 text-center bg-light">
                                    <img src="{{ route('media.galeri', basename($galeri->foto)) }}" class="img-fluid rounded" style="max-height: 150px;">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="hapus_foto" class="form-check-input" id="hapusFoto">
                                        <label class="form-check-label text-danger" for="hapusFoto">Hapus foto ini</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Upload Gambar Baru -->
                            <div class="{{ $galeri->foto ? 'col-md-6' : 'col-12' }} mb-3">
                                <label class="form-label fw-semibold">Upload Foto Baru</label>
                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(this, 'preview-foto')">
                                <small class="text-muted">Format: JPG, PNG. Maks: 5MB</small>
                                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="mt-2 text-center" id="preview-foto-container" style="display: none;">
                                    <img id="preview-foto" src="#" alt="Preview Foto" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="text-end mt-4 pt-3 border-top">
                    <a href="{{ route('galeri.index') }}" class="btn btn-light me-2">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update Foto
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
        } else {
            preview.src = '#';
            container.style.display = 'none';
        }
    }
</script>
@endpush
@endsection