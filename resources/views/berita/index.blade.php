@extends('layouts.layout')

@section('title', 'Manajemen Berita - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-newspaper me-2 text-success"></i>
        Manajemen Berita
    </h4>
    <a href="{{ route('berita.create') }}" class="btn btn-green">
        <i class="fas fa-plus me-2"></i>Tulis Berita Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-newspaper fa-2x text-primary"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Berita</h6>
                    <h3 class="fw-bold mb-0">{{ $totalBerita }}</h3>
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
                    <h6 class="text-muted mb-1">Published</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPublished }}</h3>
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
                    <h6 class="text-muted mb-1">Draft</h6>
                    <h3 class="fw-bold mb-0">{{ $totalDraft }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-eye fa-2x text-info"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Views</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($berita->sum('views')) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <form method="GET" action="{{ route('berita.index') }}" class="row g-3">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Berita</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Judul atau konten..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <select name="kategori" class="form-select bg-light border-0">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select bg-light border-0">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
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

<!-- List Berita (menyusun ke bawah) -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        @forelse($berita as $item)
        <div class="border-bottom p-4 hover-bg-light">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <!-- Status Badge -->
                    <div class="mb-2">
                        @if($item->status == 'published')
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                        <span class="badge bg-light text-dark ms-2">{{ $item->kategori }}</span>
                    </div>
                    
                    <!-- Judul -->
                    <h5 class="fw-bold mb-2">
                        <a href="{{ route('berita.show', $item->slug) }}" class="text-decoration-none text-dark">
                            {{ $item->judul }}
                        </a>
                    </h5>
                    
                    <!-- Meta Info -->
                    <div class="text-muted small mb-2">
                        <i class="fas fa-user me-1"></i>{{ $item->penulis }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-calendar me-1"></i>{{ $item->created_at->format('d/m/Y') }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-eye me-1"></i>{{ number_format($item->views) }} views
                    </div>
                    
                    <!-- Konten Preview -->
                    <p class="text-muted mb-0">{{ Str::limit(strip_tags($item->konten), 120) }}</p>
                </div>
                
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <!-- Gambar jika ada - PERBAIKAN DI SINI -->
                    @php
                        $gambarPath = $item->gambar;
                        $gambarExists = $gambarPath && file_exists(public_path($gambarPath));
                    @endphp
                    
                    @if($gambarExists)
                        <img src="{{ asset($gambarPath) }}" class="rounded" style="width: 80px; height: 60px; object-fit: cover;" alt="{{ $item->judul }}">
                    @else
                        <div class="bg-light rounded d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                            <i class="fas fa-newspaper text-muted"></i>
                        </div>
                    @endif
                    
                    <!-- Tombol Aksi -->
                    <div class="btn-group ms-2">
                        <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('berita.destroy', $item->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
            <h6 class="text-muted">Belum ada berita</h6>
            <a href="{{ route('berita.create') }}" class="btn btn-green btn-sm mt-2">
                <i class="fas fa-plus me-2"></i>Tulis Berita Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $berita->withQueryString()->links() }}
</div>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }
</style>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Berita akan dihapus permanen!",
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