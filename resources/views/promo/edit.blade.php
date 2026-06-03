@extends('layouts.app')

@section('title', 'Edit Promo - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit me-2 text-success"></i>
                Edit Promo
            </h4>
            <p class="text-muted small mb-0">
                Edit promo diskon untuk perumahan
            </p>
        </div>
        <a href="{{ route('promo.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('promo.update', $promo->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Pilih Perumahan <span class="text-danger">*</span></label>
                        <select name="id_perumahan" id="id_perumahan" class="form-select" required>
                            <option value="">-- Pilih Perumahan --</option>
                            @foreach($perumahans as $p)
                                <option value="{{ $p->id }}" {{ $promo->id_perumahan == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_perumahan }} ({{ $p->kota }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Pilih Tipe Rumah (Opsional)</label>
                        <select name="tipe_rumah_id[]" id="tipe_rumah_id" class="form-select select2" multiple>
                            @php
                                $tipeRumahList = \App\Models\TipeRumah::where('perumahan_id', $promo->id_perumahan)->get();
                            @endphp
                            @foreach($tipeRumahList as $tipe)
                                <option value="{{ $tipe->id }}" {{ in_array($tipe->id, $selectedTipe ?? []) ? 'selected' : '' }}>
                                    {{ $tipe->nama_tipe }} - Rp {{ number_format($tipe->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Kosongkan jika promo berlaku untuk semua tipe rumah</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Judul Promo <span class="text-danger">*</span></label>
                        <input type="text" name="judul_promo" class="form-control" value="{{ old('judul_promo', $promo->judul_promo) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Badge</label>
                        <input type="text" name="badge" class="form-control" value="{{ old('badge', $promo->badge) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $promo->status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="coming_soon" {{ $promo->status == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                            <option value="expired" {{ $promo->status == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga Awal (Opsional)</label>
                        <input type="number" name="harga_awal" class="form-control" value="{{ old('harga_awal', $promo->harga_awal) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga Promo <span class="text-danger">*</span></label>
                        <input type="number" name="harga_promo" class="form-control" value="{{ old('harga_promo', $promo->harga_promo) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', $promo->stok) }}" min="0">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $promo->tanggal_mulai->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Berakhir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_berakhir" class="form-control" value="{{ old('tanggal_berakhir', $promo->tanggal_berakhir->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control summernote" rows="5" required>{{ old('deskripsi', $promo->deskripsi) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Syarat & Ketentuan</label>
                        <textarea name="syarat_ketentuan" class="form-control" rows="3">{{ old('syarat_ketentuan', $promo->syarat_ketentuan) }}</textarea>
                    </div>

                    @if($promo->gambar && file_exists(public_path($promo->gambar)))
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <div class="border rounded-3 p-3 text-center bg-light">
                            <img src="{{ asset($promo->gambar) }}" class="img-fluid rounded" style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input type="checkbox" name="hapus_gambar" class="form-check-input" value="1">
                                <label class="form-check-label text-danger">Hapus gambar</label>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Upload Gambar Baru</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this, 'preview-gambar')">
                        <div class="mt-2 text-center" id="preview-gambar-container" style="display: none;">
                            <img id="preview-gambar" src="#" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4 pt-3 border-top">
                    <a href="{{ route('promo.index') }}" class="btn btn-light me-2">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 250
        });

        $('.select2').select2({
            theme: 'bootstrap-5'
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