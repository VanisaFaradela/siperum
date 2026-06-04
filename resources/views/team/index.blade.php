@extends('layouts.layout')

@section('title', 'Struktur Organisasi - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-users me-2 text-success"></i>
        Struktur Organisasi
    </h4>
    <a href="{{ route('team.create') }}" class="btn btn-green">
        <i class="fas fa-plus me-2"></i>Tambah Anggota
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Anggota</h6>
                    <h3 class="fw-bold mb-0">{{ $totalTeam ?? 0 }}</h3>
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
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-user-slash fa-2x text-secondary"></i>
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
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-user-tie fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Jabatan</h6>
                    <h3 class="fw-bold mb-0">{{ $totalJabatan ?? $team->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-cluster p-4 mb-4">
    <form method="GET" action="{{ route('team.index') }}" class="row g-3">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Anggota</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Nama atau jabatan..." value="{{ request('search') }}">
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
        
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-green w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('team.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sync-alt me-2"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Tabel Tim -->
<div class="card-cluster p-4">
    <div class="table-responsive">
        <table class="table table-cluster table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="70">Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
                </thead>
            <tbody>
                @forelse($team as $index => $item)
                <tr>
                    <td class="text-center">{{ $team->firstItem() + $index }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ route('media.team', basename($item->foto)) }}"
                                class="rounded-circle"
                                style="width:50px;height:50px;object-fit:cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width:50px;height:50px;">
                                <i class="fas fa-user fa-2x text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->nama }}</strong>
                    </td>
                    <td>{{ $item->jabatan }}</td>
                    <td>
                        @if($item->email)
                            <small><i class="fas fa-envelope me-1"></i>{{ Str::limit($item->email, 25) }}</small>
                        @endif
                        @if($item->telepon)
                            <br><small><i class="fas fa-phone me-1"></i>{{ $item->telepon }}</small>
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
                        <div class="btn-group">
                            <a href="{{ route('team.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('team.destroy', $item->id) }}" 
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada anggota tim</h6>
                        <a href="{{ route('team.create') }}" class="btn btn-green btn-sm mt-2">
                            <i class="fas fa-plus me-2"></i>Tambah Anggota Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $team->withQueryString()->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data anggota tim akan dihapus permanen!",
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