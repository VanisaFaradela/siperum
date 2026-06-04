@extends('layouts.layout')

@section('title', 'Daftar Cluster - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-building me-2 text-success"></i>
        Manajemen Cluster
    </h4>
    <a href="{{ route('cluster.create') }}" class="btn btn-green">
        <i class="fas fa-plus me-2"></i>Tambah Cluster Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-building fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Cluster</h6>
                    <h3 class="fw-bold mb-0">{{ $totalCluster }}</h3>
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
                    <h6 class="text-muted mb-1">Cluster Aktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalAktif }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-home fa-2x text-info"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Unit</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($totalUnit) }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-chart-line fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Unit Terjual</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($totalTerjual) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-cluster p-4 mb-4">
    <form method="GET" action="{{ route('cluster.index') }}" class="row g-3">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Cluster</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Nama cluster, lokasi, atau kota..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Kota</label>
            <select name="kota" class="form-select bg-light border-0">
                <option value="">Semua Kota</option>
                @foreach($kotaList as $kota)
                    <option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>
                        {{ $kota }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select bg-light border-0">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-green w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Tabel Cluster -->
<div class="card-cluster p-4">
    <div class="table-responsive">
        <table class="table table-cluster table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="80">Logo</th>
                    <th>Nama Cluster</th>
                    <th>Kota</th>
                    <th>Pengembang</th>
                    <th>Unit</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
            </thead>
            <tbody>
                @forelse($clusters as $index => $item)
                <tr>
                    <td class="text-center">{{ $clusters->firstItem() + $index }}</td>
                    <td>
                        @if($item->logo_cluster)
                            <img src="{{ url($item->logo_cluster) }}" class="rounded-circle" 
                                 style="width: 50px; height: 50px; object-fit: cover;" alt="Logo">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-building fa-2x text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cluster.show', $item->slug) }}" class="text-decoration-none fw-semibold text-dark">
                            {{ $item->nama_cluster }}
                        </a>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($item->Alamat, 50) }}
                        </small>
                    </td>
                    <td>{{ $item->kota }}</td>
                    <td>{{ $item->nama_pengembang }}</td>
                    <td style="min-width: 80px;">
                        <span class="fw-bold">{{ number_format($item->unit_tersedia) }}</span>
                        <small class="text-muted">/{{ number_format($item->total_unit) }}</small>
                    </td>
                    <td style="min-width: 120px;">
                        @php $persen = $item->total_unit > 0 ? ($item->unit_terjual / $item->total_unit) * 100 : 0; @endphp
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height: 4px;">
                                <div class="progress-bar bg-success" style="width: {{ $persen }}%"></div>
                            </div>
                            <small class="fw-bold">{{ round($persen) }}%</small>
                        </div>
                    </td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="status-badge status-aktif">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        @elseif($item->status == 'nonaktif')
                            <span class="status-badge status-nonaktif">
                                <i class="fas fa-times-circle me-1"></i>Nonaktif
                            </span>
                        @else
                            <span class="status-badge status-draft">
                                <i class="fas fa-clock me-1"></i>Draft
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('cluster.show', $item->slug) }}" class="btn btn-sm btn-outline-info" 
                               data-bs-toggle="tooltip" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('cluster.edit', $item->cluster_id) }}" class="btn btn-sm btn-outline-warning"
                               data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $item->cluster_id }})" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="tooltip" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->cluster_id }}" action="{{ route('cluster.destroy', $item->cluster_id) }}" 
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-building fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada data cluster</h6>
                        <a href="{{ route('cluster.create') }}" class="btn btn-green btn-sm mt-2">
                            <i class="fas fa-plus me-2"></i>Tambah Cluster Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $clusters->withQueryString()->links() }}
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
    
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data cluster akan dihapus permanen!",
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