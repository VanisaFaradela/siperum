@extends('layouts.app')

@section('title', $cluster->nama_cluster . ' - SIPERUM')

@section('content')
<div class="container py-4">
    <!-- Header dengan judul -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-building me-2 text-success"></i>
                {{ $cluster->nama_cluster }}
            </h4>
            <p class="text-muted small">
                <i class="fas fa-map-marker-alt me-1"></i>
                {{ $cluster->lokasi_cluster }}, {{ $cluster->kota }}, {{ $cluster->provinsi }}
            </p>
        </div>
        <div>
            {{-- PERBAIKAN: gunakan cluster_id, bukan id --}}
            <a href="{{ route('cluster.edit', $cluster->cluster_id) }}" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('cluster.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Tab Navigation -->
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
            <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab">
                <i class="fas fa-image me-2"></i>Gambar & Media
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB 1: INFORMASI DASAR -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Nama Cluster</label>
                                <p class="fw-semibold mb-0">{{ $cluster->nama_cluster }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Lokasi Cluster</label>
                                <p class="mb-0">{{ $cluster->lokasi_cluster }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Kota</label>
                                <p class="mb-0">{{ $cluster->kota }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Provinsi</label>
                                <p class="mb-0">{{ $cluster->provinsi }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Kontak Pengembang</label>
                                <p class="mb-0">{{ $cluster->kontak_pengembang }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Email Pengembang</label>
                                <p class="mb-0">{{ $cluster->email_pengembang ?: '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Website</label>
                                <p class="mb-0">
                                    @if($cluster->website)
                                        <a href="{{ $cluster->website }}" target="_blank">{{ $cluster->website }}</a>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Status</label>
                                <p class="mb-0">
                                    @if($cluster->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($cluster->status == 'draft')
                                        <span class="badge bg-secondary">Draft</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: DETAIL & FASILITAS -->
        <div class="tab-pane fade" id="detail" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Total Unit</label>
                                <p class="fw-semibold mb-0">{{ number_format($cluster->total_unit) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Unit Tersedia</label>
                                <p class="fw-semibold mb-0">{{ number_format($cluster->unit_tersedia) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Unit Terjual</label>
                                <p class="fw-semibold mb-0">{{ number_format($cluster->unit_terjual) }}</p>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-success" style="width: {{ $cluster->persentase_terjual }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Nama Pengembang</label>
                                <p class="mb-0">{{ $cluster->nama_pengembang }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Sertifikat</label>
                                <p class="mb-0">{{ $cluster->sertifikat ?: '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Daya Listrik</label>
                                <p class="mb-0">{{ $cluster->listrik ? $cluster->listrik . ' VA' : '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Tanggal Launching</label>
                                <p class="mb-0">{{ $cluster->tanggal_launching ? date('d/m/Y', strtotime($cluster->tanggal_launching)) : '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-semibold">Luas Total</label>
                                <p class="mb-0">{{ $cluster->luas_total ? number_format($cluster->luas_total) . ' m²' : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Cluster -->
                    <div class="mt-2">
                        <label class="text-muted small text-uppercase fw-semibold">Deskripsi Cluster</label>
                        <p class="mb-0">{{ $cluster->deskripsi_cluster ?: 'Belum ada deskripsi.' }}</p>
                    </div>

                    <!-- Fasilitas -->
                    @php
                        $fasilitasArray = is_array($cluster->fasilitas) ? $cluster->fasilitas : [];
                    @endphp

                    @if(count($fasilitasArray) > 0)
                    <div class="mt-4">
                        <label class="text-muted small text-uppercase fw-semibold mb-2">Fasilitas</label>
                        <div class="row">
                            @foreach($fasilitasArray as $fasilitas)
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>{{ $fasilitas }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- TAB 3: GAMBAR & MEDIA -->
        <div class="tab-pane fade" id="media" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <label class="text-muted small text-uppercase fw-semibold mb-2">Logo Cluster</label>
                            <div class="border rounded-3 p-3 bg-light">
                                @if($cluster->logo_cluster)
                                    <img src="{{ url($cluster->logo_cluster) }}">
                                @else
                                    <i class="fas fa-building fa-4x text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada logo</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="text-muted small text-uppercase fw-semibold mb-2">Gambar Cluster</label>
                            <div class="border rounded-3 p-3 bg-light">
                                @if($cluster->gambar_cluster)
                                    <img src="{{ url($cluster->gambar_cluster) }}">
                                @else
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada gambar utama</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Foto Lainnya -->
                    @php
                        $fotoLainnya = [];
                        if ($cluster->foto_lainnya) {
                            if (is_string($cluster->foto_lainnya)) {
                                $fotoLainnya = json_decode($cluster->foto_lainnya, true) ?? [];
                            } elseif (is_array($cluster->foto_lainnya)) {
                                $fotoLainnya = $cluster->foto_lainnya;
                            }
                        }
                    @endphp
                    @if(count($fotoLainnya) > 0)
                    <div class="mt-4">
                        <label class="text-muted small text-uppercase fw-semibold mb-2">Foto Lainnya</label>
                        <div class="row">
                            @foreach($fotoLainnya as $foto)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ url($foto) }}" class="img-fluid rounded border" style="height: 150px; width: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Koordinat -->
                    <div class="mt-4">
                        <label class="text-muted small text-uppercase fw-semibold mb-2">Lokasi Maps</label>
                        @if($cluster->latitude && $cluster->longitude)
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt text-success me-2"></i>
                                Lat: {{ $cluster->latitude }}, Lng: {{ $cluster->longitude }}
                            </p>
                            <a href="https://maps.google.com/?q={{ $cluster->latitude }},{{ $cluster->longitude }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-map-marker-alt me-2"></i>Lihat di Google Maps
                            </a>
                        @else
                            <p class="text-muted">Belum ada koordinat</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tipe Rumah Section -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-semibold mb-0">
                <i class="fas fa-tags me-2 text-success"></i>Tipe Rumah
            </h5>
            {{-- PERBAIKAN: gunakan cluster_id --}}
            <a href="{{ route('tipe-rumah.create', ['cluster_id' => $cluster->cluster_id]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-2"></i>Tambah Tipe
            </a>
        </div>
        <div class="card-body p-0">
            @if($cluster->tipeRumah && $cluster->tipeRumah->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Tipe</th>
                                <th>Luas Bangunan</th>
                                <th>Luas Tanah</th>
                                <th>Kamar</th>
                                <th>Harga</th>
                                <th width="15%">Unit</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cluster->tipeRumah as $index => $tipe)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $tipe->nama_tipe }}</strong>
                                    @if($tipe->status == 'promo')
                                        <span class="badge bg-danger ms-1">Promo</span>
                                    @endif
                                </td>
                                <td>{{ $tipe->luas_bangunan }} m²</td>
                                <td>{{ $tipe->luas_tanah }} m²</td>
                                <td>{{ $tipe->kamar_tidur }} KT / {{ $tipe->kamar_mandi }} KM</td>
                                <td>
                                    @if($tipe->harga_promo)
                                        <span class="text-decoration-line-through text-muted small">Rp {{ number_format($tipe->harga, 0, ',', '.') }}</span>
                                        <br>
                                        <span class="text-success fw-bold">Rp {{ number_format($tipe->harga_promo, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format($tipe->harga, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($tipe->status_unit) && $tipe->status_unit == 'terjual')
                                        <span class="badge bg-secondary">Terjual</span>
                                    @elseif(isset($tipe->status_unit) && $tipe->status_unit == 'booking')
                                        <span class="badge bg-warning text-dark">Booking</span>
                                    @else
                                        {{-- Termasuk status 'tersedia' dan juga status 'promo' tetap dianggap tersedia --}}
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif

                                    @if(!empty($tipe->blok) || !empty($tipe->nomor_unit))
                                        <div class="text-muted small mt-1">
                                            {{ $tipe->blok ? 'Blok: '.$tipe->blok : '' }}
                                            {{ $tipe->nomor_unit ? ' / No: '.$tipe->nomor_unit : '' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tipe-rumah.edit', $tipe->id_tipe) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tipe-rumah.destroy', $tipe->id_tipe) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus tipe rumah {{ $tipe->nama_tipe }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-home fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada tipe rumah</p>
                    <a href="{{ route('tipe-rumah.create', ['cluster_id' => $cluster->cluster_id]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-2"></i>Tambah Tipe Rumah
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .nav-tabs .nav-link i {
        margin-right: 8px;
    }
    
    .nav-tabs .nav-link.active {
        color: #2e7d32;
        background-color: transparent;
        border-bottom: 3px solid #2e7d32;
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
        color: #495057;
        background-color: #f8f9fa;
    }
    
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background: white;
    }
    
    .table th, .table td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        padding: 5px 10px;
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
    }
</style>

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm('Yakin ingin menghapus tipe rumah "' + name + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@if(session('success'))
    <script>
        setTimeout(function() {
            location.reload();
        }, 500);
    </script>
@endif
@endpush
@endsection