@extends('layouts.layout')

@section('title', 'Daftar Tipe Rumah - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-tags me-2 text-success"></i>
        Manajemen Tipe Rumah
    </h4>
    @if(isset($cluster))
        <a href="{{ route('cluster.show', $cluster->cluster_id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke {{ $cluster->nama_cluster }}
        </a>
    @else
        <a href="{{ route('cluster.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-building me-2"></i>Pilih Cluster
        </a>
    @endif
</div>

@if(isset($cluster))
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-info-circle me-2"></i>
    Menampilkan tipe rumah untuk: <strong>{{ $cluster->nama_cluster }}</strong>
    <a href="{{ route('tipe-rumah.index') }}" class="float-end text-decoration-none">
        <i class="fas fa-times"></i> Reset
    </a>
</div>
@endif

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-tags fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Tipe</h6>
                    <h3 class="fw-bold mb-0">{{ $tipeRumah->total() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Tersedia</h6>
                    <h3 class="fw-bold mb-0">{{ $tipeRumah->where('status', 'tersedia')->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-fire fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Promo</h6>
                    <h3 class="fw-bold mb-0">{{ $tipeRumah->where('status', 'promo')->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Habis</h6>
                    <h3 class="fw-bold mb-0">{{ $tipeRumah->where('status', 'habis')->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-cluster p-4 mb-4">
    <form method="GET" action="{{ route('tipe-rumah.index') }}" class="row g-3">
        @if(isset($cluster))
            <input type="hidden" name="cluster_id" value="{{ $cluster->cluster_id }}">
        @endif
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Tipe Rumah</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Nama tipe..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select bg-light border-0">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="promo" {{ request('status') == 'promo' ? 'selected' : '' }}>Promo</option>
                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Urutkan</label>
            <select name="sort" class="form-select bg-light border-0">
                <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-green w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Tabel Tipe Rumah -->
<div class="card-cluster p-4">
    <div class="table-responsive">
        <table class="table table-cluster table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Tipe</th>
                    <th>Cluster</th>
                    <th>Luas Bangunan</th>
                    <th>Luas Tanah</th>
                    <th>Kamar</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th width="130">Aksi</th>
                </thead>
            <tbody>
                @forelse($tipeRumah as $index => $item)
                <tr>
                    <td class="text-center">{{ $tipeRumah->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $item->nama_tipe }}</strong>
                        @if($item->status == 'promo')
                            <span class="badge bg-danger ms-1">Promo!</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cluster.show', $item->cluster->cluster_id) }}" class="text-decoration-none">
                            {{ $item->cluster->nama_cluster ?? '-' }}
                        </a>
                    </td>
                    <td>{{ $item->luas_bangunan ?? '-' }} m²</td>
                    <td>{{ $item->luas_tanah ?? '-' }} m²</td>
                    <td>{{ $item->kamar_tidur ?? '0' }} KT / {{ $item->kamar_mandi ?? '0' }} KM</td>
                    <td style="min-width: 150px;">
                        @if($item->harga_promo && $item->status == 'promo')
                            <span class="text-decoration-line-through text-muted small">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            <br>
                            <span class="text-danger fw-bold">Rp {{ number_format($item->harga_promo, 0, ',', '.') }}</span>
                        @else
                            <span class="fw-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'tersedia')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Tersedia
                            </span>
                        @elseif($item->status == 'promo')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-fire me-1"></i>Promo
                            </span>
                        @elseif($item->status == 'habis')
                            <span class="badge bg-secondary">
                                <i class="fas fa-times-circle me-1"></i>Habis
                            </span>
                        @else
                            <span class="badge bg-dark">
                                <i class="fas fa-clock me-1"></i>{{ ucfirst($item->status) }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <!-- Tombol Show/Detail -->
                            <a href="{{ route('tipe-rumah.show', $item->id_tipe) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <!-- Tombol Edit -->
                            <a href="{{ route('tipe-rumah.edit', $item->id_tipe) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Tombol Hapus -->
                            <button onclick="confirmDelete({{ $item->id_tipe }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->id_tipe }}" action="{{ route('tipe-rumah.destroy', $item->id_tipe) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-5">
                        <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada data tipe rumah</h6>
                        @if(isset($cluster))
                            <a href="{{route('tipe-rumah.create', ['cluster_id' => $cluster->cluster_id])}}" class="btn btn-green btn-sm mt-2">
                                <i class="fas fa-plus me-2"></i>Tambah Tipe Rumah
                            </a>
                        @else
                            <a href="{{ route('cluster.index') }}" class="btn btn-green btn-sm mt-2">
                                <i class="fas fa-building me-2"></i>Pilih Cluster
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $tipeRumah->withQueryString()->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data tipe rumah akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection