@extends('layouts.app')

@section('title', ($tipeRumah->nama_tipe ?? 'Detail Tipe Rumah') . ' - SIPERUM')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-tags me-2 text-success"></i>
                Detail Tipe Rumah
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-building me-1 text-success"></i>
                Cluster: <strong>{{ $tipeRumah->cluster->nama_cluster ?? '-' }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('tipe-rumah.edit', $tipeRumah->id_tipe) }}" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('cluster.show', $tipeRumah->cluster->slug) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Informasi Utama -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-semibold mb-0">
                        <i class="fas fa-info-circle me-2 text-success"></i>Informasi Utama
                    </h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%"><strong>Nama Tipe</strong></td>
                            <td>: {{ $tipeRumah->nama_tipe ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cluster</strong></td>
                            <td>: {{ $tipeRumah->cluster->nama_cluster ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Luas Bangunan</strong></td>
                            <td>: {{ $tipeRumah->luas_bangunan ?? 0 }} m²</td>
                        </tr>
                        <tr>
                            <td><strong>Luas Tanah</strong></td>
                            <td>: {{ $tipeRumah->luas_tanah ?? 0 }} m²</td>
                        </tr>
                        <tr>
                            <td><strong>Kamar Tidur</strong></td>
                            <td>: {{ $tipeRumah->kamar_tidur ?? 0 }} KT</td>
                        </tr>
                        <tr>
                            <td><strong>Kamar Mandi</strong></td>
                            <td>: {{ $tipeRumah->kamar_mandi ?? 0 }} KM</td>
                        </tr>
                        <tr>
                            <td><strong>Parkiran</strong></td>
                            <td>: {{ $tipeRumah->parkiran ?? 0 }} Mobil</td>
                        </tr>
                        <tr>
                            <td><strong>Blok</strong></td>
                            <td>: {{ $tipeRumah->blok ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Unit</strong></td>
                            <td>: {{ $tipeRumah->nomor_unit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status Unit</strong></td>
                            <td>: 
                                @php $statusUnit = $tipeRumah->status_unit ?? 'tersedia'; @endphp
                                @if($statusUnit == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif($statusUnit == 'booking')
                                    <span class="badge bg-warning text-dark">Booking</span>
                                @elseif($statusUnit == 'terjual')
                                    <span class="badge bg-secondary">Terjual</span>
                                @else
                                    <span class="badge bg-secondary">Tersedia</span>
                                @endif
                             </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Harga & Unit -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-semibold mb-0">
                        <i class="fas fa-money-bill-wave me-2 text-success"></i>Harga & Unit
                    </h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%"><strong>Harga Normal</strong></td>
                            <td>: Rp {{ number_format($tipeRumah->harga ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @if(($tipeRumah->harga_promo ?? 0) > 0)
                        <tr>
                            <td><strong>Harga Promo</strong></td>
                            <td>: <span class="text-danger fw-bold">Rp {{ number_format($tipeRumah->harga_promo, 0, ',', '.') }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Diskon</strong></td>
                            <td>: 
                                @php
                                    $harga = $tipeRumah->harga ?? 0;
                                    $hargaPromo = $tipeRumah->harga_promo ?? 0;
                                    $diskon = $harga > 0 ? (($harga - $hargaPromo) / $harga) * 100 : 0;
                                @endphp
                                <span class="badge bg-danger">{{ round($diskon) }}%</span>
                             </td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @php $status = $tipeRumah->status ?? 'tersedia'; @endphp
                                @if($status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif($status == 'promo')
                                    <span class="badge bg-warning text-dark">Promo</span>
                                @elseif($status == 'habis')
                                    <span class="badge bg-secondary">Habis</span>
                                @else
                                    <span class="badge bg-secondary">{{ $status }}</span>
                                @endif
                             </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    @if($tipeRumah->deskripsi)
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-semibold mb-0">
                <i class="fas fa-align-left me-2 text-success"></i>Deskripsi
            </h5>
        </div>
        <div class="card-body p-4">
            <p class="mb-0">{{ $tipeRumah->deskripsi }}</p>
        </div>
    </div>
    @endif

    <!-- Foto Denah -->
   @if($tipeRumah->foto_denah)
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-semibold mb-0">
                <i class="fas fa-draw-polygon me-2 text-success"></i>Foto Denah
            </h5>
        </div>
        <div class="card-body p-4 text-center">
           <img
            src="{{ route('media.tipe-rumah', $tipeRumah->foto_denah) }}"
            class="img-fluid rounded"
            style="max-height:400px;"
            alt="Denah {{ $tipeRumah->nama_tipe }}">
        </div>
    </div>
    @endif

    <!-- Foto Rumah -->
    @php
        $fotoRumah = [];
        if ($tipeRumah->foto_rumah) {
            if (is_string($tipeRumah->foto_rumah)) {
                $fotoRumah = json_decode($tipeRumah->foto_rumah, true) ?? [];
            } elseif (is_array($tipeRumah->foto_rumah)) {
                $fotoRumah = $tipeRumah->foto_rumah;
            }
        }
        $fotoRumah = is_array($fotoRumah) ? array_filter($fotoRumah) : [];
    @endphp

    @if(count($fotoRumah) > 0)
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-semibold mb-0">
                <i class="fas fa-images me-2 text-success"></i>Galeri Foto Rumah
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                @foreach($fotoRumah as $foto)
                <div class="col-md-3 col-6">
                    <div class="position-relative overflow-hidden rounded-3 shadow-sm" style="cursor: pointer;" onclick="openLightbox('{{ route('media.tipe-rumah', $foto) }}')">
                        <img
                        src="{{ route('media.tipe-rumah', $foto) }}"
                        class="img-fluid w-100"
                        style="height:180px; object-fit:cover;"
                        alt="Foto Rumah">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white text-center py-1">
                            <i class="fas fa-search-plus"></i> Lihat
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; cursor: pointer; text-align: center;">
        <span onclick="closeLightbox()" style="position: absolute; top: 20px; right: 40px; color: white; font-size: 50px; cursor: pointer;">&times;</span>
        <img id="lightboxImg" src="" style="max-width: 90%; max-height: 90%; margin-top: 5%; object-fit: contain;">
    </div>
    @endif

    <!-- Tipe Rumah Lainnya -->
    @if(isset($tipeLainnya) && $tipeLainnya->count() > 0)
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-semibold mb-0">
                <i class="fas fa-tags me-2 text-success"></i>Tipe Rumah Lainnya di Cluster Ini
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                @foreach($tipeLainnya as $tipe)
                <div class="col-md-3 col-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 text-center p-3">
                        <i class="fas fa-home fa-3x text-success mb-2"></i>
                        <h6 class="fw-bold mb-1">{{ $tipe->nama_tipe ?? '-' }}</h6>
                        <p class="text-muted small mb-2">{{ $tipe->luas_bangunan ?? 0 }} m² / {{ $tipe->luas_tanah ?? 0 }} m²</p>
                        <p class="fw-bold text-success mb-0">Rp {{ number_format($tipe->harga ?? 0, 0, ',', '.') }}</p>
                        <a href="{{ route('tipe-rumah.show', $tipe->id_tipe) }}" class="btn btn-sm btn-outline-success mt-2">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .table-borderless tr td {
        padding: 8px 0;
    }
    .card {
        border-radius: 1rem;
    }
</style>

@push('scripts')
<script>
    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightbox').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = '';
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush
@endsection