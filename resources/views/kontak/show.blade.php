@extends('layouts.app')

@section('title', 'Detail Kontak - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-address-card me-2 text-success"></i>
                Detail Kontak
            </h4>
            <p class="text-muted small mb-0">
                Informasi lengkap kontak
            </p>
        </div>
        <div>
            <a href="{{ route('kontak.edit', $kontak->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('kontak.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-info-circle me-2 text-success"></i>Informasi Kontak
                    </h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Nama</strong></td>
                            <td>: {{ $kontak->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ $kontak->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>: {{ $kontak->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Perusahaan</strong></td>
                            <td>: {{ $kontak->perusahaan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            <td>: {{ $kontak->created_at ? $kontak->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Update</strong></td>
                            <td>: {{ $kontak->updated_at ? $kontak->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-share-alt me-2 text-success"></i>Media Sosial
                    </h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Facebook</strong></td>
                            <td>: 
                                @if($kontak->facebook)
                                    <a href="{{ $kontak->facebook }}" target="_blank">{{ $kontak->facebook }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Instagram</strong></td>
                            <td>: 
                                @if($kontak->instagram)
                                    <a href="{{ $kontak->instagram }}" target="_blank">{{ $kontak->instagram }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Twitter</strong></td>
                            <td>: 
                                @if($kontak->twitter)
                                    <a href="{{ $kontak->twitter }}" target="_blank">{{ $kontak->twitter }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>YouTube</strong></td>
                            <td>: 
                                @if($kontak->youtube)
                                    <a href="{{ $kontak->youtube }}" target="_blank">{{ $kontak->youtube }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>LinkedIn</strong></td>
                            <td>: 
                                @if($kontak->linkedin)
                                    <a href="{{ $kontak->linkedin }}" target="_blank">{{ $kontak->linkedin }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>TikTok</strong></td>
                            <td>: 
                                @if($kontak->tiktok)
                                    <a href="{{ $kontak->tiktok }}" target="_blank">{{ $kontak->tiktok }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection