@extends('layouts.layout')

@section('title', 'Manajemen Galeri - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-images me-2 text-success"></i>
        Manajemen Galeri
    </h4>
    <a href="{{ route('galeri.create') }}" class="btn btn-green">
        <i class="fas fa-plus me-2"></i>Tambah Foto
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-images fa-2x text-primary"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Foto</h6>
                    <h3 class="fw-bold mb-0">{{ $totalGaleri }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Aktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalAktif }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Nonaktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalGaleri - $totalAktif }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-tag fa-2x text-info"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Kategori</h6>
                    <h3 class="fw-bold mb-0">{{ count($kategoriList) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <form method="GET" action="{{ route('galeri.index') }}" class="row g-3">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Foto</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Cari judul galeri..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <select name="kategori_foto" class="form-select bg-light border-0">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori_foto') == $kat ? 'selected' : '' }}>
                        {{ ucfirst($kat) }}
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
            </select>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-green w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Grid Galeri -->
<div class="row g-4">
    @forelse($galeri as $item)
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <!-- Gambar -->
            <div class="position-relative">
                @if(!empty($item->foto))
                    <img
                        src="{{ route('media.galeri', basename($item->foto)) }}"
                        class="card-img-top rounded-top-4"
                        style="height:180px;width:100%;object-fit:cover;"
                        alt="{{ $item->judul_galeri }}"
                        onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'bg-light rounded-top-4 d-flex flex-column align-items-center justify-content-center\' style=\'height:180px;\'><i class=\'fas fa-image fa-4x text-muted mb-2\'></i><small class=\'text-muted\'>Gambar tidak ditemukan</small></div>';"
                    >
                @else
                    <div class="bg-light rounded-top-4 d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                        <i class="fas fa-image fa-4x text-muted mb-2"></i>
                        <small class="text-muted">Tidak ada gambar</small>
                    </div>
                @endif
                
                <!-- Badge status -->
                <div class="position-absolute top-0 end-0 m-2">
                    @if($item->status == 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </div>
                
                <!-- Badge kategori -->
                <div class="position-absolute bottom-0 start-0 m-2">
                    <span class="badge bg-dark bg-opacity-75">{{ $item->kategori_foto }}</span>
                </div>
            </div>
            
            <!-- Body -->
            <div class="card-body">
                <h6 class="fw-bold mb-1">{{ Str::limit($item->judul_galeri, 40) }}</h6>
                <small class="text-muted d-block mb-2">
                    <i class="fas fa-calendar me-1"></i>{{ $item->created_at->format('d/m/Y') }}
                </small>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-arrow-up me-1"></i> Kategori: {{ ucfirst($item->kategori_foto) }}
                    </span>
                    <div class="btn-group">
                        <a href="{{ route('galeri.edit', $item->id_galeri) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmDelete({{ $item->id_galeri }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $item->id_galeri }}" action="{{ route('galeri.destroy', $item->id_galeri) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="fas fa-images fa-4x text-muted mb-3"></i>
            <h6 class="text-muted">Belum ada foto di galeri</h6>
            <a href="{{ route('galeri.create') }}" class="btn btn-green btn-sm mt-2">
                <i class="fas fa-plus me-2"></i>Tambah Foto Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $galeri->withQueryString()->links() }}
</div>

<style>
    .card-img-top {
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
    }
</style>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Foto akan dihapus permanen!",
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