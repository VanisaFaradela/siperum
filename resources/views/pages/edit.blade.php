@extends('layouts.app')

@section('title', 'Edit Halaman - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit me-2 text-success"></i>
                Edit Halaman: {{ $page->title }}
            </h4>
            <p class="text-muted small mb-0">
                Slug: {{ $page->slug }}
            </p>
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('pages.update', $page->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <!-- Judul -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $page->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Konten -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control summernote @error('content') is-invalid @enderror" 
                                      rows="15" required>{{ old('content', $page->content) }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Gambar Saat Ini -->
                        @if($page->featured_image)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Saat Ini</label>
                            <div class="border rounded-3 p-3 text-center bg-light">
                                <img src="{{ route('media.pages', ['file' => basename($page->featured_image)]) }}"
                                    class="img-fluid rounded"
                                    style="max-height: 150px;">

                                <div class="form-check mt-2">
                                    <input type="checkbox"
                                        name="hapus_image"
                                        class="form-check-input"
                                        id="hapusImage"
                                        value="1">

                                    <label class="form-check-label text-danger"
                                        for="hapusImage">
                                        Hapus gambar
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Gambar Baru</label>
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
                            @if($page->video)
                            <div class="form-check mb-2">
                                <input type="checkbox"
                                    name="hapus_video"
                                    class="form-check-input"
                                    id="hapusVideo"
                                    value="1">

                                <label class="form-check-label text-danger"
                                    for="hapusVideo">
                                    Hapus video
                                </label>
                            </div>
                            @endif

                            <input type="url"
                                name="video"
                                class="form-control"
                                value="{{ $page->video }}"
                                placeholder="https://www.youtube.com/watch?v=...">

                            <div id="video-preview" class="mt-3"></div>

                            <small class="text-muted">
                                Masukkan URL YouTube, akan otomatis ditampilkan sebagai embed video
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- SEO Section -->
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3"><i class="fab fa-searchengin me-2"></i>SEO Settings</h6>
                                
                                @php
                                    $metaData = json_decode($page->meta_data, true) ?? [];
                                @endphp
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control form-control-sm" value="{{ old('meta_title', $metaData['meta_title'] ?? '') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Meta Description</label>
                                    <textarea name="meta_description" class="form-control form-control-sm" rows="2">{{ old('meta_description', $metaData['meta_description'] ?? '') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control form-control-sm" value="{{ old('meta_keywords', $metaData['meta_keywords'] ?? '') }}">
                                    <small class="text-muted">Pisahkan dengan koma</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4 pt-3 border-top">
                    <a href="{{ route('pages.index') }}" class="btn btn-light me-2">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update Halaman
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

        $(document).ready(function() {

        // Preview video saat halaman dibuka
        previewYoutube();

        $('input[name="video"]').on('keyup change', function() {
            previewYoutube();
        });

        function previewYoutube() {

            let url = $('input[name="video"]').val();

            let match = url.match(
                /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/i
            );

            if(match){

                $('#video-preview').html(`
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="https://www.youtube.com/embed/${match[1]}"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                `);

            } else {

                $('#video-preview').html('');

            }
        }

    });
</script>
@endpush
@endsection