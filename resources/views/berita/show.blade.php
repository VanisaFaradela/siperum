@extends('layouts.layout')

@section('title', $berita->judul . ' - SIPERUM')

@section('content')
<!-- Navigasi -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-success">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}" class="text-success">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
        </ol>
    </nav>
</div>

<!-- Detail Berita -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <!-- Gambar Header - PERBAIKAN DI SINI -->
    @php
        $gambarPath = $berita->gambar;
        $gambarExists = $gambarPath && file_exists(public_path($gambarPath));
    @endphp
    
    @if($gambarExists)
        <div class="position-relative" style="height: 400px; overflow: hidden;">
            <img src="{{ asset($gambarPath) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $berita->judul }}">
            <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                <span class="badge bg-success mb-2">{{ $berita->kategori }}</span>
                <h2 class="text-white fw-bold mb-2">{{ $berita->judul }}</h2>
                <div class="text-white-50">
                    <span><i class="far fa-user me-1"></i>{{ $berita->penulis }}</span>
                    <span class="mx-2">•</span>
                    <span><i class="far fa-calendar me-1"></i>{{ $berita->created_at->format('d F Y') }}</span>
                    <span class="mx-2">•</span>
                    <span><i class="far fa-eye me-1"></i>{{ number_format($berita->views) }} views</span>
                </div>
            </div>
        </div>
    @else
        <div class="p-5 text-center" style="background: linear-gradient(135deg, #2ecc71, #27ae60);">
            <span class="badge bg-white text-success mb-3">{{ $berita->kategori }}</span>
            <h2 class="text-white fw-bold mb-3">{{ $berita->judul }}</h2>
            <div class="text-white-50">
                <span><i class="far fa-user me-1"></i>{{ $berita->penulis }}</span>
                <span class="mx-2">•</span>
                <span><i class="far fa-calendar me-1"></i>{{ $berita->created_at->format('d F Y') }}</span>
                <span class="mx-2">•</span>
                <span><i class="far fa-eye me-1"></i>{{ number_format($berita->views) }} views</span>
            </div>
        </div>
    @endif

    <!-- Konten Berita -->
    <div class="p-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="berita-konten fs-5" style="line-height: 1.8;">
                    {!! nl2br($berita->konten) !!}
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <button onclick="confirmDelete({{ $berita->id }})" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                            <form id="delete-form-{{ $berita->id }}" action="{{ route('berita.destroy', $berita->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-success"></i>Status Berita</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status:</span>
                        @if($berita->status == 'published')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Published
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-clock me-1"></i>Draft
                            </span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Views:</span>
                        <span class="fw-bold">{{ number_format($berita->views) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Dibuat:</span>
                        <span>{{ $berita->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Diperbarui:</span>
                        <span>{{ $berita->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <!-- Berita Terkait -->
                @if(isset($beritaTerkait) && $beritaTerkait->count() > 0)
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-newspaper me-2 text-success"></i>Berita Terkait</h6>
                    @foreach($beritaTerkait as $terkait)
                        @php
                            $terkaitGambarPath = $terkait->gambar;
                            $terkaitGambarExists = $terkaitGambarPath && file_exists(public_path($terkaitGambarPath));
                        @endphp
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <a href="{{ route('berita.show', $terkait->slug) }}" class="text-decoration-none">
                                <div class="d-flex gap-3">
                                    @if($terkaitGambarExists)
                                        <img src="{{ asset($terkaitGambarPath) }}" class="rounded" 
                                             style="width: 70px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 70px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="fw-semibold mb-1 text-dark">{{ Str::limit($terkait->judul, 40) }}</h6>
                                        <small class="text-muted">
                                            <i class="far fa-eye me-1"></i>{{ number_format($terkait->views) }} views
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .berita-konten p {
        margin-bottom: 1.5rem;
    }
    
    .berita-konten h1, .berita-konten h2, .berita-konten h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .berita-konten img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 1.5rem 0;
    }
    
    .berita-konten blockquote {
        border-left: 4px solid #2ecc71;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #666;
    }
    
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background: white;
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