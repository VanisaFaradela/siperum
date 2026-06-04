@extends('layouts.layout')

@section('title', 'Tambah Cluster Baru - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-plus-circle me-2 text-success"></i>
        Tambah Cluster Baru
    </h4>
    <a href="{{ route('cluster.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card-cluster p-4">
    <form method="POST" action="{{ route('cluster.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info" type="button">
                    <i class="fas fa-info-circle me-2"></i>Informasi Cluster
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#detail" type="button">
                    <i class="fas fa-list me-2"></i>Detail Cluster
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#gambar" type="button">
                    <i class="fas fa-image me-2"></i>Gambar & Media
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- ================= TAB INFO ================= -->
            <div class="tab-pane fade show active" id="info">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Cluster <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="nama_cluster"
                               class="form-control @error('nama_cluster') is-invalid @enderror"
                               value="{{ old('nama_cluster') }}"
                               placeholder="Contoh: Cluster Sakura"
                               required>

                        @error('nama_cluster')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Pengembang <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="nama_pengembang"
                               class="form-control @error('nama_pengembang') is-invalid @enderror"
                               value="{{ old('nama_pengembang') }}"
                               placeholder="PT Developer Indonesia"
                               required>

                        @error('nama_pengembang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Alamat Cluster <span class="text-danger">*</span>
                        </label>

                        <textarea name="alamat"
                                  rows="3"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Masukkan alamat lengkap cluster"
                                  required>{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Kota <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="kota"
                               class="form-control @error('kota') is-invalid @enderror"
                               value="{{ old('kota') }}"
                               required>

                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Provinsi <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="provinsi"
                               class="form-control @error('provinsi') is-invalid @enderror"
                               value="{{ old('provinsi') }}"
                               required>

                        @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Kode Pos
                        </label>

                        <input type="text"
                               name="kode_pos"
                               class="form-control @error('kode_pos') is-invalid @enderror"
                               value="{{ old('kode_pos') }}">

                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Kontak Pengembang
                        </label>

                        <input type="text"
                               name="kontak_pengembang"
                               class="form-control @error('kontak_pengembang') is-invalid @enderror"
                               value="{{ old('kontak_pengembang') }}">

                        @error('kontak_pengembang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Email Pengembang
                        </label>

                        <input type="email"
                               name="email_pengembang"
                               class="form-control @error('email_pengembang') is-invalid @enderror"
                               value="{{ old('email_pengembang') }}">

                        @error('email_pengembang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

            </div>

            <!-- ================= TAB DETAIL ================= -->
            <div class="tab-pane fade" id="detail">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Total Unit
                        </label>

                        <input type="number"
                               name="total_unit"
                               class="form-control"
                               value="{{ old('total_unit', 0) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Unit Tersedia
                        </label>

                        <input type="number"
                               name="unit_tersedia"
                               class="form-control"
                               value="{{ old('unit_tersedia', 0) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Luas Total (m²)
                        </label>

                        <input type="number"
                               step="0.01"
                               name="luas_total"
                               class="form-control"
                               value="{{ old('luas_total') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Sertifikat
                        </label>

                        <select name="sertifikat" class="form-select">
                            <option value="SHM" {{ old('sertifikat') == 'SHM' ? 'selected' : '' }}>SHM</option>
                            <option value="HGB" {{ old('sertifikat') == 'HGB' ? 'selected' : '' }}>HGB</option>
                            <option value="HPL" {{ old('sertifikat') == 'HPL' ? 'selected' : '' }}>HPL</option>
                            <option value="Lainnya" {{ old('sertifikat') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Listrik
                        </label>

                        <input type="text"
                               name="listrik"
                               class="form-control"
                               value="{{ old('listrik') }}"
                               placeholder="1300 VA">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status" class="form-select">
                           <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>

                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Latitude
                        </label>

                        <input type="text"
                               name="latitude"
                               class="form-control"
                               value="{{ old('latitude') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Longitude
                        </label>

                        <input type="text"
                               name="longitude"
                               class="form-control"
                               value="{{ old('longitude') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Deskripsi Cluster
                        </label>

                        <textarea name="deskripsi_cluster"
                                  rows="4"
                                  class="form-control">{{ old('deskripsi_cluster') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Fasilitas
                        </label>

                        <textarea name="fasilitas"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Contoh: Masjid, Taman, Playground">{{ old('fasilitas') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox"
                                    name="akses_air_bersih"
                                    value="1"
                                    {{ old('akses_air_bersih') ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Akses Air Bersih
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox"
                                   class="form-check-input"
                                   name="keamanan_24jam"
                                   value="1"
                                   {{ old('keamanan_24jam') ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Keamanan 24 Jam
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox"
                                   class="form-check-input"
                                   name="one_gate_system"
                                   value="1"
                                   {{ old('one_gate_system') ? 'checked' : '' }}>

                            <label class="form-check-label">
                                One Gate System
                            </label>
                        </div>
                    </div>

                </div>

            </div>

            <!-- ================= TAB GAMBAR ================= -->
            <div class="tab-pane fade" id="gambar">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Logo Cluster
                        </label>

                        <input type="file"
                                name="logo_cluster"
                                class="form-control"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-logo')">

                        <div class="mt-3 text-center"
                             id="preview-logo-container"
                             style="display:none;">

                            <img id="preview-logo"
                                 class="img-fluid rounded"
                                 style="max-height:120px;">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Foto Utama Cluster
                        </label>

                        <input type="file"
                                name="gambar_cluster"
                                class="form-control"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-utama')">

                        <div class="mt-3 text-center"
                             id="preview-utama-container"
                             style="display:none;">

                            <img id="preview-utama"
                                 class="img-fluid rounded"
                                 style="max-height:150px;">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Foto Lainnya
                        </label>

                        <input type="file"
                               name="foto_lainnya[]"
                               class="form-control"
                               multiple
                               accept="image/*"
                               onchange="previewMultipleImages(this)">

                        <div class="row mt-3" id="preview-multiple-container"></div>
                    </div>

                </div>

            </div>

        </div>

        <!-- BUTTON -->
        <div class="text-end mt-4 pt-3 border-top">
            <button type="reset" class="btn btn-light me-2">
                Reset
            </button>

            <button type="submit" class="btn btn-success">
                Simpan Cluster
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>

function previewImage(input, previewId)
{
    const preview = document.getElementById(previewId);
    const container = document.getElementById(previewId + '-container');

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e)
        {
            preview.src = e.target.result;
            container.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function previewMultipleImages(input)
{
    const container = document.getElementById('preview-multiple-container');

    container.innerHTML = '';

    if (input.files) {

        for (let i = 0; i < input.files.length; i++) {

            const file = input.files[i];

            const reader = new FileReader();

            reader.onload = function(e)
            {
                const col = document.createElement('div');

                col.className = 'col-md-3 mb-3';

                col.innerHTML = `
                    <div class="border rounded p-2">
                        <img src="${e.target.result}"
                             class="img-fluid rounded"
                             style="height:120px;width:100%;object-fit:cover;">

                        <small class="d-block mt-2 text-truncate">
                            ${file.name}
                        </small>
                    </div>
                `;

                container.appendChild(col);
            }

            reader.readAsDataURL(file);
        }
    }
}

</script>
@endpush

@endsection