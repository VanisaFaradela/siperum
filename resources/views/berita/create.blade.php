@extends('layouts.layout')

@section('title', 'Tulis Berita Baru - SIPERUM')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                Tulis Berita Baru
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-newspaper me-1 text-success"></i>
                Buat konten berita baru
            </p>
        </div>
        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab">
                            <i class="fas fa-image me-2"></i>Gambar & Media
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Tab 1: Informasi Dasar -->
                    <div class="tab-pane active" id="info" role="tabpanel">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-semibold">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                       value="{{ old('judul') }}" placeholder="Masukkan judul berita" required>
                                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kategori)
                                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Konten Berita <span class="text-danger">*</span></label>
                                <textarea name="konten" class="form-control summernote @error('konten') is-invalid @enderror" 
                                          rows="10" required>{{ old('konten') }}</textarea>
                                @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-success bg-opacity-10 border-0 mt-2">
                                    <h6 class="fw-semibold mb-2"><i class="fas fa-lightbulb me-2 text-success"></i>Tips Menulis:</h6>
                                    <ul class="small mb-0 ps-3">
                                        <li>Gunakan judul yang menarik</li>
                                        <li>Tulis konten informatif</li>
                                        <li>Periksa ejaan sebelum publikasi</li>
                                        <li>Sertakan gambar yang relevan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Berita -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Berita</label>
                        <select name="jenis" class="form-select">
                            <option value="berita" {{ old('jenis', $berita->jenis ?? 'berita') == 'berita' ? 'selected' : '' }}>Berita Biasa</option>
                            <option value="promo" {{ old('jenis', $berita->jenis ?? '') == 'promo' ? 'selected' : '' }}>Promo (Akan tampil di popup)</option>
                        </select>
                    </div>

                    <!-- Field Promo (muncul jika jenis = promo) -->
                    <div class="row" id="promo-fields" style="display: {{ old('jenis', $berita->jenis ?? 'berita') == 'promo' ? 'flex' : 'none' }};">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tanggal Mulai Promo</label>
                            <input type="date" name="tanggal_mulai_promo" class="form-control" value="{{ old('tanggal_mulai_promo', $berita->tanggal_mulai_promo ?? '') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tanggal Berakhir Promo</label>
                            <input type="date" name="tanggal_berakhir_promo" class="form-control" value="{{ old('tanggal_berakhir_promo', $berita->tanggal_berakhir_promo ?? '') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tampilkan Popup?</label>
                            <select name="popup" class="form-select">
                                <option value="tidak" {{ old('popup', $berita->popup ?? 'tidak') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                <option value="ya" {{ old('popup', $berita->popup ?? '') == 'ya' ? 'selected' : '' }}>Ya, Tampilkan Popup</option>
                            </select>
                            <small class="text-muted">Hanya akan tampil jika jenis = Promo dan dalam periode yang aktif</small>
                        </div>
                    </div>
                    
                    <!-- Tab 2: Gambar & Media -->
                    <div class="tab-pane" id="media" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Gambar Utama</label>
                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(this, 'preview-gambar')">
                                <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                                @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                
                                <!-- Preview Gambar -->
                                <div class="mt-3 text-center" id="preview-gambar-container" style="display: none;">
                                    <div class="border rounded-3 p-3 bg-light d-inline-block">
                                        <img id="preview-gambar" src="#" alt="Preview Gambar" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="text-end mt-4 pt-3 border-top">
                    <button type="reset" class="btn btn-light me-2">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Simpan Berita
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