@extends('layouts.layout')

@section('title', 'Manajemen Kontak - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-address-book me-2 text-success"></i>
        Manajemen Kontak
    </h4>
    <a href="{{ route('kontak.create') }}" class="btn btn-green">
        <i class="fas fa-plus me-2"></i>Tambah Kontak
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-address-book fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Kontak</h6>
                    <h3 class="fw-bold mb-0">{{ $totalKontak ?? 0 }}</h3>
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
                    <h6 class="text-muted mb-1">Aktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalAktif ?? 0 }}</h3>
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
                    <h6 class="text-muted mb-1">Nonaktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalNonaktif ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-building fa-2x text-info"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Perusahaan</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPerusahaan ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-cluster p-4 mb-4">
    <form method="GET" action="{{ route('kontak.index') }}" class="row g-3">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Cari Kontak</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Nama, email, telepon, atau perusahaan..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select bg-light border-0">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Memiliki Perusahaan</label>
            <select name="has_perusahaan" class="form-select bg-light border-0">
                <option value="">Semua</option>
                <option value="yes" {{ request('has_perusahaan') == 'yes' ? 'selected' : '' }}>Memiliki Perusahaan</option>
                <option value="no" {{ request('has_perusahaan') == 'no' ? 'selected' : '' }}>Tanpa Perusahaan</option>
            </select>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-green w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Tabel Kontak -->
<div class="card-cluster p-4">
    <div class="table-responsive">
        <table class="table table-cluster table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th>Media Sosial</th>
                    <th>Tanggal</th>
                    <th width="160">Aksi</th>
                </thead>
            <tbody>
                @forelse($kontak as $index => $item)
                <tr class="{{ $item->status == 'nonaktif' ? 'text-muted' : '' }}">
                    <td class="text-center">{{ $kontak->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $item->nama }}</strong>
                    </td>
                    <td>{{ $item->email ?? '-' }}</td>
                    <td>{{ $item->telepon ?? '-' }}</td>
                    <td>
                        @if($item->perusahaan)
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-building me-1"></i>{{ Str::limit($item->perusahaan, 30) }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="status-badge status-aktif">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        @else
                            <span class="status-badge status-nonaktif">
                                <i class="fas fa-times-circle me-1"></i>Nonaktif
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            @if($item->facebook)
                                <a href="{{ $item->facebook }}" target="_blank" class="text-primary" title="Facebook">
                                    <i class="fab fa-facebook fa-lg"></i>
                                </a>
                            @endif
                            @if($item->instagram)
                                <a href="{{ $item->instagram }}" target="_blank" class="text-danger" title="Instagram">
                                    <i class="fab fa-instagram fa-lg"></i>
                                </a>
                            @endif
                            @if($item->twitter)
                                <a href="{{ $item->twitter }}" target="_blank" class="text-info" title="Twitter">
                                    <i class="fab fa-twitter fa-lg"></i>
                                </a>
                            @endif
                            @if($item->youtube)
                                <a href="{{ $item->youtube }}" target="_blank" class="text-danger" title="YouTube">
                                    <i class="fab fa-youtube fa-lg"></i>
                                </a>
                            @endif
                            @if($item->linkedin)
                                <a href="{{ $item->linkedin }}" target="_blank" class="text-primary" title="LinkedIn">
                                    <i class="fab fa-linkedin fa-lg"></i>
                                </a>
                            @endif
                            @if($item->tiktok)
                                <a href="{{ $item->tiktok }}" target="_blank" class="text-dark" title="TikTok">
                                    <i class="fab fa-tiktok fa-lg"></i>
                                </a>
                            @endif
                            @if(!$item->facebook && !$item->instagram && !$item->twitter && !$item->youtube && !$item->linkedin && !$item->tiktok)
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <small>{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</small>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('kontak.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('kontak.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="toggleStatus({{ $item->id }}, '{{ $item->status }}')" 
                                    class="btn btn-sm {{ $item->status == 'aktif' ? 'btn-outline-secondary' : 'btn-outline-success' }}" 
                                    title="{{ $item->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fas {{ $item->status == 'aktif' ? 'fa-ban' : 'fa-check-circle' }}"></i>
                            </button>
                            <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('kontak.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                            <form id="toggle-form-{{ $item->id }}" action="{{ route('kontak.toggle-status', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-address-book fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada data kontak</h6>
                        <a href="{{ route('kontak.create') }}" class="btn btn-green btn-sm mt-2">
                            <i class="fas fa-plus me-2"></i>Tambah Kontak
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $kontak->withQueryString()->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data kontak akan dihapus permanen!",
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
    
    function toggleStatus(id, currentStatus) {
        const newStatus = currentStatus == 'aktif' ? 'nonaktif' : 'aktif';
        const title = currentStatus == 'aktif' ? 'Menonaktifkan' : 'Mengaktifkan';
        const confirmText = currentStatus == 'aktif' ? 'Ya, nonaktifkan!' : 'Ya, aktifkan!';
        
        Swal.fire({
            title: `${title} Kontak?`,
            text: `Apakah anda yakin ingin ${title.toLowerCase()} kontak ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: currentStatus == 'aktif' ? '#dc3545' : '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmText,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('toggle-form-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection