@extends('layouts.app')

@section('title', 'Manajemen Promo - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-tags me-2 text-success"></i>
                Manajemen Promo
            </h4>
            <p class="text-muted small mb-0">
                Kelola promo diskon untuk perumahan
            </p>
        </div>
        <a href="{{ route('promo.create') }}" class="btn btn-green">
            <i class="fas fa-plus me-2"></i>Tambah Promo
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-tags fa-2x text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Total Promo</h6>
                        <h3 class="fw-bold mb-0">{{ $totalPromo }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Aktif</h6>
                        <h3 class="fw-bold mb-0">{{ $totalActive }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-clock fa-2x text-secondary"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Expired</h6>
                        <h3 class="fw-bold mb-0">{{ $totalExpired }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Promo -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th>Judul Promo</th>
                            <th>Perumahan</th>
                            <th>Tipe Rumah</th>
                            <th>Harga</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promos as $index => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if($item->gambar && file_exists(public_path($item->gambar)))
                                    <img src="{{ asset($item->gambar) }}" class="rounded" style="width: 50px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                        <i class="fas fa-tag text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->judul_promo }}</strong>
                                <br>
                                <span class="badge bg-danger">{{ $item->badge ?? 'PROMO' }}</span>
                            </td>
                            <td>{{ $item->perumahan->nama_perumahan ?? '-' }}</td>
                            <td>
                                @if($item->tipeRumah->count() > 0)
                                    @foreach($item->tipeRumah as $tipe)
                                        <span class="badge bg-light text-dark me-1">{{ $tipe->nama_tipe }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Semua Tipe</span>
                                @endif
                            </td>
                            <td>
                                @if($item->harga_awal)
                                    <span class="text-decoration-line-through text-muted small">Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</span>
                                    <br>
                                @endif
                                <span class="fw-bold text-danger">Rp {{ number_format($item->harga_promo, 0, ',', '.') }}</span>
                                <br>
                                <span class="badge bg-warning text-dark">-{{ $item->diskon }}%</span>
                            </td>
                            <td style="min-width: 150px;">
                                <small>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ date('d/m/Y', strtotime($item->tanggal_mulai)) }}<br>
                                    <i class="fas fa-calendar-check me-1"></i>
                                    {{ date('d/m/Y', strtotime($item->tanggal_berakhir)) }}
                                </small>
                            </td>
                            <td>
                                @if($item->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($item->status == 'expired')
                                    <span class="badge bg-secondary">Expired</span>
                                @else
                                    <span class="badge bg-warning text-dark">Coming Soon</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('promo.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('promo.destroy', $item->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                                <h6 class="text-muted">Belum ada promo</h6>
                                <a href="{{ route('promo.create') }}" class="btn btn-green btn-sm mt-2">
                                    <i class="fas fa-plus me-2"></i>Tambah Promo
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-0 pb-4 px-4">
            {{ $promos->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Promo akan dihapus permanen!",
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
@endsection