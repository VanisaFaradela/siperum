@extends('layouts.app')

@section('title', 'Tambah Halaman Baru - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                Tambah Halaman Baru
            </h4>
            <p class="text-muted small mb-0">
                Buat halaman statis seperti Tentang Kami, Kontak, dll
            </p>
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <!-- Judul -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" placeholder="Contoh: Tentang Kami" required>
                            <small class="text-muted">Slug akan dibuat otomatis dari judul</small>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Konten -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control summernote @error('content') is-invalid @enderror" 
                                      rows="15" required>{{ old('content') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Gambar -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Header</label>
                            <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(this, 'preview-image')">
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="mt-2 text-center" id="preview-image-container" style="display: none;">
                                <img id="preview-image" src="#" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        </div>

                        <!-- Video (YouTube URL) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Video (YouTube URL)</label>
                            <input type="url" name="video" class="form-control" value="{{ old('video') }}" 
                                placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted">Masukkan URL YouTube, akan otomatis ditampilkan sebagai embed video</small>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- SEO Section -->
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3"><i class="fab fa-searchengin me-2"></i>SEO Settings</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control form-control-sm" value="{{ old('meta_title') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Meta Description</label>
                                    <textarea name="meta_description" class="form-control form-control-sm" rows="2">{{ old('meta_description') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control form-control-sm" value="{{ old('meta_keywords') }}">
                                    <small class="text-muted">Pisahkan dengan koma</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4 pt-3 border-top">
                    <button type="reset" class="btn btn-light me-2">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Simpan Halaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
    
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