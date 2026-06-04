@extends('layouts.app')

@section('title', 'Tambah Tipe Rumah - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                Tambah Tipe Rumah
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-building me-1 text-success"></i>
                Pilih cluster terlebih dahulu
            </p>
        </div>
        <a href="{{ route('tipe-rumah.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('tipe-rumah.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Pilih Cluster - PERBAIKI: gunakan cluster_id, bukan id -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Pilih Cluster <span class="text-danger">*</span></label>
                        <select name="cluster_id" class="form-select @error('cluster_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Cluster --</option>
                            @foreach($clusters as $c)
                                <option value="{{ $c->id_cluster }}" {{ old('cluster_id') == $c->id_cluster ? 'selected' : '' }}>
                                    {{ $c->nama_cluster }} ({{ $c->kota ?? 'Lokasi' }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih cluster yang sudah dibuat terlebih dahulu</small>
                        @error('cluster_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Tipe <span class="text-danger">*</span></label>
                        <input type="text" name="nama_tipe" class="form-control @error('nama_tipe') is-invalid @enderror" 
                               value="{{ old('nama_tipe') }}" placeholder="Contoh: Tipe 36, Tipe 45" required>
                        @error('nama_tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Blok</label>
                        <input type="text" name="blok" class="form-control @error('blok') is-invalid @enderror" 
                               value="{{ old('blok') }}" placeholder="Contoh: A, B, C, D">
                        <small class="text-muted">Contoh: A1, B2, C3</small>
                        @error('blok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Luas Bangunan (m²)</label>
                        <input type="number" step="0.01" name="luas_bangunan" class="form-control @error('luas_bangunan') is-invalid @enderror" 
                               value="{{ old('luas_bangunan', 36) }}">
                        @error('luas_bangunan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Luas Tanah (m²)</label>
                        <input type="number" step="0.01" name="luas_tanah" class="form-control @error('luas_tanah') is-invalid @enderror" 
                               value="{{ old('luas_tanah', 72) }}">
                        @error('luas_tanah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Nomor Unit</label>
                        <input type="text" name="nomor_unit" class="form-control @error('nomor_unit') is-invalid @enderror" 
                               value="{{ old('nomor_unit') }}" placeholder="Contoh: 01, 02, 03">
                        <small class="text-muted">Nomor unit spesifik</small>
                        @error('nomor_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Kamar Tidur</label>
                        <input type="number" name="kamar_tidur" class="form-control @error('kamar_tidur') is-invalid @enderror" 
                               value="{{ old('kamar_tidur', 2) }}" min="0">
                        @error('kamar_tidur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Kamar Mandi</label>
                        <input type="number" name="kamar_mandi" class="form-control @error('kamar_mandi') is-invalid @enderror" 
                               value="{{ old('kamar_mandi', 1) }}" min="0">
                        @error('kamar_mandi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Parkiran</label>
                        <input type="number" name="parkiran" class="form-control @error('parkiran') is-invalid @enderror" 
                               value="{{ old('parkiran', 1) }}" min="0">
                        @error('parkiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Harga <span class="text-danger">*</span></label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                               value="{{ old('harga', 650000000) }}" placeholder="650000000" required>
                        @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Harga Promo</label>
                        <input type="number" name="harga_promo" class="form-control @error('harga_promo') is-invalid @enderror" 
                               value="{{ old('harga_promo') }}" placeholder="200000000">
                        <small class="text-muted">Opsional</small>
                        @error('harga_promo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Status Tipe</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="promo" {{ old('status') == 'promo' ? 'selected' : '' }}>Promo</option>
                            <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                        <small class="text-muted">Status ketersediaan tipe rumah</small>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Status Unit</label>
                        <select name="status_unit" class="form-select @error('status_unit') is-invalid @enderror">
                            <option value="tersedia" {{ old('status_unit') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="booking" {{ old('status_unit') == 'booking' ? 'selected' : '' }}>Booking</option>
                            <option value="terjual" {{ old('status_unit') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                        </select>
                        <small class="text-muted">Status ketersediaan unit</small>
                        @error('status_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3" placeholder="Deskripsikan tipe rumah ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Foto Denah</label>
                        <input type="file" name="foto_denah" class="form-control @error('foto_denah') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                        @error('foto_denah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Foto Rumah (Multiple)</label>
                        <input type="file" name="foto_rumah[]" class="form-control @error('foto_rumah.*') is-invalid @enderror" accept="image/*" multiple>
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB per file. Bisa pilih lebih dari 1 foto</small>
                        @error('foto_rumah.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="text-end mt-4 pt-3 border-top">
                    <button type="reset" class="btn btn-light me-2">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Simpan Tipe Rumah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection