@extends('layouts.app')

@section('title', 'Edit Berita - SIPERUM')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit me-2 text-success"></i>
                Edit Berita
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-newspaper me-1 text-success"></i>
                Edit konten berita
            </p>
        </div>
        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('berita.update', $berita->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <!-- Judul -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $berita->judul) }}" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Konten -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konten Berita <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control summernote @error('konten') is-invalid @enderror" 
                                      rows="10" required>{{ old('konten', $berita->konten) }}</textarea>
                            @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @php
                                    $kategoriList = ['Info Perumahan', 'Tips & Trik', 'Promo', 'Event', 'Pengumuman', 'Artikel'];
                                @endphp
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $berita->kategori) == $kat ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

                        <!-- Gambar Saat Ini -->
                        @php
                            $gambarPath = $berita->gambar;
                            $gambarExists = $gambarPath && file_exists(public_path($gambarPath));
                        @endphp
                        
                        @if($gambarExists)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Saat Ini</label>
                            <div class="border rounded-3 p-3 text-center bg-light">
                                <img src="{{ asset($gambarPath) }}" class="img-fluid rounded" style="max-height: 150px;">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="hapus_gambar" class="form-check-input" id="hapusGambar" value="1">
                                    <label class="form-check-label text-danger" for="hapusGambar">Hapus gambar</label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Gambar Baru</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(this, 'preview-gambar')">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                            @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="mt-2 text-center" id="preview-gambar-container" style="display: none;">
                                <img id="preview-gambar" src="#" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="status" id="statusDraft" 
                                           value="draft" {{ old('status', $berita->status) == 'draft' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusDraft">
                                        <span class="badge bg-secondary">Draft</span>
                                        <small class="d-block text-muted">Simpan sebagai draft, publikasi nanti</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusPublished" 
                                           value="published" {{ old('status', $berita->status) == 'published' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusPublished">
                                        <span class="badge bg-success">Published</span>
                                        <small class="d-block text-muted">Langsung publikasikan sekarang</small>
                                    </label>
                                </div>
                            </div>
                            @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="alert alert-light border">
                            <h6 class="fw-semibold mb-2"><i class="fas fa-info-circle me-2 text-success"></i>Info:</h6>
                            <ul class="small mb-0 ps-3">
                                <li>Dibuat: {{ $berita->created_at ? $berita->created_at->format('d/m/Y H:i') : '-' }}</li>
                                <li>Penulis: {{ $berita->penulis ?? 'Admin' }}</li>
                                <li>Views: {{ number_format($berita->views ?? 0) }}</li>
                            </ul>
                        </div>

                        <!-- Tips Menulis -->
                        <div class="alert alert-success bg-opacity-10 border-0">
                            <h6 class="fw-semibold mb-2"><i class="fas fa-lightbulb me-2 text-success"></i>Tips Menulis:</h6>
                            <ul class="small mb-0 ps-3">
                                <li>Gunakan judul yang menarik</li>
                                <li>Sertakan gambar berkualitas</li>
                                <li>Tulis konten informatif</li>
                                <li>Periksa ejaan sebelum publikasi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="text-end mt-4 pt-3 border-top">
                    <a href="{{ route('berita.index') }}" class="btn btn-light me-2">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update Berita
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