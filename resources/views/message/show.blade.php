@extends('layouts.app')

@section('title', 'Detail Pesan - SIPERUM')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-success text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('message.index') }}" class="text-success text-decoration-none">Pesan Masuk</a></li>
            <li class="breadcrumb-item active">Detail Pesan</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-envelope me-2 text-success"></i>
                Detail Pesan
            </h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-user me-1 text-success"></i>
                {{ $message->nama }}
            </p>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri (8) -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">
                                <i class="fas fa-envelope me-2 text-success"></i>
                                {{ $message->subjek }}
                            </h4>
                            <p class="text-muted mt-2 mb-0">
                                <i class="fas fa-user me-1"></i> {{ $message->nama }}
                            </p>
                        </div>
                        <div>
                            @if($message->status == 'belum_dibaca')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>Belum Dibaca
                                </span>
                            @elseif($message->status == 'sudah_dibaca')
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Sudah Dibaca
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                    <i class="fas fa-reply-all me-1"></i>Dibalas
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $message->email }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted d-block">Telepon</small>
                                <strong>{{ $message->telepon ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-comment me-2 text-success"></i>Pesan
                        </h6>
                        <div class="border rounded-3 p-4 bg-light">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $message->pesan }}</p>
                        </div>
                    </div>
                    
                    <div class="text-muted small">
                        <i class="fas fa-calendar me-1"></i> Dikirim: {{ $message->created_at->format('d F Y H:i') }}
                        @if($message->dibaca_pada)
                            <span class="ms-3"><i class="fas fa-eye me-1"></i> Dibaca: {{ $message->dibaca_pada->format('d F Y H:i') }}</span>
                        @endif
                        @if($message->dibalas_pada)
                            <span class="ms-3"><i class="fas fa-reply me-1"></i> Dibalas: {{ $message->dibalas_pada->format('d F Y H:i') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($message->balasan)
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-reply-all me-2 text-success"></i>
                        Balasan Anda
                    </h5>
                    <div class="border rounded-3 p-4 bg-light">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->balasan }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Kolom Kanan (4) -->
        <div class="col-md-4">
            @if($message->status != 'dibalas')
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-reply me-2 text-success"></i>
                        Balas Pesan
                    </h5>
                    <form method="POST" action="{{ route('message.reply', $message->id) }}">
                        @csrf
                        <div class="mb-3">
                            <textarea name="balasan" class="form-control" rows="5" placeholder="Tulis balasan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-green w-100">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Balasan
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('message.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button onclick="confirmDelete({{ $message->id }})" class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Pesan
                        </button>
                        <form id="delete-form-{{ $message->id }}" action="{{ route('message.destroy', $message->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Pesan ini akan dihapus permanen!",
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