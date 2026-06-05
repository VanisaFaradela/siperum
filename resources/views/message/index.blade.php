@extends('layouts.layout')

@section('title', 'Pesan Masuk - SIPERUM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fas fa-envelope me-2 text-success"></i>
        Manajemen Pesan Masuk
    </h4>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-envelope fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Total Pesan</h6>
                    <h3 class="fw-bold mb-0">{{ $totalMessage ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-clock fa-2x text-danger"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Belum Dibaca</h6>
                    <h3 class="fw-bold mb-0">{{ $totalBelumDibaca ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-check-circle fa-2x text-info"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Sudah Dibaca</h6>
                    <h3 class="fw-bold mb-0">{{ $totalSudahDibaca ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card-cluster p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-reply-all fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-cluster p-4 mb-4">
    <form method="GET" action="{{ route('message.index') }}" class="row g-3">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Pesan</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-light" 
                       placeholder="Nama, email, atau subjek..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select bg-light border-0">
                <option value="">Semua Status</option>
                <option value="belum_dibaca" {{ request('status') == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="sudah_dibaca" {{ request('status') == 'sudah_dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                <option value="dibalas" {{ request('status') == 'dibalas' ? 'selected' : '' }}>Dibalas</option>
            </select>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-green w-100">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('message.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sync-alt me-2"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Tabel Pesan -->
<div class="card-cluster p-4">
    <div class="table-responsive">
        <table class="table table-cluster table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th width="120">Aksi</th>
                </thead>
            <tbody>
                @forelse($message as $index => $item)
                <tr class="{{ $item->status == 'belum_dibaca' ? 'fw-bold' : '' }}">
                    <td class="text-center">{{ $message->firstItem() + $index }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->telepon ?? '-' }}</td>
                    <td>{{ $item->subjek }}</td>
                    <td>{{ Str::limit($item->pesan, 50) }}</td>
                    <td>
                        @if($item->status == 'belum_dibaca')
                            <span class="status-badge bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-clock me-1"></i>Belum Dibaca
                            </span>
                        @elseif($item->status == 'sudah_dibaca')
                            <span class="status-badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-check-circle me-1"></i>Sudah Dibaca
                            </span>
                        @else
                            <span class="status-badge status-aktif">
                                <i class="fas fa-reply-all me-1"></i>Dibalas
                            </span>
                        @endif
                    </td>
                    <td>
                        <small>{{ $item->created_at->format('d/m/Y H:i') }}</small>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('message.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('message.destroy', $item->id) }}" 
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
                        <i class="fas fa-envelope fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada pesan masuk</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $message->withQueryString()->links() }}
    </div>
</div>
@endsection