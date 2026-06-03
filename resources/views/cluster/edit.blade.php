@extends('layouts.app')

@section('title', 'Edit Cluster - SIPERUM')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="fas fa-edit me-2 text-success"></i>
            Edit Cluster
        </h4>
        <a href="{{ route('cluster.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('cluster.update', $cluster->cluster_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab">
                            <i class="fas fa-list me-2"></i>Detail & Fasilitas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gambar-tab" data-bs-toggle="tab" data-bs-target="#gambar" type="button" role="tab">
                            <i class="fas fa-image me-2"></i>Gambar & Media
                        </button>
                    </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Tab 1: Informasi Dasar -->
                    <div class="tab-pane active" id="info" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Cluster <span class="text-danger">*</span></label>
                                <input type="text" name="nama_cluster" class="form-control @error('nama_cluster') is-invalid @enderror" 
                                       value="{{ old('nama_cluster', $cluster->nama_cluster) }}" placeholder="Contoh: Cluster Mutiara" required>
                                @error('nama_cluster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Pengembang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pengembang" class="form-control @error('nama_pengembang') is-invalid @enderror" 
                                       value="{{ old('nama_pengembang', $cluster->nama_pengembang) }}" placeholder="PT. Developer Indonesia" required>
                                @error('nama_pengembang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Lokasi Cluster <span class="text-danger">*</span></label>
                                <textarea name="lokasi_cluster" class="form-control @error('lokasi_cluster') is-invalid @enderror" 
                                          rows="2" placeholder="Jl. Contoh No. 123" required>{{ old('lokasi_cluster', $cluster->lokasi_cluster) }}</textarea>
                                @error('lokasi_cluster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Kota <span class="text-danger">*</span></label>
                                <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" 
                                       value="{{ old('kota', $cluster->kota) }}" placeholder="Jakarta" required>
                                @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" 
                                       value="{{ old('provinsi', $cluster->provinsi) }}" placeholder="DKI Jakarta" required>
                                @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Kode Pos</label>
                                <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" 
                                       value="{{ old('kode_pos', $cluster->kode_pos) }}" placeholder="12345">
                                @error('kode_pos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kontak Pengembang <span class="text-danger">*</span></label>
                                <input type="text" name="kontak_pengembang" class="form-control @error('kontak_pengembang') is-invalid @enderror" 
                                       value="{{ old('kontak_pengembang', $cluster->kontak_pengembang) }}" placeholder="08123456789" required>
                                @error('kontak_pengembang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email Pengembang</label>
                                <input type="email" name="email_pengembang" class="form-control @error('email_pengembang') is-invalid @enderror" 
                                       value="{{ old('email_pengembang', $cluster->email_pengembang) }}" placeholder="developer@example.com">
                                @error('email_pengembang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Website</label>
                                <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" 
                                       value="{{ old('website', $cluster->website) }}" placeholder="https://www.example.com">
                                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft" {{ old('status', $cluster->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="aktif" {{ old('status', $cluster->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status', $cluster->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 2: Detail & Fasilitas -->
                    <div class="tab-pane" id="detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Total Unit <span class="text-danger">*</span></label>
                                <input type="number" name="total_unit" class="form-control @error('total_unit') is-invalid @enderror" 
                                       value="{{ old('total_unit', $cluster->total_unit) }}" min="0" required>
                                @error('total_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Unit Tersedia <span class="text-danger">*</span></label>
                                <input type="number" name="unit_tersedia" class="form-control @error('unit_tersedia') is-invalid @enderror" 
                                       value="{{ old('unit_tersedia', $cluster->unit_tersedia) }}" min="0" required>
                                @error('unit_tersedia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Luas Total (m²)</label>
                                <input type="number" step="0.01" name="luas_total" class="form-control @error('luas_total') is-invalid @enderror" 
                                       value="{{ old('luas_total', $cluster->luas_total) }}" placeholder="10000">
                                @error('luas_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Sertifikat</label>
                                <select name="sertifikat" class="form-select @error('sertifikat') is-invalid @enderror">
                                    <option value="SHM" {{ old('sertifikat', $cluster->sertifikat) == 'SHM' ? 'selected' : '' }}>SHM</option>
                                    <option value="HGB" {{ old('sertifikat', $cluster->sertifikat) == 'HGB' ? 'selected' : '' }}>HGB</option>
                                    <option value="HPL" {{ old('sertifikat', $cluster->sertifikat) == 'HPL' ? 'selected' : '' }}>HPL</option>
                                    <option value="Lainnya" {{ old('sertifikat', $cluster->sertifikat) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('sertifikat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Daya Listrik</label>
                                <select name="listrik" class="form-select @error('listrik') is-invalid @enderror">
                                    <option value="">Pilih Daya</option>
                                    <option value="450" {{ old('listrik', $cluster->listrik) == '450' ? 'selected' : '' }}>450 VA</option>
                                    <option value="900" {{ old('listrik', $cluster->listrik) == '900' ? 'selected' : '' }}>900 VA</option>
                                    <option value="1300" {{ old('listrik', $cluster->listrik) == '1300' ? 'selected' : '' }}>1300 VA</option>
                                    <option value="2200" {{ old('listrik', $cluster->listrik) == '2200' ? 'selected' : '' }}>2200 VA</option>
                                    <option value="3500" {{ old('listrik', $cluster->listrik) == '3500' ? 'selected' : '' }}>3500 VA</option>
                                    <option value="4400+" {{ old('listrik', $cluster->listrik) == '4400+' ? 'selected' : '' }}>4400+ VA</option>
                                </select>
                                @error('listrik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Tanggal Launching</label>
                                <input type="date" name="tanggal_launching" class="form-control @error('tanggal_launching') is-invalid @enderror" 
                                       value="{{ old('tanggal_launching', $cluster->tanggal_launching) }}">
                                @error('tanggal_launching')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Deskripsi Cluster</label>
                                <textarea name="deskripsi_cluster" class="form-control @error('deskripsi_cluster') is-invalid @enderror" 
                                          rows="4" placeholder="Deskripsikan cluster ini...">{{ old('deskripsi_cluster', $cluster->deskripsi_cluster) }}</textarea>
                                @error('deskripsi_cluster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Fasilitas</label>
                                <div class="row">
                                    @php
                                        $fasilitasList = [
                                            'Masjid/Mushola', 'Taman', 'Playground', 'Jogging Track',
                                            'Kolam Renang', 'Fitness Center', 'Tempat Parkir Luas',
                                            'One Gate System', 'Keamanan 24 Jam', 'Akses Air Bersih',
                                            'Listrik', 'Jalan Beraspal', 'Drainase Baik', 'SPBU',
                                            'Minimarket', 'Sekolah', 'Rumah Sakit', 'Transportasi Umum'
                                        ];
                                        
                                        // Ambil fasilitas yang sudah dipilih (langsung dari array)
                                        $fasilitasTerpilih = is_array($cluster->fasilitas) ? $cluster->fasilitas : [];
                                        $oldFasilitas = old('fasilitas', []);
                                        $selectedFasilitas = array_unique(array_merge($fasilitasTerpilih, $oldFasilitas));
                                    @endphp

                                    @foreach($fasilitasList as $fasilitas)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="fasilitas[]" value="{{ $fasilitas }}" 
                                                    class="form-check-input" id="fasilitas_{{ Str::slug($fasilitas) }}"
                                                    {{ in_array($fasilitas, $selectedFasilitas) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fasilitas_{{ Str::slug($fasilitas) }}">
                                                    {{ $fasilitas }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Fitur Keamanan</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="akses_air_bersih" class="form-check-input" id="akses_air_bersih" value="1"
                                                   {{ old('akses_air_bersih', $cluster->akses_air_bersih) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="akses_air_bersih">Akses Air Bersih</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="keamanan_24jam" class="form-check-input" id="keamanan_24jam" value="1"
                                                   {{ old('keamanan_24jam', $cluster->keamanan_24jam) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="keamanan_24jam">Keamanan 24 Jam</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="one_gate_system" class="form-check-input" id="one_gate_system" value="1"
                                                   {{ old('one_gate_system', $cluster->one_gate_system) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="one_gate_system">One Gate System</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 3: Gambar & Media -->
                    <div class="tab-pane" id="gambar" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Logo Cluster</label>
                                @if($cluster->logo_cluster)
                                    <div class="mb-2">
                                        <img src="{{ asset($cluster->logo_cluster) }}" class="img-fluid rounded border p-1" style="max-height: 80px;">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="hapus_logo" class="form-check-input" id="hapus_logo" value="1">
                                            <label class="form-check-label text-danger" for="hapus_logo">Hapus logo</label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="logo_cluster" class="form-control @error('logo_cluster') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(this, 'preview-logo')">
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                                @error('logo_cluster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="mt-2 text-center" id="preview-logo-container" style="display: none;">
                                    <img id="preview-logo" src="#" alt="Preview Logo" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gambar Cluster</label>
                                @if($cluster->gambar_cluster)
                                    <div class="mb-2">
                                        <img src="{{ asset($cluster->gambar_cluster) }}" class="img-fluid rounded border p-1" style="max-height: 80px;">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="hapus_gambar" class="form-check-input" id="hapus_gambar" value="1">
                                            <label class="form-check-label text-danger" for="hapus_gambar">Hapus gambar utama</label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="gambar_cluster" class="form-control @error('gambar_cluster') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(this, 'preview-utama')">
                                <small class="text-muted">Format: JPG, PNG. Maks: 5MB</small>
                                @error('gambar_cluster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="mt-2 text-center" id="preview-utama-container" style="display: none;">
                                    <img id="preview-utama" src="#" alt="Preview Gambar Cluster" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Foto Lainnya (Multiple)</label>
                                @php
                                    $fotoLainnya = [];
                                    if (!empty($cluster->foto_lainnya)) {
                                        if (is_string($cluster->foto_lainnya)) {
                                            $fotoLainnya = json_decode($cluster->foto_lainnya, true) ?? [];
                                        } elseif (is_array($cluster->foto_lainnya)) {
                                            $fotoLainnya = $cluster->foto_lainnya;
                                        }
                                    }
                                    $fotoLainnya = array_filter($fotoLainnya, function($item) {
                                        return is_string($item) && !empty($item);
                                    });
                                @endphp
                                
                                @if(count($fotoLainnya) > 0)
                                    <div class="mb-2">
                                        <div class="row">
                                            @foreach($fotoLainnya as $index => $foto)
                                            <div class="col-md-2 mb-2">
                                                <img src="{{ asset($foto) }}" class="img-fluid rounded border p-1" style="height: 60px; width: 100%; object-fit: cover;">
                                                <div class="form-check mt-1">
                                                    <input type="checkbox" name="hapus_foto_lainnya[]" value="{{ $index }}" class="form-check-input">
                                                    <label class="form-check-label small text-danger">Hapus</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file" name="foto_lainnya[]" class="form-control @error('foto_lainnya.*') is-invalid @enderror" 
                                    accept="image/*" multiple onchange="previewMultipleImages(this)">
                                <small class="text-muted">Format: JPG, PNG. Maks: 5MB per file. Bisa pilih lebih dari 1 file</small>
                                @error('foto_lainnya.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="row mt-3" id="preview-multiple-container"></div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Video Profil (URL YouTube)</label>
                                <input type="url" name="video_profil" class="form-control @error('video_profil') is-invalid @enderror" 
                                       value="{{ old('video_profil', $cluster->video_profil ?? '') }}" placeholder="https://www.youtube.com/watch?v=...">
                                @error('video_profil')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Submit -->
                <div class="text-end mt-4 pt-3 border-top">
                    <a href="{{ route('cluster.index') }}" class="btn btn-light me-2">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-2"></i>Update Cluster
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
    
    function previewMultipleImages(input) {
        const container = document.getElementById('preview-multiple-container');
        if (!container) return;
        container.innerHTML = '';
        
        if (input.files) {
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                        <div class="border rounded p-2">
                            <img src="${e.target.result}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                            <p class="small text-truncate mt-2 mb-0">${file.name}</p>
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