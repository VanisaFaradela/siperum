@extends('layouts.app')

@section('title', 'Edit Tentang Kami - SIPERUM')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit me-2 text-success"></i>
                Edit Halaman Tentang Kami
            </h4>
            <p class="text-muted small mb-0">
                Edit konten halaman tentang kami yang akan tampil di frontend
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('tentang-kami.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- KOLOM KIRI -->
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-success"></i>Tentang Kami</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul</label>
                            <input type="text" name="about_title" class="form-control" value="{{ $about_title }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="about_description" class="form-control" rows="6">{{ $about_description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Visi</label>
                                <textarea name="about_vision" class="form-control" rows="4">{{ $about_vision }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Misi</label>
                                <textarea name="about_mission" class="form-control" rows="4">{{ $about_mission }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar</label>
                            @if($about_image)
                                <div class="mb-2">
                                    <img src="{{ asset($about_image) }}" style="max-height: 150px;" class="border rounded p-1">
                                </div>
                            @endif
                            <input type="file" name="about_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-user me-2 text-success"></i>Owner / Founder</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Owner</label>
                                <input type="text" name="owner_name" class="form-control" value="{{ $owner_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="owner_position" class="form-control" value="{{ $owner_position }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bio / Deskripsi Owner</label>
                            <textarea name="owner_bio" class="form-control" rows="3">{{ $owner_bio }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Owner</label>
                            @if($owner_photo)
                                <div class="mb-2">
                                    <img src="{{ asset($owner_photo) }}" style="max-height: 150px;" class="border rounded p-1">
                                </div>
                            @endif
                            <input type="file" name="owner_photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-globe me-2 text-success"></i>Website</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Website / Perumahan</label>
                            <input type="text" name="website_name" class="form-control" value="{{ $website_name }}">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-phone me-2 text-success"></i>Kontak</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $contact_email }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Telepon</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ $contact_phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">WhatsApp</label>
                            <input type="text" name="contact_whatsapp" class="form-control" value="{{ $contact_whatsapp }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="contact_address" class="form-control" rows="2">{{ $contact_address }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-share-alt me-2 text-success"></i>Sosial Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-facebook text-primary me-2"></i>Facebook</label>
                            <input type="url" name="social_facebook" class="form-control" value="{{ $social_facebook }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-instagram text-danger me-2"></i>Instagram</label>
                            <input type="url" name="social_instagram" class="form-control" value="{{ $social_instagram }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-twitter text-info me-2"></i>Twitter</label>
                            <input type="url" name="social_twitter" class="form-control" value="{{ $social_twitter }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fab fa-youtube text-danger me-2"></i>YouTube</label>
                            <input type="url" name="social_youtube" class="form-control" value="{{ $social_youtube }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-green px-5 py-2">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Summernote not needed for now
</script>
@endpush
@endsection