@extends('layouts.layout')

@section('title', 'Manajemen Halaman - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-file-alt me-2 text-success"></i>
        Manajemen Halaman
    </h4>
    <a href="{{ route('pages.create') }}" class="btn btn-green">
        <i class="fas fa-plus me-2"></i>Tambah Halaman Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-perumahan p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-file-alt fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Halaman</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPages ?? $pages->total() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-perumahan p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Published</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPublished ?? $pages->where('status', 'published')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-perumahan p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Draft</h6>
                    <h3 class="fw-bold mb-0">{{ $totalDraft ?? $pages->where('status', 'draft')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-perumahan p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fab fa-youtube fa-2x text-danger"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Dengan Video</h6>
                    <h3 class="fw-bold mb-0">{{ $totalVideo ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Halaman Default Info -->
<div class="alert alert-info alert-dismissible fade show mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Halaman Default:</strong> Tentang Kami, Kontak, Beranda, Kebijakan Privasi, dll. Buat halaman dengan slug yang sesuai.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Filter Section -->
<div class="card-perumahan p-4 mb-4">
    <form method="GET" action="{{ route('pages.index') }}" class="row g-3">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Halaman</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Judul halaman..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
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
        
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sync-alt me-2"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Tabel Halaman -->
<div class="card-perumahan p-4">
    <div class="table-responsive">
        <table class="table table-perumahan table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="60">Gambar</th>
                    <th>Judul Halaman</th>
                    <th>Slug</th>
                    <th>Video</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th width="130">Aksi</th>
                </thead>
            <tbody>
                @forelse($pages as $index => $item)
                <tr>
                    <td class="text-center">{{ $pages->firstItem() + $index }}</td>
                    <td>
                        @if($item->featured_image)
                            <img src="{{ route('media.pages', ['file' => basename($item->featured_image)]) }}"
                                 class="rounded"
                                 style="width: 50px; height: 45px; object-fit: cover;" alt="Gambar">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 45px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/' . $item->slug) }}" target="_blank" class="text-decoration-none fw-semibold text-dark">
                            {{ $item->title }}
                        </a>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-link me-1"></i>/{{ $item->slug }}
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $item->slug }}</span>
                    </td>
                    <td>
                        @if($item->video)
                            <span class="badge bg-danger">
                                <i class="fab fa-youtube me-1"></i>Ada Video
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-video-slash me-1"></i>Tidak Ada
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'published')
                            <span class="status-badge status-aktif">
                                <i class="fas fa-check-circle me-1"></i>Published
                            </span>
                        @else
                            <span class="status-badge status-draft">
                                <i class="fas fa-clock me-1"></i>Draft
                            </span>
                        @endif
                    </td>
                    <td>
                        <small>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</small>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('pages.edit', $item->id) }}" class="btn btn-sm btn-outline-warning"
                               data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="tooltip" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('pages.destroy', $item->id) }}" 
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada halaman</h6>
                        <a href="{{ route('pages.create') }}" class="btn btn-green btn-sm mt-2">
                            <i class="fas fa-plus me-2"></i>Tambah Halaman Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $pages->withQueryString()->links() }}
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
            text: "Halaman akan dihapus permanen!",
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