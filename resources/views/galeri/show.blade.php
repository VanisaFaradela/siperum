@extends('galeri.layout')

@section('title', $galeri->judul_galeri . ' - SIPERUM')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-success text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}" class="text-success text-decoration-none">Galeri</a></li>
            <li class="breadcrumb-item active">{{ $galeri->judul_galeri }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card-cluster overflow-hidden mb-4">
            <img src="{{ asset($galeri->foto) }}" class="w-100" alt="{{ $galeri->judul_galeri }}">
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card-cluster p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-success"></i>Detail Foto</h5>
            <table class="table table-sm">
                 <tr>
                    <td width="35%"><strong>Judul</strong></td>
                    <td>{{ $galeri->judul_galeri }}</td>
                </tr>
                <tr>
                    <td><strong>Kategori</strong></td>
                    <td><span class="badge bg-light text-success">{{ ucfirst($galeri->kategori_foto) }}</span></td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>
                        @if($galeri->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Upload</strong></td>
                    <td>{{ optional($galeri->tanggal_upload)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Terakhir Update</strong></td>
                    <td>{{ $galeri->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
        
        
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('galeri.edit', $galeri->id_galeri) }}" class="btn btn-warning flex-grow-1">
                <i class="fas fa-edit me-2"></i>Edit Foto
            </a>
            <button onclick="confirmDelete({{ $galeri->id_galeri }})" class="btn btn-danger flex-grow-1">
                <i class="fas fa-trash me-2"></i>Hapus
            </button>
            <form id="delete-form-{{ $galeri->id_galeri }}" action="{{ route('galeri.destroy', $galeri->id_galeri) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection