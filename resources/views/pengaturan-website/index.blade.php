@extends('layouts.app')

@section('title', 'Pengaturan Website - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-globe me-2 text-success"></i>
                Pengaturan Website
            </h4>
            <p class="text-muted small mb-0">
                Kelola informasi website, kontak, slider, dan sosial media
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="umum-tab" data-bs-toggle="tab" data-bs-target="#umum" type="button" role="tab">
                <i class="fas fa-user me-2"></i>Data Umum
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tentang-tab" data-bs-toggle="tab" data-bs-target="#tentang" type="button" role="tab">
                <i class="fas fa-info-circle me-2"></i>Tentang Kami
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kontak-tab" data-bs-toggle="tab" data-bs-target="#kontak" type="button" role="tab">
                <i class="fas fa-phone me-2"></i>Kontak
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sosial-tab" data-bs-toggle="tab" data-bs-target="#sosial" type="button" role="tab">
                <i class="fas fa-share-alt me-2"></i>Sosial Media
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="slider-tab" data-bs-toggle="tab" data-bs-target="#slider" type="button" role="tab">
                <i class="fas fa-images me-2"></i>Slider Foto
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB 1: Data Umum -->
        <div class="tab-pane fade show active" id="umum" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-user me-2 text-success"></i>Data Pemilik Website</h5>
                    <form method="POST" action="{{ route('pengaturan-website.umum') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Pemilik</label>
                                <input type="text" name="owner_name" class="form-control" value="{{ $owner_name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="owner_phone" class="form-control" value="{{ $owner_phone }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="owner_email" class="form-control" value="{{ $owner_email }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="owner_address" class="form-control" rows="2" required>{{ $owner_address }}</textarea>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-green">
                                <i class="fas fa-save me-2"></i>Simpan Data Umum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 2: Tentang Kami -->
        <div class="tab-pane fade" id="tentang" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-info-circle me-2 text-success"></i>Tentang Website</h5>
                    <form method="POST" action="{{ route('pengaturan-website.tentang') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tentang Kami</label>
                            <textarea name="tentang_kami" class="form-control summernote" rows="5">{{ $tentang_kami }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Visi</label>
                            <textarea name="visi" class="form-control" rows="3">{{ $visi }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Misi</label>
                            <textarea name="misi" class="form-control" rows="5">{{ $misi }}</textarea>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-green">
                                <i class="fas fa-save me-2"></i>Simpan Tentang Kami
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 3: Kontak -->
        <div class="tab-pane fade" id="kontak" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-phone me-2 text-success"></i>Informasi Kontak</h5>
                    <form method="POST" action="{{ route('pengaturan-website.kontak') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ $contact_phone }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">WhatsApp</label>
                                <input type="text" name="contact_whatsapp" class="form-control" value="{{ $contact_whatsapp }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="contact_email" class="form-control" value="{{ $contact_email }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="contact_address" class="form-control" rows="2" required>{{ $contact_address }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Instagram</label>
                                <input type="text" name="contact_instagram" class="form-control" value="{{ $contact_instagram }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Facebook</label>
                                <input type="text" name="contact_facebook" class="form-control" value="{{ $contact_facebook }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">YouTube</label>
                                <input type="url" name="contact_youtube" class="form-control" value="{{ $contact_youtube }}">
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-green">
                                <i class="fas fa-save me-2"></i>Simpan Kontak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 4: Sosial Media -->
        <div class="tab-pane fade" id="sosial" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-share-alt me-2 text-success"></i>Link Sosial Media</h5>
                    <form method="POST" action="{{ route('pengaturan-website.sosial') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-facebook me-2 text-primary"></i>Facebook</label>
                            <input type="url" name="social_facebook" class="form-control" value="{{ $social_facebook }}" placeholder="https://facebook.com/username">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-instagram me-2 text-danger"></i>Instagram</label>
                            <input type="url" name="social_instagram" class="form-control" value="{{ $social_instagram }}" placeholder="https://instagram.com/username">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-twitter me-2 text-info"></i>Twitter</label>
                            <input type="url" name="social_twitter" class="form-control" value="{{ $social_twitter }}" placeholder="https://twitter.com/username">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-youtube me-2 text-danger"></i>YouTube</label>
                            <input type="url" name="social_youtube" class="form-control" value="{{ $social_youtube }}" placeholder="https://youtube.com/@channel">
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-green">
                                <i class="fas fa-save me-2"></i>Simpan Sosial Media
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 5: Slider Foto -->
        <div class="tab-pane fade" id="slider" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-images me-2 text-success"></i>Slide Foto</h5>
                        <button type="button" class="btn btn-green btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSlider">
                            <i class="fas fa-plus me-2"></i>Tambah Slide
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Gambar</th>
                                    <th>Judul</th>
                                    <th>Subjudul</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="slider-sortable">
                                @foreach($sliders as $index => $slider)
                                <tr data-id="{{ $slider->id }}">
                                    <td class="text-center">
                                        <i class="fas fa-grip-vertical text-muted me-2" style="cursor: move;"></i>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <img src="{{ asset($slider->gambar) }}" style="width: 80px; height: 50px; object-fit: cover;" class="rounded">
                                    </td>
                                    <td>{{ $slider->judul }}</td>
                                    <td>{{ $slider->subjudul ?? '-' }}</td>
                                    <td>
                                        @if($slider->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditSlider{{ $slider->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('pengaturan-website.slider.delete', $slider->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus slide ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Slider -->
<div class="modal fade" id="modalTambahSlider" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Slide Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('pengaturan-website.slider.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subjudul</label>
                        <input type="text" name="subjudul" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link (opsional)</label>
                        <input type="url" name="link" class="form-control" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar <span class="text-danger">*</span></label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG. Maks: 5MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-green">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Slider -->
@foreach($sliders as $slider)
<div class="modal fade" id="modalEditSlider{{ $slider->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Slide</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('pengaturan-website.slider.update', $slider->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ $slider->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subjudul</label>
                        <input type="text" name="subjudul" class="form-control" value="{{ $slider->subjudul }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link (opsional)</label>
                        <input type="url" name="link" class="form-control" value="{{ $slider->link }}" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <img src="{{ asset($slider->gambar) }}" style="width: 100%; max-height: 150px; object-fit: cover;" class="rounded mb-2">
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" {{ $slider->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $slider->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-green">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
    }
    
    .nav-tabs .nav-link.active {
        color: #2e7d32;
        border-bottom: 3px solid #2e7d32;
        background: transparent;
    }
    
    .summernote {
        border-radius: 0.5rem;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });
    });
    
    // Sortable untuk slider
    var el = document.getElementById('slider-sortable');
    if (el) {
        var sortable = Sortable.create(el, {
            onEnd: function() {
                var order = [];
                document.querySelectorAll('#slider-sortable tr').forEach(function(row, index) {
                    order.push(row.dataset.id);
                });
                
                fetch('{{ route("pengaturan-website.slider.order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    }
</script>
@endpush
@endsection